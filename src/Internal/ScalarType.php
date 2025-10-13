<?php

declare(strict_types=1);

namespace Proteus\Internal;

readonly class ScalarType implements TypeInterface
{
    public function __construct(
        public ProtoType $protoType,
    ) {}

    public function getProtoType(): ProtoType
    {
        return $this->protoType;
    }

    public function getPhpType(): string
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
                => 'int',
            ProtoType::Uint64, ProtoType::Fixed64 => 'string',
            ProtoType::Float, ProtoType::Double => 'float',
            ProtoType::Bool => 'bool',
            ProtoType::String, ProtoType::Bytes => 'string',
            default => throw new \Exception("Invalid scalar type: {$this->protoType->value}"),
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
            ProtoType::Uint64, ProtoType::Fixed64 => '\'0\'',
            ProtoType::Float, ProtoType::Double => '0.0',
            ProtoType::Bool => 'false',
            ProtoType::String, ProtoType::Bytes => '\'\'',
            default => throw new \Exception("Invalid scalar type: {$this->protoType->value}"),
        };
    }
}
