<?php

declare(strict_types=1);

namespace Proteus\Internal;

class Message
{
    /**
     * @var Field[]
     */
    public private(set) array $fields = [];

    public string $name {
        get => Utils::protoNameToPhpName($this->name);
        set => $this->name = $value;
    }

    public function addField(Field $field): void
    {
        $this->fields[] = $field;
    }
}
