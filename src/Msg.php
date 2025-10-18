<?php

declare(strict_types=1);

namespace Proteus;

abstract class Msg
{
    /**
     * Decode the wire-format message in $bytes.
     *
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return static::__decode($bytes, 0, strlen($bytes));
    }

    /**
     * Encode the message in wire-format.
     */
    public function encode(): string
    {
        return $this->__encode();
    }

    /** @internal */
    abstract public static function __decode(string $bytes, int $i, int $l): self;

    /** @internal */
    abstract public function __encode(): string;
}
