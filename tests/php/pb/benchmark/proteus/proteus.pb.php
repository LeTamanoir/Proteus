<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/benchmark/proteus.proto
 */

declare(strict_types=1);

namespace Tests\PB\benchmark\proteus;

if (PHP_INT_SIZE !== 8) {
    trigger_error('This message is only supported on 64-bit systems', E_USER_WARNING);
}

if (!extension_loaded('gmp')) {
    trigger_error('The gmp extension must be loaded in order to decode this message', E_USER_WARNING);
}

class Address
{
    public string $street = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public string $country = '';

    /**
     * Decodes a Address message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field street', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0) throw new \Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $_value = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                    $i = $_postIndex;
                    $d->street = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field city', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0) throw new \Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $_value = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                    $i = $_postIndex;
                    $d->city = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field state', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0) throw new \Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $_value = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                    $i = $_postIndex;
                    $d->state = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field zip_code', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0) throw new \Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $_value = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                    $i = $_postIndex;
                    $d->zip_code = $_value;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field country', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0) throw new \Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                    $_value = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                    $i = $_postIndex;
                    $d->country = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

class Bench
{
    /** @var array<string, Address> */
    public array $map_addresses = [];

    /** @var Address[] */
    public array $repeated_addresses = [];

    /**
     * Decodes a Bench message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_tag = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_tag |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses key', $_wireType));
                                $_byteLen = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_byteLen |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                if ($_byteLen < 0) throw new \Exception('Invalid length');
                                $_postIndex = $i + $_byteLen;
                                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                                $_key = pack('C*', ...array_slice($bytes, $i, $_byteLen));
                                $i = $_postIndex;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field map_addresses value', $_wireType));
                                $_len = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_len |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_msgLen = $i + $_len;
                                if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                                $_val = Address::decode(array_slice($bytes, $i, $_len));
                                $i = $_msgLen;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->map_addresses[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field repeated_addresses', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $d->repeated_addresses[] = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_msgLen;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

