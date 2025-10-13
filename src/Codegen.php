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

class Codegen
{
    public static function protoToPhpType(string $type, bool $isMessageType = false): string
    {
        return match ($type) {
            'int32',
            'sint32',
            'sfixed32',
            //
            'int64',
            'sint64',
            'sfixed64',
            //
            'uint32',
            'fixed32',
                => 'int',
            //
            'uint64', 'fixed64' => 'Number',
            //
            'float', 'double' => 'float',
            //
            'bool' => 'bool',
            //
            'string', 'bytes' => 'string',
            //
            'map' => 'array',
            //
            default => $isMessageType ? $type : throw new \Exception("Unknown type: {$type}"),
        };
    }

    public static function isPrimitiveType(string $type): bool
    {
        return in_array($type, [
            'int32',
            'sint32',
            'sfixed32',
            'int64',
            'sint64',
            'sfixed64',
            'uint32',
            'fixed32',
            'uint64',
            'fixed64',
            'float',
            'double',
            'bool',
            'string',
            'bytes',
            'map',
        ]);
    }

    /**
     * Checks if a field type can be packed when repeated
     *
     * In proto3, repeated numeric fields are packed by default.
     * String, bytes, and message types cannot be packed.
     *
     * @param string $type The protobuf type
     * @return bool True if the type can be packed
     */
    public static function isPackableType(string $type): bool
    {
        return in_array($type, [
            'int32',
            'sint32',
            'uint32',
            'int64',
            'sint64',
            'uint64',
            'fixed32',
            'sfixed32',
            'fixed64',
            'sfixed64',
            'float',
            'double',
            'bool',
        ]);
    }

    public static function isPhpKeyword(string $testString): bool
    {
        // First check it's actually a word and not an expression/number
        if (!preg_match('/^[a-z]+$/i', $testString)) {
            return false;
        }
        $tokenised = token_get_all('<?php ' . $testString . '; ?>');
        // tokenised[0] = opening PHP tag, tokenised[1] = our test string
        return reset($tokenised[1]) !== T_STRING;
    }

    public static function protoNameToPhpName(string $name): string
    {
        if (self::isPhpKeyword($name)) {
            return self::protoNameToPhpName($name . '_');
        }

        return $name;
    }

    public static function defaultPhpTypeValue(string $type): string
    {
        return match ($type) {
            'int' => '0',
            'Number' => 'DEFAULT_UINT64',
            'float' => '0.0',
            'bool' => 'false',
            'string' => '\'\'',
            'array' => '[]',
            default => throw new \Exception("Unknown type: {$type}"),
        };
    }

    /**
     * Maps protobuf wire types to their numeric identifiers
     *
     * Wire types in protobuf:
     * 0 = VARINT (int32, int64, uint32, uint64, sint32, sint64, bool, enum)
     * 1 = 64-BIT (fixed64, sfixed64, double)
     * 2 = LENGTH_DELIMITED (string, bytes, embedded messages, packed repeated fields)
     * 5 = 32-BIT (fixed32, sfixed32, float)
     */
    public static function protoTypeToWireType(string $type): int
    {
        return match ($type) {
            // Varint encoded (wire type 0)
            'int32', 'sint32', 'uint32', 'int64', 'sint64', 'uint64', 'bool' => 0,
            // 64-bit (wire type 1)
            'fixed64', 'sfixed64', 'double' => 1,
            // Length-delimited (wire type 2)
            'string', 'bytes', 'map' => 2,
            // 32-bit (wire type 5)
            'fixed32', 'sfixed32', 'float' => 5,
            default => throw new \Exception("Unknown wire type for proto type: {$type}"),
        };
    }

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
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for inline varint reading
     */
    private static function inlineReadVarint(string $varName): string
    {
        return <<<PHP
        if (\$i >= \$l) throw new Exception('Unexpected EOF');
        \$b = ord(\$bytes[\$i]);
        if (\$b < 0x80) {
            // Fast path: single-byte varint (90%+ of cases)
            ++\$i;
            \${$varName} = \$b;
        } else {
            // Slow path: multi-byte varint
            \${$varName} = \$b & 0x7F;
            for (\$shift = 7;; \$shift += 7) {
                if (++\$i >= \$l) throw new Exception('Unexpected EOF');
                if (\$shift >= 64) throw new Exception('Int overflow');
                \$b = ord(\$bytes[\$i]);
                \${$varName} |= (\$b & 0x7F) << \$shift;
                if (\$b < 0x80) {
                    ++\$i;
                    break;
                }
            }
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
        if (\$_postIndex < 0) throw new Exception('Invalid length');
        if (\$_postIndex > \$l) throw new Exception('Unexpected EOF');
        \${$varName} = substr(\$bytes, \$i, \$_byteLen);
        \$i = \$_postIndex;
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
     *
     * @param string $type The protobuf type
     * @param string $varName The variable name to store the result
     * @return string PHP code snippet for reading the type
     */
    private static function getInlineReadCode(string $type, string $varName): string
    {
        return match ($type) {
            'int32' => self::inlineReadInt32($varName),
            'sint32' => self::inlineReadSint32($varName),
            'sint64' => self::inlineReadSint64($varName),
            'uint32', 'int64', 'uint64', 'bool' => self::inlineReadVarint($varName),
            'fixed32', 'sfixed32' => self::inlineReadFixed32($varName),
            'fixed64', 'sfixed64' => self::inlineReadFixed64($varName),
            'float' => self::inlineReadFloat($varName),
            'double' => self::inlineReadDouble($varName),
            'string', 'bytes' => self::inlineReadBytes($varName),
            default => throw new \Exception("Unknown inline read for type: {$type}"),
        };
    }

    /**
     * Generates the fromBytes static method for a protobuf message class
     *
     * This method creates a deserializer that:
     * - Parses binary protobuf wire format
     * - Handles all field types (varint, fixed, length-delimited)
     * - Supports repeated fields (packed and unpacked)
     * - Supports map fields
     * - Skips unknown fields for forward compatibility
     *
     * @param array{name: string, fields: array{name: string, type: string, label: string, number: string, meta?: array<string, string>}[]} $message
     * @param array<string> $messageNames All message names in the proto file for type checking
     * @return string The generated fromBytes method code
     */
    public static function generateFromBytesMethod(array $message, array $messageNames): string
    {
        $code = "    /**\n";
        $code .= "     * Deserializes a {$message['name']} message from binary protobuf format\n";
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
        $code .= "        while (\$i < \$l) {\n";

        // Inline tag reading (hot path - happens for every field)
        $tagReadCode = self::inlineReadVarint('wire');
        $code .= self::indent($tagReadCode, 12) . "\n";

        $code .= "            \$fieldNum = (\$wire >> 3) & 0xFFFFFFFF;\n";
        $code .= "            \$wireType = \$wire & 0x7;\n";
        $code .= "\n";
        $code .= "            switch (\$fieldNum) {\n";

        foreach ($message['fields'] as $field) {
            $fieldNum = $field['number'];
            $fieldName = $field['name'];
            $fieldType = $field['type'];
            $fieldLabel = $field['label'];
            $isMessageType = in_array($fieldType, $messageNames);

            $code .= "                case {$fieldNum}:\n";

            // Handle map fields specially
            if ($fieldType === 'map') {
                $code .= self::generateMapFieldCode($field);
            }
            // Handle repeated fields
            else if ($fieldLabel === 'repeated') {
                $code .= self::generateRepeatedFieldCode($field, $isMessageType);
            }
            // Handle regular fields
            else {
                $code .= self::generateRegularFieldCode($field, $isMessageType);
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
     *
     * @param array{name: string, type: string, label: string, number: string} $field
     * @param bool $isMessageType Whether this field is a message type
     * @return string The generated field deserialization code
     */
    public static function generateRegularFieldCode(array $field, bool $isMessageType = false): string
    {
        $fieldName = $field['name'];
        $fieldType = $field['type'];

        // Message types always use wire type 2 (length-delimited)
        $expectedWireType = $isMessageType ? 2 : self::protoTypeToWireType($fieldType);

        $code = "                    if (\$wireType !== {$expectedWireType}) throw new Exception('Invalid wire type for {$fieldName}');\n";

        if ($isMessageType) {
            // For message types, inline the length reading then call fromBytes
            $lenReadCode = self::inlineReadVarint('_len');
            $code .= self::indent($lenReadCode, 20) . "\n";
            $code .= "                    \$_postIndex = \$i + \$_len;\n";
            $code .= "                    if (\$_postIndex < 0 || \$_postIndex > \$l) throw new Exception('Invalid length');\n";
            $code .= "                    \$d->{$fieldName} = {$fieldType}::fromBytes(substr(\$bytes, \$i, \$_len));\n";
            $code .= "                    \$i = \$_postIndex;\n";
        } else if ($fieldType === 'uint64') {
            // Special handling for uint64 which uses BcMath\Number
            $inlineCode = self::getInlineReadCode($fieldType, '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$fieldName} = \$d->{$fieldName}->add(\$_value);\n";
        } else if ($fieldType === 'bool') {
            // Bool needs special handling (convert varint to boolean)
            $inlineCode = self::getInlineReadCode('int32', '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$fieldName} = \$_value === 1;\n";
        } else {
            // All other types: inline the read code directly
            $inlineCode = self::getInlineReadCode($fieldType, '_value');
            $code .= self::indent($inlineCode, 20) . "\n";
            $code .= "                    \$d->{$fieldName} = \$_value;\n";
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
     *
     * @param array{name: string, type: string, label: string, number: string} $field
     * @param bool $isMessageType Whether this field is a message type
     * @return string The generated repeated field deserialization code
     */
    public static function generateRepeatedFieldCode(array $field, bool $isMessageType = false): string
    {
        $fieldName = $field['name'];
        $fieldType = $field['type'];

        $code = '';

        // Message types are never packed and always use wire type 2
        if ($isMessageType) {
            $code .= "                    if (\$wireType !== 2) throw new Exception('Invalid wire type for {$fieldName}');\n";

            // Inline length reading
            $lenReadCode = self::inlineReadVarint('_len');
            $code .= self::indent($lenReadCode, 20) . "\n";

            $code .= "                    \$_postIndex = \$i + \$_len;\n";
            $code .= "                    if (\$_postIndex < 0 || \$_postIndex > \$l) throw new Exception('Invalid length');\n";
            $code .= "                    \$d->{$fieldName}[] = {$fieldType}::fromBytes(substr(\$bytes, \$i, \$_len));\n";
            $code .= "                    \$i = \$_postIndex;\n";
            return $code;
        }

        $expectedWireType = self::protoTypeToWireType($fieldType);

        // Numeric types can be packed (wire type 2) or unpacked (original wire type)
        $isPackable = self::isPackableType($fieldType);

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
            if ($fieldType === 'uint64') {
                // uint64 needs special handling with BcMath\Number
                $inlineCode = self::getInlineReadCode($fieldType, '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$fieldName}[] = new Number((string) \$_value);\n";
            } else if ($fieldType === 'bool') {
                // Bool needs conversion from varint to boolean
                $inlineCode = self::getInlineReadCode('int32', '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$fieldName}[] = \$_value === 1;\n";
            } else {
                // All other packable types
                $inlineCode = self::getInlineReadCode($fieldType, '_value');
                $code .= self::indent($inlineCode, 28) . "\n";
                $code .= "                            \$d->{$fieldName}[] = \$_value;\n";
            }

            $code .= "                        }\n";
            $code .= "\n";
            $code .= "                        if (\$i !== \$_end) throw new Exception('Packed {$fieldType} field over/under-read');\n";
            $code .= "                    } else if (\$wireType === {$expectedWireType}) {\n";
            $code .= "                        // Unpacked encoding: individual elements\n";

            // Inline the unpacked element reading
            if ($fieldType === 'uint64') {
                $inlineCode = self::getInlineReadCode($fieldType, '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$fieldName}[] = new Number((string) \$_value);\n";
            } else if ($fieldType === 'bool') {
                $inlineCode = self::getInlineReadCode('int32', '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$fieldName}[] = \$_value === 1;\n";
            } else {
                $inlineCode = self::getInlineReadCode($fieldType, '_value');
                $code .= self::indent($inlineCode, 24) . "\n";
                $code .= "                        \$d->{$fieldName}[] = \$_value;\n";
            }

            $code .= "                    } else throw new Exception('Invalid wire type for {$fieldName}');\n";
        } else {
            // Non-packable types (string, bytes, messages)
            $code .= "                    if (\$wireType !== {$expectedWireType}) throw new Exception('Invalid wire type for {$fieldName}');\n";

            // Inline the element reading
            if ($fieldType === 'string' || $fieldType === 'bytes') {
                $inlineCode = self::getInlineReadCode($fieldType, '_value');
                $code .= self::indent($inlineCode, 20) . "\n";
                $code .= "                    \$d->{$fieldName}[] = \$_value;\n";
            }
        }

        return $code;
    }

    /**
     * Generates code for deserializing a map field
     *
     * Map fields in protobuf are encoded as repeated entries, where each entry
     * is a message with two fields: key (field 1) and value (field 2).
     *
     * @param array{name: string, type: string, label: string, number: string, meta: array<string, string>} $field
     * @return string The generated map field deserialization code
     */
    public static function generateMapFieldCode(array $field): string
    {
        $fieldName = $field['name'];
        $keyType = $field['meta']['key_type'];
        $valueType = $field['meta']['value_type'];

        $code = "                    if (\$wireType !== 2) throw new Exception('Invalid wire type for {$fieldName}');\n";
        $code .= "\n";
        $code .= "                    // Map entry: read the length-delimited entry message\n";

        // Inline the entry length reading
        $entryLenCode = self::inlineReadVarint('_entryLen');
        $code .= self::indent($entryLenCode, 20) . "\n";

        $code .= "                    \$_limit = \$i + \$_entryLen;\n";
        $code .= "\n";

        // Initialize key and value with defaults
        $keyDefault = self::getDefaultValueForType($keyType);
        $valueDefault = self::getDefaultValueForType($valueType);

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

        $keyWireType = self::protoTypeToWireType($keyType);
        $code .= "                                if (\$_wt !== {$keyWireType}) throw new Exception('Invalid wire type for {$fieldName} key');\n";

        // Inline key reading
        if ($keyType === 'bool') {
            $keyReadCode = self::getInlineReadCode('int32', '_keyValue');
            $code .= self::indent($keyReadCode, 32) . "\n";
            $code .= "                                \$_key = \$_keyValue === 1;\n";
        } else {
            $keyReadCode = self::getInlineReadCode($keyType, '_key');
            $code .= self::indent($keyReadCode, 32) . "\n";
        }

        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            case 2: // value\n";

        $valueWireType = self::protoTypeToWireType($valueType);
        $code .= "                                if (\$_wt !== {$valueWireType}) throw new Exception('Invalid wire type for {$fieldName} value');\n";

        // Inline value reading
        if ($valueType === 'uint64') {
            $valueReadCode = self::getInlineReadCode($valueType, '_valTemp');
            $code .= self::indent($valueReadCode, 32) . "\n";
            $code .= "                                \$_val = new Number((string) \$_valTemp);\n";
        } else if ($valueType === 'bool') {
            $valueReadCode = self::getInlineReadCode('int32', '_valTemp');
            $code .= self::indent($valueReadCode, 32) . "\n";
            $code .= "                                \$_val = \$_valTemp === 1;\n";
        } else {
            $valueReadCode = self::getInlineReadCode($valueType, '_val');
            $code .= self::indent($valueReadCode, 32) . "\n";
        }

        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            default:\n";
        $code .= "                                skipField(\$i, \$l, \$bytes, \$_wt);\n";
        $code .= "                        }\n";
        $code .= "                    }\n";
        $code .= "\n";
        $code .= "                    \$d->{$fieldName}[\$_key] = \$_val;\n";

        return $code;
    }

    /**
     * Returns a PHP literal default value for a protobuf type
     *
     * Used for initializing map entry keys and values.
     *
     * @param string $type The protobuf type
     * @return string PHP code representing the default value
     */
    public static function getDefaultValueForType(string $type): string
    {
        return match ($type) {
            'int32', 'sint32', 'sfixed32', 'int64', 'sint64', 'sfixed64', 'uint32', 'fixed32' => '0',
            'uint64', 'fixed64' => 'new Number(\'0\')',
            'float', 'double' => '0.0',
            'bool' => 'false',
            'string', 'bytes' => '\'\'',
            default => throw new \Exception("Unknown default value for type: {$type}"),
        };
    }

    public static function generate(string $protoPath, string $outputPath): void
    {
        $input = InputStream::fromPath($protoPath);
        $lexer = new Protobuf3Lexer($input);
        $tokens = new CommonTokenStream($lexer);
        $parser = new Protobuf3Parser($tokens);

        $parser->addErrorListener(new DiagnosticErrorListener());
        $parser->setBuildParseTree(true);

        $tree = $parser->proto();

        $visitor = new class extends Protobuf3BaseVisitor {
            public null|string $phpNamespace = null;

            /**
             * @var array{name: string, fields: array{name: string, type: string, label: string, number: string, meta: array<string, string>}[]}[]
             */
            public array $messages = [];

            /**
             * @var array{name: string, fields: array{name: string, type: string, label: string, number: string, meta: array<string, string>}[]}|null
             */
            private null|array $currentMessage = null;

            public function visitOptionStatement(OptionStatementContext $context)
            {
                if ($context->optionName()->getText() === 'php_namespace') {
                    $this->phpNamespace = str_replace('\\\\', '\\', trim($context->constant()->getText(), '"\''));
                }
            }

            public function visitMapField($context)
            {
                $this->currentMessage['fields'][] = [
                    'name' => $context->mapName()->getText(),
                    'type' => 'map',
                    'label' => null,
                    'number' => $context->fieldNumber()->getText(),
                    'meta' => [
                        'key_type' => $context->keyType()->getText(),
                        'value_type' => $context->type_()->getText(),
                    ],
                ];
            }

            public function visitField($context)
            {
                $this->currentMessage['fields'][] = [
                    'name' => $context->fieldName()->getText(),
                    'type' => $context->type_()->getText(),
                    'label' => $context->fieldLabel()?->getText(),
                    'number' => $context->fieldNumber()->getText(),
                ];
            }

            public function visitMessageDef($context)
            {
                $this->currentMessage = [
                    'name' => $context->messageName()->getText(),
                    'fields' => [],
                ];

                parent::visitChildren($context);

                $this->messages[] = $this->currentMessage;

                unset($this->currentMessage);
            }
        };

        $visitor->visit($tree);

        if (!$visitor->phpNamespace) {
            throw new \Exception('php_namespace option is required');
        }

        // Collect all message names for type checking
        $messageNames = array_map(fn($msg) => $msg['name'], $visitor->messages);

        $codegen = "<?php\n";
        $codegen .= "\n";
        $codegen .= "declare(strict_types=1);\n";
        $codegen .= "\n";
        $codegen .= "namespace {$visitor->phpNamespace};\n";
        $codegen .= "\n";
        $codegen .= "use Exception;\n";
        $codegen .= "use BcMath\\Number;\n";
        $codegen .= "use const Proteus\\DEFAULT_UINT64;\n";
        $codegen .= "use function Proteus\\skipField;\n";
        $codegen .= "use function Proteus\\isBigEndian;\n";
        $codegen .= "\n";

        foreach ($visitor->messages as $message) {
            $className = self::protoNameToPhpName($message['name']);
            $codegen .= "class {$className}\n";
            $codegen .= "{\n";

            // Generate properties
            foreach ($message['fields'] as $idx => $field) {
                $isMessageType = in_array($field['type'], $messageNames);
                $phpType = self::protoToPhpType($field['type'], $isMessageType);

                // Special handling for map fields
                if ($field['type'] === 'map') {
                    $keyType = $field['meta']['key_type'];
                    $valueType = $field['meta']['value_type'];

                    // Maps are encoded as repeated entries (wire type 2)
                    $annotation = "protobuf:\"bytes,{$field['number']},rep,name={$field['name']}\"";
                    $annotation .= " protobuf_key:\"{$keyType},1,opt,name=key\"";
                    $annotation .= " protobuf_val:\"{$valueType},2,opt,name=value\"";
                    $codegen .= "    /** {$annotation} */\n";
                } else {
                    // Regular fields
                    $annotation = "protobuf:\"{$field['type']},{$field['number']}";

                    if ($field['label'] === 'repeated') {
                        $annotation .= ",rep";
                        // In proto3, repeated numeric fields are packed by default
                        if (self::isPackableType($field['type'])) {
                            $annotation .= ",packed";
                        }
                    } else if ($field['label'] === 'optional') {
                        $annotation .= ",opt";
                    }

                    $annotation .= ",name={$field['name']}\"";
                    $codegen .= "    /** {$annotation} */\n";
                }

                if ($field['label'] === 'repeated') {
                    $codegen .= "    /** @var {$phpType}[] */\n";
                    $codegen .= "    public array \${$field['name']} = [];\n";
                } else if ($field['label'] === 'optional' || $isMessageType) {
                    // Message types are always nullable in proto3
                    $codegen .= "    public {$phpType}|null \${$field['name']} = null;\n";
                } else {
                    if ($field['type'] === 'map') {
                        $codegen .= "    /** @var array<{$field['meta']['key_type']}, {$field['meta']['value_type']}> */\n";
                    }

                    $defaultValue = self::defaultPhpTypeValue($phpType);
                    $codegen .= "    public {$phpType} \${$field['name']} = {$defaultValue};\n";
                }

                if ($idx !== (count($message['fields']) - 1)) {
                    $codegen .= "\n";
                }
            }

            // Generate fromBytes method for all messages
            $codegen .= "\n";
            $codegen .= self::generateFromBytesMethod($message, $messageNames);
            $codegen .= "}\n\n";
        }

        file_put_contents($outputPath, $codegen);

        echo "Generated code written to {$outputPath}\n";
    }
}
