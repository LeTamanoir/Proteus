<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/nested.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Nested;

class Nested implements \Proteus\Msg
{
    public \Tests\php\pb\Nested\Nested\Data|null $data = null;

    /** @var array<string, \Tests\php\pb\Nested\Nested\Data> */
    public array $map_data = [];

    /** @var \Tests\php\pb\Nested\Nested\Data[] */
    public array $repeated_data = [];

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
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field data', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $_value = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->data = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_b = ord($bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        if ($i > $l) throw new \Exception('Unexpected EOF');
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data key', $_wireType));
                                $_b = ord($bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                if ($i > $l) throw new \Exception('Unexpected EOF');
                                if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data value', $_wireType));
                                $_b = ord($bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                if ($i > $l) throw new \Exception('Unexpected EOF');
                                $_msgLen = $i + $_len;
                                if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                                $_val = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $_msgLen);
                                $i = $_msgLen;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->map_data[$_key] = $_val;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field repeated_data', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_len < 0 || $i + $_len > $l) throw new \Exception('Invalid length');
                    $d->repeated_data[] = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

