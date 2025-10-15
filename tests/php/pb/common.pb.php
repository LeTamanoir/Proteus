<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: common.proto
 */

declare(strict_types=1);

namespace Tests\PB;

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

class Timestamp
{
    public int $seconds = 0;

    public int $nanos = 0;

    /**
     * Decodes a Timestamp message from binary protobuf format
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
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field seconds', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->seconds = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field nanos', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
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

class Money
{
    public string $currency_code = '';

    public int $units = 0;

    public int $nanos = 0;

    /**
     * Decodes a Money message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field currency_code', $wireType));
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
                    $d->currency_code = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field units', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->units = $_value;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field nanos', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
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

class Coordinates
{
    public float $latitude = 0.0;

    public float $longitude = 0.0;

    /**
     * Decodes a Coordinates message from binary protobuf format
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
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field latitude', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->latitude = $_value;
                    break;
                case 2:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field longitude', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->longitude = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

