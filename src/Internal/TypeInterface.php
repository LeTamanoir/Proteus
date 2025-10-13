<?php

declare(strict_types=1);

namespace Proteus\Internal;

interface TypeInterface
{
    public function getPhpType(): string;
    public function getPhpDefaultValue(): string;
    public function getProtoType(): ProtoType;
}
