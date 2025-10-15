<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: imports.proto
 */

declare(strict_types=1);

namespace Tests\PB;

use Tests\PB\Address;
use Tests\PB\Timestamp;
use Tests\PB\Money;
use Tests\PB\Coordinates;

class User
{
    public Address|null $address = null;

    public Timestamp|null $created_at = null;

    public Money|null $balance = null;

    public Coordinates|null $coordinates = null;

    /**
     * Decodes a User message from binary protobuf format
     * @param  int[] $bytes Binary protobuf data
     * @return self  The decoded message instance
     * @throws Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(array $bytes): self
    {
        $d = new self();
        $l = count($bytes);
        $i = 0;
        while ($i < $l) {
            $wire = 0;
            for ($_shift = 0;; $_shift += 7) {
                if ($_shift >= 64) throw new \Exception('Int overflow');
                if ($i >= $l) throw new \Exception('Unexpected EOF');
                $_b = $bytes[$i++];
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
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_postIndex = $i + $_len;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $d->address = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field created_at', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_postIndex = $i + $_len;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $d->created_at = Timestamp::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field balance', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_postIndex = $i + $_len;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $d->balance = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field coordinates', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_postIndex = $i + $_len;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $d->coordinates = Coordinates::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

