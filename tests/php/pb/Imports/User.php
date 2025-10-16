<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/imports.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Imports;

class User implements \Proteus\Msg
{
    public \Tests\php\pb\Common\Address|null $address = null;

    public \Tests\php\pb\Common\Timestamp|null $created_at = null;

    public \Tests\php\pb\Common\Money|null $balance = null;

    public \Tests\php\pb\Common\Coordinates|null $coordinates = null;

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
            $wire = 0;
            for ($_shift = 0;; $_shift += 7) {
                if ($_shift >= 64) throw new \Exception('Int overflow');
                if ($i >= $l) throw new \Exception('Unexpected EOF');
                $_b = ord($bytes[$i++]);
                $wire |= ($_b & 0x7F) << $_shift;
                if ($_b < 0x80) break;
            }
            $fieldNum = $wire >> 3;
            $wireType = $wire & 0x7;
            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field address', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $_value = \Tests\php\pb\Common\Address::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->address = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field created_at', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $_value = \Tests\php\pb\Common\Timestamp::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->created_at = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field balance', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $_value = \Tests\php\pb\Common\Money::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->balance = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field coordinates', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $_value = \Tests\php\pb\Common\Coordinates::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->coordinates = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

