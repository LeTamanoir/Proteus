<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/nested.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Nested;

final class Nested extends \Proteus\Msg
{
    public \Tests\php\pb\Nested\Nested\Data|null $data = null;

    /** @var array<string, \Tests\php\pb\Nested\Nested\Data> */
    public array $map_data = [];

    /** @var \Tests\php\pb\Nested\Nested\Data[] */
    public array $repeated_data = [];

    /**
     * @internal
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
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field data', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->data = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data key', $_wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_data value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $i + $_len);
                                $i += $_len;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->map_data[$_key] = $_val;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field repeated_data', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->repeated_data[] = \Tests\php\pb\Nested\Nested\Data::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        if ($i !== $l) throw new \Exception('Unexpected EOF');
        return $d;
    }

    /**
     * @internal
     */
    public function __encode(): string
    {
        $buf = '';
        if ($this->data !== []) {
            $buf .= "\x12";
            $_msgBuf = $this->data->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        foreach ($this->map_data as $_key => $_val) {
            $buf .= "\x1a";
            $_entryBuf = '';
            $_entryBuf .= "\x0a";
            $_v = strlen($_key);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_key;
            $_entryBuf .= "\x12";
            $_msgBuf = $_val->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_msgBuf;
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->repeated_data as $_value) {
            $buf .= "\x22";
            $_msgBuf = $_value->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        return $buf;
    }
}

