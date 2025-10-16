<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/benchmark/proteus.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\benchmark\proteus;

class Bench implements \Proteus\Msg
{
    /** @var array<string, \Tests\php\pb\benchmark\proteus\Address> */
    public array $map_addresses = [];

    /** @var \Tests\php\pb\benchmark\proteus\Address[] */
    public array $repeated_addresses = [];

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
            $_b = ord(@$bytes[$i++]);
            $wire = $_b & 0x7F;
            if ($_b >= 0x80) {
                $_s = 0;
                while ($_b >= 0x80) $wire |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                if ($_s > 63) throw new \Exception('Int overflow');
            }
            $fieldNum = $wire >> 3;
            $wireType = $wire & 0x7;
            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = \Tests\php\pb\benchmark\proteus\Address::__decode($bytes, $i, $i + $_len);
                                $i += $_len;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->map_addresses[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field repeated_addresses', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->repeated_addresses[] = \Tests\php\pb\benchmark\proteus\Address::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        if ($i !== $l) throw new \Exception('Unexpected EOF');
        return $d;
    }

}

