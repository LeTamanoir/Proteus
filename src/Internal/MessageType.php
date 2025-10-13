<?php

declare(strict_types=1);

namespace Proteus\Internal;

readonly class MessageType implements TypeInterface
{
    public function __construct(
        public string $message,
    ) {}

    public function getProtoType(): ProtoType
    {
        return ProtoType::Message;
    }

    public function getPhpType(): string
    {
        return Utils::protoNameToPhpName($this->message);
    }

    public function getPhpDefaultValue(): string
    {
        return 'new ' . Utils::protoNameToPhpName($this->message) . '()';
    }
}
