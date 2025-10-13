<?php

declare(strict_types=1);

namespace Proteus\Internal;

class Type
{
    public function __construct(
        public ProtoType $protoType,

        // For message fields
        public null|string $message = null,

        // For map fields
        public null|Type $keyType = null,
        public null|Type $valueType = null,
    ) {}

    public function getPhpType(): string
    {
        if ($this->protoType === ProtoType::Message) {
            return Utils::protoNameToPhpName($this->message);
        }

        return match ($this->protoType) {
            ProtoType::Int32,
            ProtoType::Sint32,
            ProtoType::Sfixed32,
            ProtoType::Int64,
            ProtoType::Sint64,
            ProtoType::Sfixed64,
            ProtoType::Uint32,
            ProtoType::Fixed32,
                => 'int',
            //
            ProtoType::Uint64, ProtoType::Fixed64 => 'string',
            //
            ProtoType::Float, ProtoType::Double => 'float',
            //
            ProtoType::Bool => 'bool',
            //
            ProtoType::String, ProtoType::Bytes => 'string',
            //
            ProtoType::Map => 'array',
        };
    }

    public function getPhpDefaultValue(): string
    {
        return match ($this->protoType) {
            ProtoType::Int32,
            ProtoType::Sint32,
            ProtoType::Sfixed32,
            ProtoType::Int64,
            ProtoType::Sint64,
            ProtoType::Sfixed64,
            ProtoType::Uint32,
            ProtoType::Fixed32,
                => '0',
            //
            ProtoType::Uint64, ProtoType::Fixed64 => '\'0\'',
            //
            ProtoType::Float, ProtoType::Double => '0.0',
            //
            ProtoType::Bool => 'false',
            //
            ProtoType::String, ProtoType::Bytes => '\'\'',
            //
            ProtoType::Map => '[]',
            //
            ProtoType::Message => 'new ' . Utils::protoNameToPhpName($this->message) . '()',
        };
    }
}
