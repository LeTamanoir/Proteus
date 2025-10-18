<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/imports.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Imports;

final class User extends \Proteus\Msg
{
    public \Tests\php\pb\Common\Address|null $address = null;

    public \Tests\php\pb\Common\Timestamp|null $created_at = null;

    public \Tests\php\pb\Common\Money|null $balance = null;

    public \Tests\php\pb\Common\Coordinates|null $coordinates = null;

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
                case 1:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field address', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->address = \Tests\php\pb\Common\Address::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field created_at', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->created_at = \Tests\php\pb\Common\Timestamp::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field balance', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->balance = \Tests\php\pb\Common\Money::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field coordinates', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->coordinates = \Tests\php\pb\Common\Coordinates::__decode($bytes, $i, $i + $_len);
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
        if ($this->address !== []) {
            $buf .= "\x0a";
            $_msgBuf = $this->address->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        if ($this->created_at !== []) {
            $buf .= "\x12";
            $_msgBuf = $this->created_at->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        if ($this->balance !== []) {
            $buf .= "\x1a";
            $_msgBuf = $this->balance->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        if ($this->coordinates !== []) {
            $buf .= "\x22";
            $_msgBuf = $this->coordinates->__encode();
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

