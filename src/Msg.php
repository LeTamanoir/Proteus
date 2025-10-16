<?php

declare(strict_types=1);

namespace Proteus;

interface Msg
{
    public static function decode(string $bytes): self;
}
