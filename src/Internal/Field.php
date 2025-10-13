<?php

declare(strict_types=1);

namespace Proteus\Internal;

readonly class Field
{
    public function __construct(
        public string $name,
        public TypeInterface $type,
        public null|FieldLabel $label,
        public int $number,
    ) {}
}
