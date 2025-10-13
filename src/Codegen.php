<?php

declare(strict_types=1);

namespace Proteus;

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\InputStream;
use Proteus\Antlr4\Protobuf3Lexer;
use Proteus\Antlr4\Protobuf3Parser;
use Proteus\Internal\CodeWriter;
use Proteus\Internal\Field;
use Proteus\Internal\FieldLabel;
use Proteus\Internal\MapType;
use Proteus\Internal\Message;
use Proteus\Internal\MessageType;
use Proteus\Internal\Protobuf3Visitor;
use Proteus\Internal\ProtoType;

class Codegen
{
    /**
     * Generates inline code for reading a varint with fast-path optimization
     */
    private static function inlineReadVarint(string $varName): string
    {
        return <<<PHP
        \${$varName} = 0;
        for (\$_shift = 0;; \$_shift += 7) {
            if (\$_shift >= 64) {
                throw new \Exception('Int overflow');
            }
            if (\$i >= \$l) {
                throw new \Exception('Unexpected EOF');
            }
            \$_b = \$bytes[\$i];
            ++\$i;
            \${$varName} |= (\$_b & 0x7F) << \$_shift;
            if (\$_b < 0x80) {
                break;
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
        if (\$i + 4 > \$l) {
            throw new \Exception('Unexpected EOF');
        }
        \${$varName} = unpack('V', array_slice(\$bytes, \$i, 4))[1];
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
        if (\$i + 8 > \$l) {
            throw new \Exception('Unexpected EOF');
        }
        \${$varName} = unpack('P', array_slice(\$bytes, \$i, 8))[1];
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
        if (\$i + 4 > \$l) {
            throw new \Exception('Unexpected EOF');
        }
        \$_b = array_slice(\$bytes, \$i, 4);
        \$i += 4;
        if (\\Proteus\\isBigEndian()) {
            \$_b = array_reverse(\$_b);
        }
        \${$varName} = unpack('f', pack('C*', ...\$_b))[1];
        PHP;
    }

    /**
     * Generates inline code for reading double (64-bit)
     */
    private static function inlineReadDouble(string $varName): string
    {
        return <<<PHP
        if (\$i + 8 > \$l) {
            throw new \Exception('Unexpected EOF');
        }
        \$_b = array_slice(\$bytes, \$i, 8);
        \$i += 8;
        if (\\Proteus\\isBigEndian()) {
            \$_b = array_reverse(\$_b);
        }
        \${$varName} = unpack('d', pack('C*', ...\$_b))[1];
        PHP;
    }

    /**
     * Generates inline code for reading length-delimited bytes
     */
    private static function inlineReadBytes(string $varName): string
    {
        $lenCode = self::inlineReadVarint('_byteLen');
        return <<<PHP
        {$lenCode}
        if (\$_byteLen < 0) {
            throw new \Exception('Invalid length');
        }
        \$_postIndex = \$i + \$_byteLen;
        if (\$_postIndex < 0 || \$_postIndex > \$l) {
            throw new \Exception('Invalid length');
        }
        \${$varName} = implode('', array_map('chr', array_slice(\$bytes, \$i, \$_byteLen)));
        PHP;
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
    public static function generateFromBytesMethod(CodeWriter $gen, Message $message): void
    {
        $gen->docblock(<<<COMMENT
        Deserializes a {$message->name} message from binary protobuf format
        @param  int[] \$bytes Binary protobuf data
        @return self  The deserialized message instance
        @throws Exception if the data is malformed or contains invalid wire types
        COMMENT);

        $gen->line("public static function fromBytes(array \$bytes): self");

        $gen->line('{');
        $gen->in();

        $gen->line("\$d = new self();");
        $gen->line("\$l = count(\$bytes);");

        $gen->line("\$i = 0;");

        $gen->line("while (\$i < \$l) {");
        $gen->in();

        $gen->lines(self::inlineReadVarint('wire'));

        $gen->line("\$fieldNum = \$wire >> 3;");
        $gen->line("\$wireType = \$wire & 0x7;");
        $gen->line("switch (\$fieldNum) {");
        $gen->in();

        foreach ($message->fields as $field) {
            $gen->line("case {$field->number}:");
            $gen->in();

            // Handle map fields specially
            if ($field->type instanceof MapType) {
                self::generateMapFieldCode($gen, $field);
            }
            // Handle repeated fields
            else if ($field->label === FieldLabel::Repeated) {
                self::generateRepeatedFieldCode($gen, $field);
            }
            // Handle regular fields
            else {
                self::generateRegularFieldCode($gen, $field);
            }

            $gen->line('break;');
            $gen->newline();
            $gen->out();

        }

        $gen->line('default:');
        $gen->in();
        $gen->line("\$i = \\Proteus\\skipField(\$i, \$l, \$bytes, \$wireType);");
        $gen->out();
        $gen->out();
        $gen->line('}');
        $gen->out();
        $gen->line('}');
        $gen->line("return \$d;");
        $gen->out();
        $gen->line('}');
    }

    /**
     * Generates code for deserializing a regular (non-repeated, non-map) field
     */
    public static function generateRegularFieldCode(CodeWriter $gen, Field $field): void
    {
        // Message types always use wire type 2 (length-delimited)
        $expectedWireType = $field->type->getProtoType()->toWireType();
        $gen->line("if (\$wireType !== {$expectedWireType}) {");
        $gen->in();
        $gen->line("throw new \Exception('Invalid wire type for {$field->name}');");
        $gen->out();
        $gen->line('}');

        if ($field->type instanceof MessageType) {
            $gen->lines(self::inlineReadVarint('_len'));
            $gen->line("\$_postIndex = \$i + \$_len;");
            $gen->line("if (\$_postIndex < 0 || \$_postIndex > \$l) {");
            $gen->in();
            $gen->line("throw new \Exception('Invalid length');");
            $gen->out();
            $gen->line('}');
            $gen->line(
                "\$d->{$field->name} = "
                . $field->type->getPhpType()
                . "::fromBytes(array_slice(\$bytes, \$i, \$_len));",
            );
            $gen->line("\$i = \$_postIndex;");
        } else if ($field->type->getProtoType() === ProtoType::Uint64) {
            $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
            $gen->line("\$d->{$field->name} = bcadd(\$d->{$field->name}, (string) \$_value);");
        } else if ($field->type->getProtoType() === ProtoType::Bool) {
            $gen->lines(self::getInlineReadCode(ProtoType::Int32, '_value'));
            $gen->line("\$d->{$field->name} = \$_value === 1;");
        } else {
            $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
            $gen->line("\$d->{$field->name} = \$_value;");
        }
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
    public static function generateRepeatedFieldCode(CodeWriter $gen, Field $field): void
    {
        // Message types are never packed and always use wire type 2
        if ($field->type instanceof MessageType) {
            $gen->line("if (\$wireType !== 2) {");
            $gen->in();
            $gen->line("throw new \Exception('Invalid wire type for {$field->name}');");
            $gen->out();
            $gen->line('}');

            // Inline length reading
            $gen->lines(self::inlineReadVarint('_len'));

            $gen->line("\$_postIndex = \$i + \$_len;");
            $gen->line("if (\$_postIndex < 0 || \$_postIndex > \$l) {");
            $gen->in();
            $gen->line("throw new \Exception('Invalid length');");
            $gen->out();
            $gen->line('}');
            $gen->line(
                "\$d->{$field->name}[] = "
                . $field->type->getPhpType()
                . "::fromBytes(array_slice(\$bytes, \$i, \$_len));",
            );
            $gen->line("\$i = \$_postIndex;");
            return;
        }

        $expectedWireType = $field->type->getProtoType()->toWireType();

        $isPackable = $field->type->getProtoType()->isPackable();

        if ($isPackable) {
            $gen->line("if (\$wireType === 2) {");
            $gen->in();

            $gen->lines(self::inlineReadVarint('_len'));

            $gen->line("\$_end = \$i + \$_len;");
            $gen->line("while (\$i < \$_end) {");
            $gen->in();

            // Inline the element reading based on type
            if ($field->type->getProtoType() === ProtoType::Uint64) {
                // uint64 needs special handling with BcMath\Number
                $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
                $gen->line("\$d->{$field->name}[] = new Number((string) \$_value);");
            } else if ($field->type->getProtoType() === ProtoType::Bool) {
                // Bool needs conversion from varint to boolean
                $gen->lines(self::getInlineReadCode(ProtoType::Int32, '_value'));
                $gen->line("\$d->{$field->name}[] = \$_value === 1;");
            } else {
                // All other packable types
                $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
                $gen->line("\$d->{$field->name}[] = \$_value;");
            }

            $gen->out();
            $gen->line('}');
            $gen->newline();
            $gen->line("if (\$i !== \$_end) {");
            $gen->in();
            $gen->line("throw new \Exception('Packed {$field->type->getProtoType()->value} field over/under-read');");
            $gen->out();
            $gen->line('}');
            $gen->newline();

            // Inline the unpacked element reading
            if ($field->type->getProtoType() === ProtoType::Uint64) {
                $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
                $gen->line("\$d->{$field->name}[] = new Number((string) \$_value);");
            } else if ($field->type->getProtoType() === ProtoType::Bool) {
                $gen->lines(self::getInlineReadCode(ProtoType::Int32, '_value'));
                $gen->line("\$d->{$field->name}[] = \$_value === 1;");
            } else {
                $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
                $gen->line("\$d->{$field->name}[] = \$_value;");
            }

            $gen->out();
            $gen->line('} else {');
            $gen->in();
            $gen->line("throw new \Exception('Invalid wire type for {$field->name}');");
            $gen->out();
            $gen->line('}');
        } else {
            // Non-packable types (string, bytes, messages)
            $gen->line("if (\$wireType !== {$expectedWireType}) {");
            $gen->in();
            $gen->line("throw new \Exception('Invalid wire type for {$field->name}');");
            $gen->out();
            $gen->line('}');

            // Inline the element reading
            if (
                $field->type->getProtoType() === ProtoType::String
                || $field->type->getProtoType() === ProtoType::Bytes
            ) {
                $gen->lines(self::getInlineReadCode($field->type->getProtoType(), '_value'));
                $gen->line("\$d->{$field->name}[] = \$_value;");
            }
        }
    }

    /**
     * Generates code for deserializing a map field
     *
     * Map fields in protobuf are encoded as repeated entries, where each entry
     * is a message with two fields: key (field 1) and value (field 2).
     */
    public static function generateMapFieldCode(CodeWriter $gen, Field $field): void
    {
        /** @var MapType $mapType */
        $mapType = $field->type;
        $keyType = $mapType->keyType;
        $valueType = $mapType->valueType;

        $gen->line("if (\$wireType !== 2) {");
        $gen->in();
        $gen->line("throw new \Exception('Invalid wire type for {$field->name}');");
        $gen->out();
        $gen->line('}');

        $gen->lines(self::inlineReadVarint('_entryLen'));

        $gen->line("\$_limit = \$i + \$_entryLen;");

        // Initialize key and value with defaults
        $keyDefault = $keyType->getPhpDefaultValue();
        $valueDefault = $valueType->getPhpDefaultValue();

        $gen->line("\$_key = {$keyDefault};");
        $gen->line("\$_val = {$valueDefault};");
        $gen->line("while (\$i < \$_limit) {");
        $gen->in();

        // Inline tag reading within the map entry
        $gen->lines(self::inlineReadVarint('_tag'));

        $gen->line("\$_fn = \$_tag >> 3;");
        $gen->line("\$_wt = \$_tag & 0x7;");
        $gen->line("switch (\$_fn) {");
        $gen->in();

        $gen->line('case 1:');
        $gen->in();

        $keyWireType = $keyType->getProtoType()->toWireType();
        $gen->line("if (\$_wt !== {$keyWireType}) {");
        $gen->in();
        $gen->line("throw new \Exception('Invalid wire type for {$field->name} key');");
        $gen->out();
        $gen->line('}');

        // Inline key reading
        if ($keyType->getProtoType() === ProtoType::Bool) {
            $gen->lines(self::getInlineReadCode(ProtoType::Int32, '_keyValue'));
            $gen->line("\$_key = \$_keyValue === 1;");
        } else {
            $gen->lines(self::getInlineReadCode($keyType->getProtoType(), '_key'));
        }

        $gen->line('break;');
        $gen->newline();
        $gen->out();
        $gen->line('case 2:');
        $gen->in();

        $valueWireType = $valueType->getProtoType()->toWireType();
        $gen->line("if (\$_wt !== {$valueWireType}) {");
        $gen->in();
        $gen->line("throw new \Exception('Invalid wire type for {$field->name} value');");
        $gen->out();
        $gen->line('}');

        // Inline value reading
        if ($valueType instanceof MessageType) {
            // For message types, read length and call fromBytes
            $gen->lines(self::inlineReadVarint('_msgLen'));
            $gen->line("\$_msgEnd = \$i + \$_msgLen;");
            $gen->line("if (\$_msgEnd < 0 || \$_msgEnd > \$l) {");
            $gen->in();
            $gen->line("throw new \Exception('Invalid length');");
            $gen->out();
            $gen->line('}');
            $gen->line("\$_val = " . $valueType->getPhpType() . "::fromBytes(array_slice(\$bytes, \$i, \$_msgLen));");
            $gen->line("\$i = \$_msgEnd;");
        } else if ($valueType->getProtoType() === ProtoType::Uint64) {
            $gen->lines(self::getInlineReadCode($valueType->getProtoType(), '_valTemp'));
            $gen->line("\$_val = new Number((string) \$_valTemp);");
        } else if ($valueType->getProtoType() === ProtoType::Bool) {
            $gen->lines(self::getInlineReadCode(ProtoType::Int32, '_valTemp'));
            $gen->line("\$_val = \$_valTemp === 1;");
        } else {
            $gen->lines(self::getInlineReadCode($valueType->getProtoType(), '_val'));
        }

        $gen->line('break;');
        $gen->newline();
        $gen->out();
        $gen->line('default:');
        $gen->in();
        $gen->line("\$i = \\Proteus\\skipField(\$i, \$l, \$bytes, \$_wt);");
        $gen->out();
        $gen->out();
        $gen->line('}');
        $gen->newline();
        $gen->line("\$d->{$field->name}[\$_key] = \$_val;");
        $gen->out();
        $gen->line('}');
    }

    /**
     * Generates the code for a protobuf message
     */
    public static function generateMessage(CodeWriter $gen, Message $message): void
    {
        $gen->line("class {$message->name}");
        $gen->line('{');

        $gen->in();
        foreach ($message->fields as $idx => $field) {
            $phpType = $field->type->getPhpType();

            if ($field->label === FieldLabel::Repeated) {
                $gen->comment("@var {$phpType}[]");
                $gen->line("public array \${$field->name} = [];");
            } else if (
                $field->label === FieldLabel::Optional
                // Message types are always nullable in proto3
                || $field->type instanceof MessageType
            ) {
                $gen->line("public {$phpType}|null \${$field->name} = null;");
            } else {
                if ($field->type instanceof MapType) {
                    $keyType = $field->type->keyType->getPhpType();
                    $valueType = $field->type->valueType->getPhpType();
                    $gen->comment("@var array<{$keyType}, {$valueType}>");
                }

                $defaultValue = $field->type->getPhpDefaultValue();
                $gen->line("public {$phpType} \${$field->name} = {$defaultValue};");
            }

            $gen->newline();
        }

        self::generateFromBytesMethod($gen, $message);
        $gen->out();

        $gen->line('}');
        $gen->newline();
    }

    /**
     * Parse a proto file and return its visitor (for import processing)
     */
    private static function parseProtoFile(string $protoPath): Protobuf3Visitor
    {
        $input = InputStream::fromPath($protoPath);
        $lexer = new Protobuf3Lexer($input);
        $tokens = new CommonTokenStream($lexer);
        $parser = new Protobuf3Parser($tokens);

        $visitor = new Protobuf3Visitor();
        $visitor->visit($parser->proto());

        return $visitor;
    }

    /**
     * Build a type registry mapping proto types to PHP fully qualified class names
     *
     * @param string $baseDir Base directory for resolving relative import paths
     * @param Protobuf3Visitor $mainVisitor The main file's visitor
     * @return array<string, string> Map of proto type name to PHP FQN
     */
    private static function buildTypeRegistry(string $baseDir, Protobuf3Visitor $mainVisitor): array
    {
        $registry = [];

        // Process imported files
        foreach ($mainVisitor->imports as $importPath) {
            $fullImportPath = $baseDir . '/' . $importPath;
            if (!file_exists($fullImportPath)) {
                // Try without base dir (absolute path)
                $fullImportPath = $importPath;
            }

            if (file_exists($fullImportPath)) {
                $importedVisitor = self::parseProtoFile($fullImportPath);

                if ($importedVisitor->phpNamespace) {
                    foreach ($importedVisitor->messages as $message) {
                        // Map proto package + message name to PHP FQN
                        $phpFqn = $importedVisitor->phpNamespace . '\\' . $message->name;
                        $registry[$message->name] = $phpFqn;
                    }
                }
            }
        }

        return $registry;
    }

    public static function generate(string $protoPath, string $outputPath): void
    {
        $visitor = self::parseProtoFile($protoPath);

        if (!$visitor->phpNamespace) {
            throw new \Exception('php_namespace option is required');
        }

        // Build type registry from imports
        $baseDir = dirname($protoPath);
        $typeRegistry = self::buildTypeRegistry($baseDir, $visitor);

        // Collect imported types that are actually used
        $usedImports = [];
        foreach ($visitor->messages as $message) {
            foreach ($message->fields as $field) {
                if ($field->type instanceof MessageType) {
                    $typeName = $field->type->message;
                    // Check if it's an imported type (contains package prefix)
                    if (str_contains($typeName, '.')) {
                        // Extract just the message name from the qualified name
                        $parts = explode('.', $typeName);
                        $messageName = array_pop($parts);
                        if (isset($typeRegistry[$messageName])) {
                            $usedImports[$typeRegistry[$messageName]] = true;
                        }
                    }
                }
            }
        }

        $gen = new CodeWriter();

        $gen->line('<?php');
        $gen->newline();
        $gen->docblock(<<<COMMENT
        Auto-generated file, DO NOT EDIT!
        Proto file: {$protoPath}
        COMMENT);
        $gen->newline();
        $gen->line('declare(strict_types=1);');
        $gen->newline();
        $gen->line("namespace {$visitor->phpNamespace};");
        $gen->newline();

        // Add use statements for imported types
        foreach (array_keys($usedImports) as $importedType) {
            $gen->line("use {$importedType};");
        }
        if (count(array_keys($usedImports)) > 0) {
            $gen->newline();
        }

        foreach ($visitor->messages as $message) {
            self::generateMessage($gen, $message);
        }

        file_put_contents($outputPath, $gen->getOutput());

        echo "Generated code written to {$outputPath}\n";
    }
}
