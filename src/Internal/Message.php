<?php

declare(strict_types=1);

namespace Proteus\Internal;

class Message
{
    /**
     * @var Field[]
     */
    public array $fields = [];

    public function __construct(
        public string $name,
    ) {}

    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }

    public function getPhpName(): string
    {
        return Utils::protoNameToPhpName($this->name);
    }
}
