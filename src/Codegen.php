<?php

declare(strict_types=1);

namespace Proteus;

use Antlr\Antlr4\Runtime\CommonTokenStream;
use Antlr\Antlr4\Runtime\Error\Listeners\DiagnosticErrorListener;
use Antlr\Antlr4\Runtime\InputStream;
use Proteus\Antlr4\Context\FieldContext;
use Proteus\Antlr4\Context\MapFieldContext;
use Proteus\Antlr4\Context\MessageDefContext;
use Proteus\Antlr4\Protobuf3BaseVisitor;
use Proteus\Antlr4\Protobuf3Lexer;
use Proteus\Antlr4\Protobuf3Parser;

class Codegen
{
    public static function protoToPhpType(string $type): string
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
            'uint64', 'fixed64' => '\BcMath\Number',
            //
            'float', 'double' => 'float',
            //
            'bool' => 'bool',
            //
            'string', 'bytes' => 'string',
            //
            'map' => 'array',
            //
            default => throw new \Exception("Unknown type: {$type}"),
        };
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
            '\BcMath\Number' => 'DEFAULT_UINT64',
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
            // Varint types
            'int32', 'sint32', 'uint32' => 'readVarint($i, $l, $bytes)',
            'bool' => 'readVarint($i, $l, $bytes) === 1',
            // Large integers that need special handling
            'int64', 'sint64' => 'readVarint($i, $l, $bytes)', // TODO: May need signed conversion
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
     * Generates the helper functions needed for protobuf binary deserialization
     *
     * These functions handle:
     * - Varint decoding (variable-length integer encoding)
     * - Fixed-size integer decoding (32-bit and 64-bit)
     * - Floating point decoding (float and double)
     * - Length-delimited data decoding (strings and bytes)
     * - Unknown field skipping
     */
    public static function generateHelperFunctions(): string
    {
        return <<<'PHP'

        /**
         * Skips an unknown field in the protobuf binary data
         *
         * @param int $i Current position in the byte string (passed by reference, will be updated)
         * @param int $l Total length of the byte string
         * @param string $bytes The binary data
         * @param int $wireType The wire type of the field to skip (0, 1, 2, or 5)
         * @throws \Exception if wire type is unsupported or data is malformed
         */
        function skipField(int &$i, int $l, string $bytes, int $wireType): void
        {
            switch ($wireType) {
                case 0: // varint
                    readVarint($i, $l, $bytes);
                    return;

                case 1: // 64-bit
                    $i += 8;
                    return;

                case 2: // length-delimited
                    $len = readVarint($i, $l, $bytes);
                    $i += $len;
                    return;

                case 5: // 32-bit
                    $i += 4;
                    return;

                default:
                    throw new \Exception("Unsupported wire type: {$wireType}");
            }
        }

        /**
         * Reads a varint (variable-length integer) from the binary data
         *
         * Varints are used in protobuf to efficiently encode integers. Each byte uses
         * 7 bits for data and 1 bit (MSB) as a continuation flag.
         *
         * @param int $i Current position in the byte string (passed by reference, will be updated)
         * @param int $l Total length of the byte string
         * @param string $bytes The binary data
         * @return int The decoded integer value
         * @throws \Exception if varint is too large (>64 bits) or EOF is reached
         */
        function readVarint(int &$i, int $l, string $bytes): int
        {
            $wire = 0;

            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) {
                    throw new \Exception('Int overflow');
                }
                if ($i >= $l) {
                    throw new \Exception('Unexpected EOF');
                }

                $b = ord($bytes[$i]);
                ++$i;
                $wire |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }

            return $wire;
        }

        /**
         * Reads a 32-bit floating point number (little-endian)
         *
         * @param int $i Current position (passed by reference, will be updated)
         * @param int $l Total length
         * @param string $bytes The binary data
         * @return float The decoded float value
         * @throws \Exception if EOF is reached
         */
        function readFloat32(int &$i, int $l, string $bytes): float
        {
            $b = substr($bytes, $i, 4);
            $i += 4;
            if ($i > $l) {
                throw new \Exception('Unexpected EOF');
            }
            if (isBigEndian()) {
                $b = strrev($b);
            }
            return unpack('f', $b)[1];
        }

        /**
         * Reads a 32-bit fixed integer (little-endian unsigned)
         *
         * @param int $i Current position (passed by reference, will be updated)
         * @param int $l Total length
         * @param string $bytes The binary data
         * @return int The decoded integer value
         * @throws \Exception if EOF is reached
         */
        function readFixed32(int &$i, int $l, string $bytes): int
        {
            $b = substr($bytes, $i, 4);
            $i += 4;
            if ($i > $l) {
                throw new \Exception('Unexpected EOF');
            }
            return unpack('V', $b)[1];
        }

        /**
         * Reads a 64-bit fixed integer (little-endian unsigned)
         *
         * @param int $i Current position (passed by reference, will be updated)
         * @param int $l Total length
         * @param string $bytes The binary data
         * @return int The decoded integer value
         * @throws \Exception if EOF is reached
         */
        function readFixed64(int &$i, int $l, string $bytes): int
        {
            $b = substr($bytes, $i, 8);
            $i += 8;
            if ($i > $l) {
                throw new \Exception('Unexpected EOF');
            }
            return unpack('P', $b)[1];
        }

        /**
         * Reads a 64-bit floating point number (little-endian)
         *
         * @param int $i Current position (passed by reference, will be updated)
         * @param int $l Total length
         * @param string $bytes The binary data
         * @return float The decoded double value
         * @throws \Exception if EOF is reached
         */
        function readFloat64(int &$i, int $l, string $bytes): float
        {
            $b = substr($bytes, $i, 8);
            $i += 8;
            if ($i > $l) {
                throw new \Exception('Unexpected EOF');
            }
            if (isBigEndian()) {
                $b = strrev($b);
            }
            return unpack('d', $b)[1];
        }

        /**
         * Detects if the system uses big-endian byte order
         *
         * Result is cached to avoid repeated checks.
         *
         * @return bool True if system is big-endian, false if little-endian
         */
        function isBigEndian(): bool
        {
            static $endianness;

            if (null === $endianness) {
                [, $result] = unpack('L', pack('V', 1));
                $endianness = $result !== 1;
            }

            return $endianness;
        }

        /**
         * Reads a length-delimited byte sequence (string or bytes field)
         *
         * First reads a varint indicating the length, then extracts that many bytes.
         *
         * @param int $i Current position (passed by reference, will be updated)
         * @param int $l Total length
         * @param string $bytes The binary data
         * @return string The extracted byte sequence
         * @throws \Exception if length is invalid or EOF is reached
         */
        function readBytes(int &$i, int $l, string $bytes): string
        {
            $byteLen = readVarint($i, $l, $bytes);
            if ($byteLen < 0) {
                throw new \Exception('Invalid length');
            }
            $postIndex = $i + $byteLen;
            if ($postIndex < 0) {
                throw new \Exception('Invalid length');
            }
            if ($postIndex > $l) {
                throw new \Exception('Unexpected EOF');
            }
            $dest = substr($bytes, $i, $byteLen);
            $i = $postIndex;
            return $dest;
        }

        PHP;
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
     * @return string The generated fromBytes method code
     */
    public static function generateFromBytesMethod(array $message): string
    {
        $code = "    /**\n";
        $code .= "     * Deserializes a {$message['name']} message from binary protobuf format\n";
        $code .= "     *\n";
        $code .= "     * @param string \$bytes Binary protobuf data\n";
        $code .= "     * @return self The deserialized message instance\n";
        $code .= "     * @throws \\Exception if the data is malformed or contains invalid wire types\n";
        $code .= "     */\n";
        $code .= "    public static function fromBytes(string \$bytes): self\n";
        $code .= "    {\n";
        $code .= "        \$d = new self();\n";
        $code .= "\n";
        $code .= "        \$l = strlen(\$bytes);\n";
        $code .= "        \$i = 0;\n";
        $code .= "\n";
        $code .= "        while (\$i < \$l) {\n";
        $code .= "            \$wire = readVarint(\$i, \$l, \$bytes);\n";
        $code .= "            \$fieldNum = (\$wire >> 3) & 0xFFFFFFFF;\n";
        $code .= "            \$wireType = \$wire & 0x7;\n";
        $code .= "\n";
        $code .= "            switch (\$fieldNum) {\n";

        foreach ($message['fields'] as $field) {
            $fieldNum = $field['number'];
            $fieldName = $field['name'];
            $fieldType = $field['type'];
            $fieldLabel = $field['label'];

            $code .= "                case {$fieldNum}:\n";

            // Handle map fields specially
            if ($fieldType === 'map') {
                $code .= self::generateMapFieldCode($field);
            }
            // Handle repeated fields
            else if ($fieldLabel === 'repeated') {
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
     *
     * @param array{name: string, type: string, label: string, number: string} $field
     * @return string The generated field deserialization code
     */
    public static function generateRegularFieldCode(array $field): string
    {
        $fieldName = $field['name'];
        $fieldType = $field['type'];
        $expectedWireType = self::protoTypeToWireType($fieldType);

        $code = "                    if (\$wireType !== {$expectedWireType}) {\n";
        $code .= "                        throw new \\Exception('Invalid wire type for {$fieldName}');\n";
        $code .= "                    }\n";

        // Special handling for uint64 which uses BcMath\Number
        if ($fieldType === 'uint64') {
            $code .= "                    \$d->{$fieldName} = \$d->{$fieldName}->add(readVarint(\$i, \$l, \$bytes));\n";
        } else {
            $readFunc = self::getReadFunction($fieldType, $fieldName);
            $code .= "                    \$d->{$fieldName} = {$readFunc};\n";
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
     * @return string The generated repeated field deserialization code
     */
    public static function generateRepeatedFieldCode(array $field): string
    {
        $fieldName = $field['name'];
        $fieldType = $field['type'];
        $expectedWireType = self::protoTypeToWireType($fieldType);

        $code = '';

        // Numeric types can be packed (wire type 2) or unpacked (original wire type)
        $isPackable = in_array($fieldType, [
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

        if ($isPackable) {
            // Handle packed encoding (wire type 2)
            $code .= "                    if (\$wireType === 2) {\n";
            $code .= "                        // Packed encoding: length-delimited sequence\n";
            $code .= "                        \$len = readVarint(\$i, \$l, \$bytes);\n";
            $code .= "                        \$end = \$i + \$len;\n";
            $code .= "\n";
            $code .= "                        while (\$i < \$end) {\n";

            // For int32, need to handle sign extension
            if ($fieldType === 'int32' || $fieldType === 'sint32') {
                $code .= "                            \$u = readVarint(\$i, \$l, \$bytes);\n";
                $code .= "                            if (\$u > 0x7FFFFFFF) {\n";
                $code .= "                                \$u -= 0x100000000;\n";
                $code .= "                            }\n";
                $code .= "                            \$d->{$fieldName}[] = \$u;\n";
            } else if ($fieldType === 'uint64') {
                // uint64 needs special handling with BcMath\Number
                $code .= "                            \$d->{$fieldName}[] = new \\BcMath\\Number((string) readVarint(\$i, \$l, \$bytes));\n";
            } else {
                $readFunc = self::getReadFunction($fieldType, $fieldName, true);
                $code .= "                            \$d->{$fieldName}[] = {$readFunc};\n";
            }

            $code .= "                        }\n";
            $code .= "\n";
            $code .= "                        if (\$i !== \$end) {\n";
            $code .= "                            throw new \\Exception('Packed {$fieldType} field over/under-read');\n";
            $code .= "                        }\n";
            $code .= "                    } else if (\$wireType === {$expectedWireType}) {\n";
            $code .= "                        // Unpacked encoding: individual elements\n";

            if ($fieldType === 'uint64') {
                $code .= "                        \$d->{$fieldName}[] = new \\BcMath\\Number((string) readVarint(\$i, \$l, \$bytes));\n";
            } else {
                $readFunc = self::getReadFunction($fieldType, $fieldName);
                $code .= "                        \$d->{$fieldName}[] = {$readFunc};\n";
            }

            $code .= "                    } else {\n";
            $code .= "                        throw new \\Exception('Invalid wire type for {$fieldName}');\n";
            $code .= "                    }\n";
        } else {
            // Non-packable types (string, bytes, messages)
            $code .= "                    if (\$wireType !== {$expectedWireType}) {\n";
            $code .= "                        throw new \\Exception('Invalid wire type for {$fieldName}');\n";
            $code .= "                    }\n";
            $readFunc = self::getReadFunction($fieldType, $fieldName);
            $code .= "                    \$d->{$fieldName}[] = {$readFunc};\n";
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

        $code = "                    if (\$wireType !== 2) {\n";
        $code .= "                        throw new \\Exception('Invalid wire type for {$fieldName}');\n";
        $code .= "                    }\n";
        $code .= "\n";
        $code .= "                    // Map entry: read the length-delimited entry message\n";
        $code .= "                    \$entryLen = readVarint(\$i, \$l, \$bytes);\n";
        $code .= "                    \$limit = \$i + \$entryLen;\n";
        $code .= "\n";

        // Initialize key and value with defaults
        $keyDefault = self::getDefaultValueForType($keyType);
        $valueDefault = self::getDefaultValueForType($valueType);

        $code .= "                    \$key = {$keyDefault};\n";
        $code .= "                    \$val = {$valueDefault};\n";
        $code .= "\n";
        $code .= "                    while (\$i < \$limit) {\n";
        $code .= "                        \$tag = readVarint(\$i, \$l, \$bytes);\n";
        $code .= "                        \$fn = \$tag >> 3; // field number inside entry: 1=key, 2=value\n";
        $code .= "                        \$wt = \$tag & 0x7; // wire type\n";
        $code .= "\n";
        $code .= "                        switch (\$fn) {\n";
        $code .= "                            case 1: // key\n";

        $keyWireType = self::protoTypeToWireType($keyType);
        $code .= "                                if (\$wt !== {$keyWireType}) {\n";
        $code .= "                                    throw new \\Exception('Invalid wire type for {$fieldName} key');\n";
        $code .= "                                }\n";
        $keyReadFunc = self::getReadFunction($keyType, $fieldName . '_key');
        $code .= "                                \$key = {$keyReadFunc};\n";
        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            case 2: // value\n";

        $valueWireType = self::protoTypeToWireType($valueType);
        $code .= "                                if (\$wt !== {$valueWireType}) {\n";
        $code .= "                                    throw new \\Exception('Invalid wire type for {$fieldName} value');\n";
        $code .= "                                }\n";
        $valueReadFunc = self::getReadFunction($valueType, $fieldName . '_value');
        $code .= "                                \$val = {$valueReadFunc};\n";
        $code .= "                                break;\n";
        $code .= "\n";
        $code .= "                            default:\n";
        $code .= "                                skipField(\$i, \$l, \$bytes, \$wt);\n";
        $code .= "                        }\n";
        $code .= "                    }\n";
        $code .= "\n";
        $code .= "                    \$d->{$fieldName}[\$key] = \$val;\n";

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
            'uint64', 'fixed64' => 'new \\BcMath\\Number(\'0\')',
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
            /**
             * @var array{name: string, fields: array{name: string, type: string, label: string, number: string, meta: array<string, string>}[]}[]
             */
            public array $messages = [];

            /**
             * @var array{name: string, fields: array{name: string, type: string, label: string, number: string, meta: array<string, string>}[]}|null
             */
            private null|array $currentMessage = null;

            public function visitMapField(MapFieldContext $context)
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

            public function visitField(FieldContext $context)
            {
                $this->currentMessage['fields'][] = [
                    'name' => $context->fieldName()->getText(),
                    'type' => $context->type_()->getText(),
                    'label' => $context->fieldLabel()?->getText(),
                    'number' => $context->fieldNumber()->getText(),
                ];
            }

            public function visitMessageDef(MessageDefContext $context)
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

        $codegen = "<?php\n\n";
        $codegen .= "declare(strict_types=1);\n";
        $codegen .= "\n"; // TODO: namespace

        $codegen .= "const DEFAULT_UINT64 = new \BcMath\Number('0');\n";

        // Add helper functions for binary deserialization
        $codegen .= self::generateHelperFunctions();

        foreach ($visitor->messages as $message) {
            $codegen .= "\n";

            $className = self::protoNameToPhpName($message['name']);
            $codegen .= "class {$className} {\n";

            // Generate properties
            foreach ($message['fields'] as $idx => $field) {
                $phpType = self::protoToPhpType($field['type']);

                if ($field['label'] === 'repeated') {
                    $codegen .= "    /** @var {$phpType}[] */\n";
                    $codegen .= "    public array \${$field['name']} = [];\n";
                } else if ($field['label'] === 'optional') {
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
            $codegen .= self::generateFromBytesMethod($message);
            $codegen .= "}\n";
        }

        file_put_contents($outputPath, $codegen);

        echo "Generated code written to {$outputPath}\n";
    }
}
