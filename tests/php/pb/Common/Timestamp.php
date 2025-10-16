<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Common;

class Timestamp implements \Proteus\Msg
{
    public int $seconds = 0;

    public int $nanos = 0;

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return self::__decode($bytes, 0, strlen($bytes));
    }

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function __decode(string $bytes, int $i, int $l): self
    {
        $d = new self();
        while ($i < $l) {
            $_b = ord($bytes[$i++]);
            $wire = $_b & 0x7F;
            if ($_b >= 0x80) {
                $_s = 0;
                while ($_b >= 0x80) $wire |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                if ($_s > 63) throw new \Exception('Int overflow');
            }
            if ($i > $l) throw new \Exception('Unexpected EOF');
            $fieldNum = $wire >> 3;
            $wireType = $wire & 0x7;
            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field seconds', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_value = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_value |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $d->seconds = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field nanos', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_u = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_u |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                    $d->nanos = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

