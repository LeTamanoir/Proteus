<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\PB;

class Address implements \Proteus\Msg
{
    public string $street = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public string $country = '';

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return decodeAddress($bytes, 0, strlen($bytes));
    }
}

class Timestamp implements \Proteus\Msg
{
    public int $seconds = 0;

    public int $nanos = 0;

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return decodeTimestamp($bytes, 0, strlen($bytes));
    }
}

class Money implements \Proteus\Msg
{
    public string $currency_code = '';

    public int $units = 0;

    public int $nanos = 0;

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return decodeMoney($bytes, 0, strlen($bytes));
    }
}

class Coordinates implements \Proteus\Msg
{
    public float $latitude = 0.0;

    public float $longitude = 0.0;

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function decode(string $bytes): self
    {
        return decodeCoordinates($bytes, 0, strlen($bytes));
    }
}


/**
 * @throws \Exception if the data is malformed or contains invalid wire types
 */
function decodeAddress(string $bytes, int $i, int $l): Address
{
    $d = new Address();
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
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field street', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->street = $_value;
                break;
            case 2:
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field city', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->city = $_value;
                break;
            case 3:
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field state', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->state = $_value;
                break;
            case 4:
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field zip_code', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->zip_code = $_value;
                break;
            case 5:
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field country', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->country = $_value;
                break;
            default:
                $i = \Proteus\skipField($i, $l, $bytes, $wireType);
        }
    }
    return $d;
}

/**
 * @throws \Exception if the data is malformed or contains invalid wire types
 */
function decodeTimestamp(string $bytes, int $i, int $l): Timestamp
{
    $d = new Timestamp();
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
                if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field seconds', $wireType));
                $_value = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
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
                    $_b = ord($bytes[$i++]);
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

/**
 * @throws \Exception if the data is malformed or contains invalid wire types
 */
function decodeMoney(string $bytes, int $i, int $l): Money
{
    $d = new Money();
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
                if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field currency_code', $wireType));
                $_byteLen = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
                    $_byteLen |= ($_b & 0x7F) << $_shift;
                    if ($_b < 0x80) break;
                }
                if ($_byteLen < 0) throw new \Exception('Invalid length');
                $_postIndex = $i + $_byteLen;
                if ($_postIndex < 0 || $_postIndex > $l) throw new \Exception('Invalid length');
                $_value = substr($bytes, $i, $_byteLen);
                $i = $_postIndex;
                $d->currency_code = $_value;
                break;
            case 2:
                if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field units', $wireType));
                $_value = 0;
                for ($_shift = 0;; $_shift += 7) {
                    if ($_shift >= 64) throw new \Exception('Int overflow');
                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                    $_b = ord($bytes[$i++]);
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
                    $_b = ord($bytes[$i++]);
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

/**
 * @throws \Exception if the data is malformed or contains invalid wire types
 */
function decodeCoordinates(string $bytes, int $i, int $l): Coordinates
{
    $d = new Coordinates();
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
                if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field latitude', $wireType));
                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                $_value = unpack('d', substr($bytes, $i, 8))[1];
                $i += 8;
                $d->latitude = $_value;
                break;
            case 2:
                if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field longitude', $wireType));
                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                $_value = unpack('d', substr($bytes, $i, 8))[1];
                $i += 8;
                $d->longitude = $_value;
                break;
            default:
                $i = \Proteus\skipField($i, $l, $bytes, $wireType);
        }
    }
    return $d;
}

