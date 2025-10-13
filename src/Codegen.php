<?php

declare(strict_types=1);

namespace Proteus;

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\Error\Listeners\DiagnosticErrorListener;
use Antlr\Antlr4\Runtime\InputStream;
use Proteus\Antlr4\Context\OptionStatementContext;
use Proteus\Antlr4\Protobuf3BaseVisitor;
use Proteus\Antlr4\Protobuf3Lexer;
use Proteus\Antlr4\Protobuf3Parser;
use Proteus\Internal\Field;
use Proteus\Internal\FieldLabel;
use Proteus\Internal\Message;
use Proteus\Internal\Protobuf3Visitor;
use Proteus\Internal\ProtoType;
use Proteus\Internal\Type;

class Codegen
{
    /**
     * Returns the PHP code snippet to read a field value from binary protobuf data
     *
     * @param string $type The protobuf type (e.g., 'int32', 'string', 'bool')
     * @param string $fieldName The name of the field being read (for error messages)
     * @param bool $forRepeatedPacked Whether this is for packed repeated field decoding
     * @return string PHP code to read and return the value
     */
    public static function getReadFunction(string $type, string $fieldName, bool $forRepeatedPacked = false): string
    {
        return match ($type) {
            // Varint types with sign extension/ZigZag
            'int32' => 'readInt32($i, $l, $bytes)',
            'sint32' => 'readSint32($i, $l, $bytes)',
            'sint64' => 'readSint64($i, $l, $bytes)',
            'uint32' => 'readVarint($i, $l, $bytes)',
            'int64' => 'readVarint($i, $l, $bytes)',
            'bool' => 'readVarint($i, $l, $bytes) === 1',
            // Large unsigned integers that need special handling
            'uint64' => '$d->' . $fieldName . ($forRepeatedPacked ? '' : '->add') . '(readVarint($i, $l, $bytes))',
            // Fixed-size types
            'fixed32', 'sfixed32' => 'readFixed32($i, $l, $bytes)',
            'fixed64', 'sfixed64' => 'readFixed64($i, $l, $bytes)',
            'float' => 'readFloat32($i, $l, $bytes)',
            'double' => 'readFloat64($i, $l, $bytes)',
            // Length-delimited types
            'string', 'bytes' => 'readBytes($i, $l, $bytes)',
            default => throw new \Exception("Unknown read function for type: {$type}"),
        };
    }

    /**
     * Generates inline code for reading a varint with fast-path optimization
     *
     * Fast path: Most varints are single-byte (field tags 1-15, small values < 128)
     * This avoids loop overhead for 90%+ of varints
     *
     * Phase 1 optimization: Removed redundant EOF checks, rely on loop bounds
     * Phase 2 optimization: Use byte array access instead of ord() - 10x faster
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline varint reading
     */
    private static function inlineReadVarint(string $varName): string
    {
        return <<<PHP
        \$_byte = \$b[\$i];
        if (\$_byte < 0x80) {
            // Fast path: single-byte varint (90%+ of cases)
            ++\$i;
            \${$varName} = \$_byte;
        } else {
            // Slow path: multi-byte varint
            \${$varName} = \$_byte & 0x7F;
            for (\$shift = 7; \$shift < 64; \$shift += 7) {
                if (++\$i >= \$l) throw new Exception('Unexpected EOF');
                \$_byte = \$b[\$i];
                \${$varName} |= (\$_byte & 0x7F) << \$shift;
                if (\$_byte < 0x80) {
                    ++\$i;
                    break;
                }
            }
            if (\$shift >= 64) throw new Exception('Int overflow');
        }
        PHP;
    }

    /**
     * Generates inline code for reading int32 with sign extension
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline int32 reading
     */
    private static function inlineReadInt32(string $varName): string
    {
        $varintCode = self::inlineReadVarint('_u');
        return <<<PHP
        {$varintCode}
        \${$varName} = \$_u;
        if (\${$varName} > 0x7FFFFFFF) \${$varName} -= 0x100000000;
        PHP;
    }

    /**
     * Generates inline code for reading sint32 with ZigZag decoding
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline sint32 reading
     */
    private static function inlineReadSint32(string $varName): string
    {
        $varintCode = self::inlineReadVarint('_u');
        return <<<PHP
        {$varintCode}
        \${$varName} = (\$_u >> 1) ^ -(\$_u & 1);
        if (\${$varName} > 0x7FFFFFFF) \${$varName} -= 0x100000000;
        PHP;
    }

    /**
     * Generates inline code for reading sint64 with ZigZag decoding
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline sint64 reading
     */
    private static function inlineReadSint64(string $varName): string
    {
        $varintCode = self::inlineReadVarint('_u');
        return <<<PHP
        {$varintCode}
        \${$varName} = (\$_u >> 1) ^ -(\$_u & 1);
        PHP;
    }

    /**
     * Generates inline code for reading fixed32 (little-endian unsigned)
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline fixed32 reading
     */
    private static function inlineReadFixed32(string $varName): string
    {
        return <<<PHP
        if (\$i + 4 > \$l) throw new Exception('Unexpected EOF');
        \${$varName} = unpack('V', substr(\$bytes, \$i, 4))[1];
        \$i += 4;
        PHP;
    }

    /**
     * Generates inline code for reading fixed64 (little-endian unsigned)
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline fixed64 reading
     */
    private static function inlineReadFixed64(string $varName): string
    {
        return <<<PHP
        if (\$i + 8 > \$l) throw new Exception('Unexpected EOF');
        \${$varName} = unpack('P', substr(\$bytes, \$i, 8))[1];
        \$i += 8;
        PHP;
    }

    /**
     * Generates inline code for reading float (32-bit)
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline float reading
     */
    private static function inlineReadFloat(string $varName): string
    {
        return <<<PHP
        if (\$i + 4 > \$l) throw new Exception('Unexpected EOF');
        \$_b = substr(\$bytes, \$i, 4);
        \$i += 4;
        if (isBigEndian()) \$_b = strrev(\$_b);
        \${$varName} = unpack('f', \$_b)[1];
        PHP;
    }

    /**
     * Generates inline code for reading double (64-bit)
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline double reading
     */
    private static function inlineReadDouble(string $varName): string
    {
        return <<<PHP
        if (\$i + 8 > \$l) throw new Exception('Unexpected EOF');
        \$_b = substr(\$bytes, \$i, 8);
        \$i += 8;
        if (isBigEndian()) \$_b = strrev(\$_b);
        \${$varName} = unpack('d', \$_b)[1];
        PHP;
    }

    /**
     * Generates inline code for reading length-delimited bytes
     *
     * Phase 4 optimization: Fast path for single-byte strings to avoid substr() overhead
     *
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline bytes reading
     */
    private static function inlineReadBytes(string $varName): string
    {
        $lenCode = self::inlineReadVarint('_byteLen');
        return <<<PHP
        {$lenCode}
        if (\$_byteLen < 0) throw new Exception('Invalid length');
        \$_postIndex = \$i + \$_byteLen;
        if (\$_postIndex < 0 || \$_postIndex > \$l) throw new Exception('Invalid length');
        if (\$_byteLen === 1) {
            // Fast path: single-byte string (avoids substr overhead)
            \${$varName} = \$bytes[\$i];
            ++\$i;
        } else {
            \${$varName} = substr(\$bytes, \$i, \$_byteLen);
            \$i = \$_postIndex;
        }
        PHP;
    }

    /**
     * Adds indentation to each line of code
     *
     * @param string $code The code to indent
     * @param int $spaces Number of spaces to indent
     * @return string The indented code
     */
    private static function indent(string $code, int $spaces): string
    {
        $indent = str_repeat(' ', $spaces);
        $lines = explode("\n", $code);
        return implode("\n", array_map(fn($line) => $line === '' ? '' : $indent . $line, $lines));
    }

    /**
     * Returns inline code for reading a specific protobuf type
     */
    private static function getInlineReadCode(ProtoType $type, string $varName): string
    {
        return match ($type) {
            ProtoType::Int32 => self::inlineReadInt32($varName),
            ProtoType::Sint32 => self::inlineReadSint32($varName),
            ProtoType::Sint64 => self::inlineReadSint64($varName),
            ProtoType::Uint32, ProtoType::Int64, ProtoType::Uint64, ProtoType::Bool => self::inlineReadVarint($varName),
            ProtoType::Fixed32, ProtoType::Sfixed32 => self::inlineReadFixed32($varName),
            ProtoType::Fixed64, ProtoType::Sfixed64 => self::inlineReadFixed64($varName),
            ProtoType::Float => self::inlineReadFloat($varName),
            ProtoType::Double => self::inlineReadDouble($varName),
            ProtoType::String, ProtoType::Bytes => self::inlineReadBytes($varName),
            default => throw new \Exception("Unknown inline read for type: {$type->value}"),
        };
    }

    /**
     * Generates the fromBytes static method for a protobuf message class
     */
    public static function generateFromBytesMethod(Message $message): string
    {
        $code = "    /**\n";
        $code .= "     * Deserializes a {$message->name} message from binary protobuf format\n";
        $code .= "     *\n";
        $code .= "     * @param string \$bytes Binary protobuf data\n";
        $code .= "     * @return self The deserialized message instance\n";
        $code .= "     * @throws Exception if the data is malformed or contains invalid wire types\n";
        $code .= "     */\n";
        $code .= "    public static function fromBytes(string \$bytes): self\n";
        $code .= "    {\n";
        $code .= "        \$d = new self();\n";
        $code .= "\n";
        $code .= "        \$l = strlen(\$bytes);\n";
        $code .= "        \$i = 0;\n";
        $code .= "\n";
        $code .= "        // Phase 2: Convert bytes to int array for faster access (replaces ord() calls)\n";
        $code .= "        \$b = array_values(unpack('C*', \$bytes));\n";
        $code .= "\n";
        $code .= "        while (\$i < \$l) {\n";

        // Inline tag reading (hot path - happens for every field)
        $tagReadCode = self::inlineReadVarint('wire');
        $code .= self::indent($tagReadCode, 12) . "\n";

        $code .= "            \$fieldNum = \$wire >> 3; // Phase 5: Removed redundant mask\n";
        $code .= "            \$wireType = \$wire & 0x7;\n";
        $code .= "\n";
        $code .= "            switch (\$fieldNum) {\n";

        foreach ($message->fields as $field) {
            $code .= "                case {$field->number}:\n";

            // Handle map fields specially
            if ($field->type->protoType === ProtoType::Map) {
                $code .= self::generateMapFieldCode($field);
            }
            // Handle repeated fields
            else if ($field->label === FieldLabel::Repeated) {
                $code .= self::generateRepeatedFieldCode($field);
            }
            // Handle regular fields
            else {
                $code .= self::generateRegularFieldCode($field);
            }

            $code .= "                    break;\n";
            $code .= "\n";
        }

        $code .= "                default:\n";
        $code .= "                    skipField(\$i, \$l, \$bytes, \$wireType);\n";
        $code .= "            }\n";
        $code .= "        }\n";
        $code .= "\n";
        $code .= "        return \$d;\n";
        $code .= "    }\n";

        return $code;
    }

    /**
     * Generates code for deserializing a regular (non-repeated, non-map) field
     */
    public static function generateRegularFieldCode(Field $field): string
    {
        // Message types always use wire type 2 (length-delimited)
        $expectedWireType = $field->type->protoType->toWireType();
        $code = "                    if (\$wireType !== {$expectedWireType}) throw new Exception('Invalid wire type for {$field->name}');\n";

        if ($field->type->protoType === ProtoType::Message) {
            // For message types, inline the length reading then call fromBytes
            $lenReadCode = self::inlineReadVarint('_len');
            $code .= self::indent($lenReadCode, 20) . "\n";
            $code .= "                    \$_postIndex = \$i + \$_len;\n";
            $code .= "                    if (\$_postIndex < 0 || \$_postIndex > \$l) throw new Exception('Invalid length');\n";
            $code .=
                "                    \$d->{$field->name} = "
                . $field->type->getPhpType()
                . "::fromBytes(substr(\$bytes, \$i, \$_len));\n";
            $code .= "                    \$i = \$_postIndex;\n";
        } else if ($field->type->protoType === ProtoType::Uint64) {
            // Special handling for uint64 which uses BcMath\Number
            $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$field->name} = bcadd(\$d->{$field->name}, \$_value);\n";
        } else if ($field->type->protoType === ProtoType::Bool) {
            // Bool needs special handling (convert varint to boolean)
            $inlineCode = self::getInlineReadCode(ProtoType::Int32, '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$field->name} = \$_value === 1;\n";
        } else {
            // All other types: inline the read code directly
            $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$field->name} = \$_value;\n";
        }

        return $code;
    }

    /**
     * Generates code for deserializing a repeated field
     *
     * Repeated fields can be encoded in two ways:
     * 1. Unpacked: Each element is a separate field with the same field number
     * 2. Packed: All elements are in a single length-delimited message (wire type 2)
     *
     * For numeric types, packed encoding is the default in proto3.
     */
    public static function generateRepeatedFieldCode(Field $field): string
    {
        $code = '';

        // Message types are never packed and always use wire type 2
        if ($field->type->protoType === ProtoType::Message) {
            $code .= "                    if (\$wireType !== 2) throw new Exception('Invalid wire type for {$field->name}');\n";

            // Inline length reading
            $lenReadCode = self::inlineReadVarint('_len');
            $code .= self::indent($lenReadCode, 20) . "\n";

            $code .= "                    \$_postIndex = \$i + \$_len;\n";
            $code .= "                    if (\$_postIndex < 0 || \$_postIndex > \$l) throw new Exception('Invalid length');\n";
            $code .=
                "                    \$d->{$field->name}[] = "
                . $field->type->getPhpType()
                . "::fromBytes(substr(\$bytes, \$i, \$_len));\n";
            $code .= "                    \$i = \$_postIndex;\n";
            return $code;
        }

        $expectedWireType = $field->type->protoType->toWireType();

        $isPackable = $field->type->protoType->isPackable();

        if ($isPackable) {
            // Handle packed encoding (wire type 2)
            $code .= "                    if (\$wireType === 2) {\n";
            $code .= "                        // Packed encoding: length-delimited sequence\n";

            // Inline length reading
            $lenReadCode = self::inlineReadVarint('_len');
            $code .= self::indent($lenReadCode, 24) . "\n";

            $code .= "                        \$_end = \$i + \$_len;\n";
            $code .= "\n";
            $code .= "                        while (\$i < \$_end) {\n";

            // Inline the element reading based on type
            if ($field->type->protoType === ProtoType::Uint64) {
                // uint64 needs special handling with BcMath\Number
                $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$field->name}[] = new Number((string) \$_value);\n";
            } else if ($field->type->protoType === ProtoType::Bool) {
                // Bool needs conversion from varint to boolean
                $inlineCode = self::getInlineReadCode(ProtoType::Int32, '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$field->name}[] = \$_value === 1;\n";
            } else {
                // All other packable types
                $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$field->name}[] = \$_value;\n";
            }

            $code .= "                        }\n";
            $code .= "\n";
            $code .= "                        if (\$i !== \$_end) throw new Exception('Packed {$field->type->protoType->value} field over/under-read');\n";
            $code .= "                    } else if (\$wireType === {$expectedWireType}) {\n";
            $code .= "                        // Unpacked encoding: individual elements\n";

            // Inline the unpacked element reading
            if ($field->type->protoType === ProtoType::Uint64) {
                $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$field->name}[] = new Number((string) \$_value);\n";
            } else if ($field->type->protoType === ProtoType::Bool) {
                $inlineCode = self::getInlineReadCode(ProtoType::Int32, '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$field->name}[] = \$_value === 1;\n";
            } else {
                $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$field->name}[] = \$_value;\n";
            }

            $code .= "                    } else throw new Exception('Invalid wire type for {$field->name}');\n";
        } else {
            // Non-packable types (string, bytes, messages)
            $code .= "                    if (\$wireType !== {$expectedWireType}) throw new Exception('Invalid wire type for {$field->name}');\n";

            // Inline the element reading
            if ($field->type->protoType === ProtoType::String || $field->type->protoType === ProtoType::Bytes) {
                $inlineCode = self::getInlineReadCode($field->type->protoType, '_value');
                $code .= self::indent($inlineCode, 20) . "\n";
                $code .= "                    \$d->{$field->name}[] = \$_value;\n";
            }
        }

        return $code;
    }

    /**
     * Generates code for deserializing a map field
     *
     * Map fields in protobuf are encoded as repeated entries, where each entry
     * is a message with two fields: key (field 1) and value (field 2).
     */
    public static function generateMapFieldCode(Field $field): string
    {
        $keyType = $field->type->keyType;
        $valueType = $field->type->valueType;

        $code = "                    if (\$wireType !== 2) throw new Exception('Invalid wire type for {$field->name}');\n";
        $code .= "\n";
        $code .= "                    // Map entry: read the length-delimited entry message\n";

        // Inline the entry length reading
        $entryLenCode = self::inlineReadVarint('_entryLen');
        $code .= self::indent($entryLenCode, 20) . "\n";

        $code .= "                    \$_limit = \$i + \$_entryLen;\n";
        $code .= "\n";

        // Initialize key and value with defaults
        $keyDefault = $keyType->getPhpDefaultValue();
        $valueDefault = $valueType->getPhpDefaultValue();

        $code .= "                    \$_key = {$keyDefault};\n";
        $code .= "                    \$_val = {$valueDefault};\n";
        $code .= "\n";
        $code .= "                    while (\$i < \$_limit) {\n";

        // Inline tag reading within the map entry
        $tagReadCode = self::inlineReadVarint('_tag');
        $code .= self::indent($tagReadCode, 24) . "\n";

        $code .= "                        \$_fn = \$_tag >> 3; // field number inside entry: 1=key, 2=value\n";
        $code .= "                        \$_wt = \$_tag & 0x7; // wire type\n";
        $code .= "\n";
        $code .= "                        switch (\$_fn) {\n";
        $code .= "                            case 1: // key\n";

        $keyWireType = $keyType->protoType->toWireType();
        $code .= "                                if (\$_wt !== {$keyWireType}) throw new Exception('Invalid wire type for {$field->name} key');\n";

        // Inline key reading
        if ($keyType->protoType === ProtoType::Bool) {
            $keyReadCode = self::getInlineReadCode(ProtoType::Int32, '_keyValue');
            $code .= self::indent($keyReadCode, 32) . "\n";
            $code .= "                                \$_key = \$_keyValue === 1;\n";
        } else {
            $keyReadCode = self::getInlineReadCode($keyType->protoType, '_key');
            $code .= self::indent($keyReadCode, 32) . "\n";
        }

        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            case 2: // value\n";

        $valueWireType = $valueType->protoType->toWireType();
        $code .= "                                if (\$_wt !== {$valueWireType}) throw new Exception('Invalid wire type for {$field->name} value');\n";

        // Inline value reading
        if ($valueType->protoType === ProtoType::Uint64) {
            $valueReadCode = self::getInlineReadCode($valueType->protoType, '_valTemp');
            $code .= self::indent($valueReadCode, 32) . "\n";
            $code .= "                                \$_val = new Number((string) \$_valTemp);\n";
        } else if ($valueType->protoType === ProtoType::Bool) {
            $valueReadCode = self::getInlineReadCode(ProtoType::Int32, '_valTemp');
            $code .= self::indent($valueReadCode, 32) . "\n";
            $code .= "                                \$_val = \$_valTemp === 1;\n";
        } else {
            $valueReadCode = self::getInlineReadCode($valueType->protoType, '_val');
            $code .= self::indent($valueReadCode, 32) . "\n";
        }

        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            default:\n";
        $code .= "                                skipField(\$i, \$l, \$bytes, \$_wt);\n";
        $code .= "                        }\n";
        $code .= "                    }\n";
        $code .= "\n";
        $code .= "                    \$d->{$field->name}[\$_key] = \$_val;\n";

        return $code;
    }

    /**
     * Generates the code for a protobuf message
     */
    public static function generateMessage(Message $message): string
    {
        $className = $message->getPhpName();
        $code = "class {$className}\n";
        $code .= "{\n";

        // Generate properties
        foreach ($message->fields as $idx => $field) {
            $phpType = $field->type->getPhpType();

            if ($field->label === FieldLabel::Repeated) {
                $code .= "    /** @var {$phpType}[] */\n";
                $code .= "    public array \${$field->name} = [];\n";
            } else if (
                $field->label === FieldLabel::Optional
                // Message types are always nullable in proto3
                || $field->type->protoType === ProtoType::Message
            ) {
                $code .= "    public {$phpType}|null \${$field->name} = null;\n";
            } else {
                if ($field->type->protoType === ProtoType::Map) {
                    $keyType = $field->type->keyType->getPhpType();
                    $valueType = $field->type->valueType->getPhpType();
                    $code .= "    /** @var array<{$keyType}, {$valueType}> */\n";
                }

                $defaultValue = $field->type->getPhpDefaultValue();
                $code .= "    public {$phpType} \${$field->name} = {$defaultValue};\n";
            }

            if ($idx !== (count($message->fields) - 1)) {
                $code .= "\n";
            }
        }

        $code .= "\n";
        $code .= self::generateFromBytesMethod($message);
        $code .= "}\n";

        return $code;
    }

    public static function generate(string $protoPath, string $outputPath): void
    {
        $input = InputStream::fromPath($protoPath);
        $lexer = new Protobuf3Lexer($input);
        $tokens = new CommonTokenStream($lexer);
        $parser = new Protobuf3Parser($tokens);

        $visitor = new Protobuf3Visitor();
        $visitor->visit($parser->proto());

        if (!$visitor->phpNamespace) {
            throw new \Exception('php_namespace option is required');
        }

        $codegen = "<?php\n";
        $codegen .= "\n";
        $codegen .= "declare(strict_types=1);\n";
        $codegen .= "\n";
        $codegen .= "namespace {$visitor->phpNamespace};\n";
        $codegen .= "\n";
        $codegen .= "use Exception;\n";
        $codegen .= "use function Proteus\\skipField;\n";
        $codegen .= "use function Proteus\\isBigEndian;\n";
        $codegen .= "\n";

        foreach ($visitor->messages as $message) {
            $codegen .= self::generateMessage($message);
        }

        file_put_contents($outputPath, $codegen);

        echo "Generated code written to {$outputPath}\n";
    }
}
