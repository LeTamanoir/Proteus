<?php

declare(strict_types=1);

namespace Proteus\Internal;

readonly class MapType implements TypeInterface
{
    public function __construct(
        public TypeInterface $keyType,
        public TypeInterface $valueType,
    ) {}

    public function getProtoType(): ProtoType
    {
        return ProtoType::Map;
    }

    public function getPhpType(): string
    {
        return 'array';
    }

    public function getPhpDefaultValue(): string
    {
        return '[]';
    }
}
