<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: comprehensive_test.proto
 */

declare(strict_types=1);

namespace Tests\PB;

use Tests\PB\Timestamp;
use Tests\PB\Coordinates;
use Tests\PB\Address;
use Tests\PB\Money;

/**
 * Message containing all scalar types
 */
class AllScalarTypes
{
    /**
     * Variable-length integer types
     */
    public int $int32_field = 0;

    public int $int64_field = 0;

    public int $uint32_field = 0;

    public string $uint64_field = '0';

    /**
     * Signed integers with ZigZag encoding
     */
    public int $sint32_field = 0;

    public int $sint64_field = 0;

    /**
     * Fixed-width integer types (more efficient for large values)
     */
    public int $fixed32_field = 0;

    public int $fixed64_field = 0;

    public int $sfixed32_field = 0;

    public int $sfixed64_field = 0;

    /**
     * Floating point types
     */
    public float $float_field = 0.0;

    public float $double_field = 0.0;

    /**
     * Boolean type
     */
    public bool $bool_field = false;

    /**
     * String and bytes
     */
    public string $string_field = '';

    public string $bytes_field = '';

    /**
     * Decodes a AllScalarTypes message from binary protobuf format
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
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_field', $wireType));
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
                    $d->int32_field = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_field', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->int64_field = $_value;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_field', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->uint32_field = $_value;
                    break;
                case 4:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_field', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->uint64_field = (string) $_value;
                    break;
                case 5:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_field', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                    $d->sint32_field = $_value;
                    break;
                case 6:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_field', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    $d->sint64_field = $_value;
                    break;
                case 7:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_field', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                    $i += 4;
                    $d->fixed32_field = $_value;
                    break;
                case 8:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_field', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                    $i += 8;
                    $d->fixed64_field = $_value;
                    break;
                case 9:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_field', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                    $i += 4;
                    $d->sfixed32_field = $_value;
                    break;
                case 10:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_field', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                    $i += 8;
                    $d->sfixed64_field = $_value;
                    break;
                case 11:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field float_field', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 4);
                    $i += 4;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('f', pack('C*', ...$_b))[1];
                    $d->float_field = $_value;
                    break;
                case 12:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field double_field', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->double_field = $_value;
                    break;
                case 13:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field bool_field', $wireType));
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
                    $d->bool_field = $_value === 1;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_field', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->string_field = $_value;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bytes_field', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->bytes_field = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message with repeated fields of various types
 */
class AllRepeatedTypes
{
    /**
     * Repeated integers (packed encoding)
     */
    /** @var int[] */
    public array $int32_list = [];

    /** @var int[] */
    public array $int64_list = [];

    /** @var int[] */
    public array $uint32_list = [];

    /** @var string[] */
    public array $uint64_list = [];

    /** @var int[] */
    public array $sint32_list = [];

    /** @var int[] */
    public array $sint64_list = [];

    /** @var int[] */
    public array $fixed32_list = [];

    /** @var int[] */
    public array $fixed64_list = [];

    /** @var int[] */
    public array $sfixed32_list = [];

    /** @var int[] */
    public array $sfixed64_list = [];

    /**
     * Repeated floating point (packed encoding)
     */
    /** @var float[] */
    public array $float_list = [];

    /** @var float[] */
    public array $double_list = [];

    /**
     * Repeated boolean (packed encoding)
     */
    /** @var bool[] */
    public array $bool_list = [];

    /**
     * Repeated string and bytes (NOT packed - length-delimited)
     */
    /** @var string[] */
    public array $string_list = [];

    /** @var string[] */
    public array $bytes_list = [];

    /**
     * Repeated message type (NOT packed)
     */
    /** @var Address[] */
    public array $address_list = [];

    /**
     * Decodes a AllRepeatedTypes message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
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
                        $d->int32_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_INT32 field over/under-read');
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
                    $d->int32_list[] = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_value = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_value |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $d->int64_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_INT64 field over/under-read');
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->int64_list[] = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint32_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_value = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_value |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $d->uint32_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_UINT32 field over/under-read');
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->uint32_list[] = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint64_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_value = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_value |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $d->uint64_list[] = (string) $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_UINT64 field over/under-read');
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->uint64_list[] = (string) $_value;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint32_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_u = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_u |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $_value = ($_u >> 1) ^ -($_u & 1);
                        if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                        $d->sint32_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_SINT32 field over/under-read');
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                    $d->sint32_list[] = $_value;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint64_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_u = 0;
                        for ($_shift = 0;; $_shift += 7) {
                            if ($_shift >= 64) throw new \Exception('Int overflow');
                            if ($i >= $l) throw new \Exception('Unexpected EOF');
                            $_b = $bytes[$i++];
                            $_u |= ($_b & 0x7F) << $_shift;
                            if ($_b < 0x80) break;
                        }
                        $_value = ($_u >> 1) ^ -($_u & 1);
                        $d->sint64_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_SINT64 field over/under-read');
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    $d->sint64_list[] = $_value;
                    break;
                case 7:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                        $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                        $i += 4;
                        $d->fixed32_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_FIXED32 field over/under-read');
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                    $i += 4;
                    $d->fixed32_list[] = $_value;
                    break;
                case 8:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                        $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                        $i += 8;
                        $d->fixed64_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_FIXED64 field over/under-read');
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                    $i += 8;
                    $d->fixed64_list[] = $_value;
                    break;
                case 9:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                        $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                        $i += 4;
                        $d->sfixed32_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_SFIXED32 field over/under-read');
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                    $i += 4;
                    $d->sfixed32_list[] = $_value;
                    break;
                case 10:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                        $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                        $i += 8;
                        $d->sfixed64_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_SFIXED64 field over/under-read');
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                    $i += 8;
                    $d->sfixed64_list[] = $_value;
                    break;
                case 11:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field float_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                        $_b = array_slice($bytes, $i, 4);
                        $i += 4;
                        if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                        $_value = unpack('f', pack('C*', ...$_b))[1];
                        $d->float_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_FLOAT field over/under-read');
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 4);
                    $i += 4;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('f', pack('C*', ...$_b))[1];
                    $d->float_list[] = $_value;
                    break;
                case 12:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field double_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                        $_b = array_slice($bytes, $i, 8);
                        $i += 8;
                        if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                        $_value = unpack('d', pack('C*', ...$_b))[1];
                        $d->double_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_DOUBLE field over/under-read');
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->double_list[] = $_value;
                    break;
                case 13:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bool_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
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
                        $d->bool_list[] = $_value === 1;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_BOOL field over/under-read');
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
                    $d->bool_list[] = $_value === 1;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_list', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->string_list[] = $_value;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bytes_list', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->bytes_list[] = $_value;
                    break;
                case 16:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field address_list', $wireType));
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
                    $d->address_list[] = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing int32 keys with different value types
 */
class MapInt32Keys
{
    /** @var array<int, string> */
    public array $int32_to_string = [];

    /** @var array<int, int> */
    public array $int32_to_int32 = [];

    /** @var array<int, Money> */
    public array $int32_to_message = [];

    /**
     * Decodes a MapInt32Keys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = '';
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_string key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = $_u;
                                if ($_key > 0x7FFFFFFF) $_key -= 0x100000000;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int32_to_string[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_int32', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_int32 key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = $_u;
                                if ($_key > 0x7FFFFFFF) $_key -= 0x100000000;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_int32 value', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_u;
                                if ($_val > 0x7FFFFFFF) $_val -= 0x100000000;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int32_to_int32[$_key] = $_val;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_message', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_message key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = $_u;
                                if ($_key > 0x7FFFFFFF) $_key -= 0x100000000;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_to_message value', $_wireType));
                                $_msgLen = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_msgLen |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_msgEnd = $i + $_msgLen;
                                if ($_msgEnd < 0 || $_msgEnd > $l) throw new \Exception('Invalid length');
                                $_val = Money::decode(array_slice($bytes, $i, $_msgLen));
                                $i = $_msgEnd;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int32_to_message[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing int64 keys
 */
class MapInt64Keys
{
    /** @var array<int, string> */
    public array $int64_to_string = [];

    /** @var array<int, float> */
    public array $int64_to_double = [];

    /**
     * Decodes a MapInt64Keys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = '';
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_string key', $_wireType));
                                $_key = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_key |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int64_to_string[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_double', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0.0;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_double key', $_wireType));
                                $_key = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_key |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                break;
                            case 2:
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field int64_to_double value', $_wireType));
                                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                                $_b = array_slice($bytes, $i, 8);
                                $i += 8;
                                if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                                $_val = unpack('d', pack('C*', ...$_b))[1];
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int64_to_double[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing uint32/uint64 keys
 */
class MapUintKeys
{
    /** @var array<int, string> */
    public array $uint32_to_string = [];

    /** @var array<string, string> */
    public array $uint64_to_bytes = [];

    /**
     * Decodes a MapUintKeys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint32_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = '';
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_to_string key', $_wireType));
                                $_key = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_key |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint32_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint32_to_string[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint64_to_bytes', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '0';
                    $_val = '';
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_to_bytes key', $_wireType));
                                $_keyTemp = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_keyTemp |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = (string) $_keyTemp;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint64_to_bytes value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint64_to_bytes[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing sint32/sint64 keys
 */
class MapSintKeys
{
    /** @var array<int, int> */
    public array $sint32_to_int32 = [];

    /** @var array<int, int> */
    public array $sint64_to_int64 = [];

    /**
     * Decodes a MapSintKeys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint32_to_int32', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_to_int32 key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = ($_u >> 1) ^ -($_u & 1);
                                if ($_key > 0x7FFFFFFF) $_key -= 0x100000000;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_to_int32 value', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_u;
                                if ($_val > 0x7FFFFFFF) $_val -= 0x100000000;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint32_to_int32[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint64_to_int64', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_to_int64 key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_key = ($_u >> 1) ^ -($_u & 1);
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_to_int64 value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint64_to_int64[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing fixed-width keys
 */
class MapFixedKeys
{
    /** @var array<int, string> */
    public array $fixed32_to_string = [];

    /** @var array<int, string> */
    public array $fixed64_to_string = [];

    /** @var array<int, int> */
    public array $sfixed32_to_int32 = [];

    /** @var array<int, int> */
    public array $sfixed64_to_int64 = [];

    /**
     * Decodes a MapFixedKeys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = '';
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
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_to_string key', $_wireType));
                                if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed32_to_string[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = '';
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
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_to_string key', $_wireType));
                                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed64_to_string[$_key] = $_val;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_to_int32', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0;
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
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_to_int32 key', $_wireType));
                                if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_to_int32 value', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_u;
                                if ($_val > 0x7FFFFFFF) $_val -= 0x100000000;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed32_to_int32[$_key] = $_val;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_to_int64', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = 0;
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
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_to_int64 key', $_wireType));
                                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_to_int64 value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed64_to_int64[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message testing bool and string keys
 */
class MapBoolStringKeys
{
    /** @var array<bool, string> */
    public array $bool_to_string = [];

    /** @var array<string, string> */
    public array $string_to_string = [];

    /** @var array<string, int> */
    public array $string_to_int32 = [];

    /** @var array<string, Address> */
    public array $string_to_message = [];

    /**
     * Decodes a MapBoolStringKeys message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bool_to_string', $wireType));
                    $_entryLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_entryLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_limit = $i + $_entryLen;
                    $_key = false;
                    $_val = '';
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field bool_to_string key', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_keyValue = $_u;
                                if ($_keyValue > 0x7FFFFFFF) $_keyValue -= 0x100000000;
                                $_key = $_keyValue === 1;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bool_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->bool_to_string[$_key] = $_val;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_string', $wireType));
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
                    $_val = '';
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_string key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_string value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_to_string[$_key] = $_val;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_int32', $wireType));
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
                    $_val = 0;
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_int32 key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field string_to_int32 value', $_wireType));
                                $_u = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_u |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_u;
                                if ($_val > 0x7FFFFFFF) $_val -= 0x100000000;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_to_int32[$_key] = $_val;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_message', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_message key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_to_message value', $_wireType));
                                $_msgLen = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_msgLen |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_msgEnd = $i + $_msgLen;
                                if ($_msgEnd < 0 || $_msgEnd > $l) throw new \Exception('Invalid length');
                                $_val = Address::decode(array_slice($bytes, $i, $_msgLen));
                                $i = $_msgEnd;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_to_message[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Level 3 nested message
 */
class Level3
{
    public string $value = '';

    public int $depth = 0;

    /**
     * Decodes a Level3 message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field value', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->value = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field depth', $wireType));
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
                    $d->depth = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Level 2 nested message
 */
class Level2
{
    public string $name = '';

    public Level3|null $child = null;

    /** @var Level3[] */
    public array $children = [];

    /**
     * Decodes a Level2 message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field name', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->name = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child', $wireType));
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
                    $d->child = Level3::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field children', $wireType));
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
                    $d->children[] = Level3::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Level 1 nested message
 */
class Level1
{
    public string $name = '';

    public Level2|null $child = null;

    /** @var array<string, Level2> */
    public array $child_map = [];

    /**
     * Decodes a Level1 message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field name', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->name = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child', $wireType));
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
                    $d->child = Level2::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child_map', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child_map key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child_map value', $_wireType));
                                $_msgLen = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_msgLen |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_msgEnd = $i + $_msgLen;
                                if ($_msgEnd < 0 || $_msgEnd > $l) throw new \Exception('Invalid length');
                                $_val = Level2::decode(array_slice($bytes, $i, $_msgLen));
                                $i = $_msgEnd;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->child_map[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Root message with nested structure
 */
class NestedStructure
{
    public string $root_name = '';

    public Level1|null $child = null;

    /** @var Level1[] */
    public array $children = [];

    /**
     * Decodes a NestedStructure message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field root_name', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->root_name = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field child', $wireType));
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
                    $d->child = Level1::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field children', $wireType));
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
                    $d->children[] = Level1::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message with optional fields
 */
class OptionalFieldsTest
{
    /**
     * Regular field (no has method)
     */
    public int $regular_int32 = 0;

    /**
     * Optional fields (generates has methods)
     */
    public int|null $optional_int32 = null;

    public string|null $optional_string = null;

    public bool|null $optional_bool = null;

    public float|null $optional_double = null;

    public Address|null $optional_message = null;

    /**
     * Decodes a OptionalFieldsTest message from binary protobuf format
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
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field regular_int32', $wireType));
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
                    $d->regular_int32 = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field optional_int32', $wireType));
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
                    $d->optional_int32 = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field optional_string', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->optional_string = $_value;
                    break;
                case 4:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field optional_bool', $wireType));
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
                    $d->optional_bool = $_value === 1;
                    break;
                case 5:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field optional_double', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->optional_double = $_value;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field optional_message', $wireType));
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
                    $d->optional_message = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Person with address and financial info
 */
class Person
{
    public string $name = '';

    public int $age = 0;

    public Address|null $home_address = null;

    public Address|null $work_address = null;

    /** @var Money[] */
    public array $accounts = [];

    public Timestamp|null $created_at = null;

    public Coordinates|null $location = null;

    /**
     * Decodes a Person message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field name', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->name = $_value;
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field age', $wireType));
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
                    $d->age = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field home_address', $wireType));
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
                    $d->home_address = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field work_address', $wireType));
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
                    $d->work_address = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field accounts', $wireType));
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
                    $d->accounts[] = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 6:
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
                case 7:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field location', $wireType));
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
                    $d->location = Coordinates::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Edge case values
 */
class EdgeCases
{
    /**
     * Zero values
     */
    public int $zero_int32 = 0;

    public string $empty_string = '';

    public string $empty_bytes = '';

    /**
     * Negative numbers (using sint for efficient encoding)
     */
    public int $negative_sint32 = 0;

    public int $negative_sint64 = 0;

    /**
     * Maximum values
     * 2147483647
     */
    public int $max_int32 = 0;

    /**
     * 9223372036854775807
     */
    public int $max_int64 = 0;

    /**
     * 4294967295
     */
    public int $max_uint32 = 0;

    /**
     * 18446744073709551615 (as string in PHP)
     */
    public string $max_uint64 = '0';

    /**
     * Minimum values
     * -2147483648
     */
    public int $min_int32 = 0;

    /**
     * -9223372036854775808
     */
    public int $min_int64 = 0;

    /**
     * Special floating point values
     */
    public float $float_zero = 0.0;

    public float $float_infinity = 0.0;

    public float $float_neg_infinity = 0.0;

    public float $double_max = 0.0;

    public float $double_min = 0.0;

    /**
     * Unicode strings
     * Test emojis, chinese, etc
     */
    public string $unicode_string = '';

    /**
     * String with \n
     */
    public string $multiline_string = '';

    /**
     * Large bytes field
     */
    public string $large_bytes = '';

    /**
     * Decodes a EdgeCases message from binary protobuf format
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
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field zero_int32', $wireType));
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
                    $d->zero_int32 = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field empty_string', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->empty_string = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field empty_bytes', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->empty_bytes = $_value;
                    break;
                case 4:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field negative_sint32', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                    $d->negative_sint32 = $_value;
                    break;
                case 5:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field negative_sint64', $wireType));
                    $_u = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_u |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_value = ($_u >> 1) ^ -($_u & 1);
                    $d->negative_sint64 = $_value;
                    break;
                case 6:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field max_int32', $wireType));
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
                    $d->max_int32 = $_value;
                    break;
                case 7:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field max_int64', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->max_int64 = $_value;
                    break;
                case 8:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field max_uint32', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->max_uint32 = $_value;
                    break;
                case 9:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field max_uint64', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->max_uint64 = (string) $_value;
                    break;
                case 10:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field min_int32', $wireType));
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
                    $d->min_int32 = $_value;
                    break;
                case 11:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field min_int64', $wireType));
                    $_value = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_value |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $d->min_int64 = $_value;
                    break;
                case 12:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field float_zero', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 4);
                    $i += 4;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('f', pack('C*', ...$_b))[1];
                    $d->float_zero = $_value;
                    break;
                case 13:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field float_infinity', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 4);
                    $i += 4;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('f', pack('C*', ...$_b))[1];
                    $d->float_infinity = $_value;
                    break;
                case 14:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field float_neg_infinity', $wireType));
                    if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 4);
                    $i += 4;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('f', pack('C*', ...$_b))[1];
                    $d->float_neg_infinity = $_value;
                    break;
                case 15:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field double_max', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->double_max = $_value;
                    break;
                case 16:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field double_min', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_b = array_slice($bytes, $i, 8);
                    $i += 8;
                    if (\Proteus\isBigEndian()) $_b = array_reverse($_b);
                    $_value = unpack('d', pack('C*', ...$_b))[1];
                    $d->double_min = $_value;
                    break;
                case 17:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field unicode_string', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->unicode_string = $_value;
                    break;
                case 18:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field multiline_string', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->multiline_string = $_value;
                    break;
                case 19:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field large_bytes', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->large_bytes = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message named with reserved word
 */
class Empty_
{
    public string $content = '';

    /**
     * Decodes a Empty_ message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field content', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->content = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message with field names that are reserved words
 */
class ReservedFieldNames
{
    /**
     * PHP reserved: class
     */
    public string $class_ = '';

    /**
     * PHP reserved: function
     */
    public string $function_ = '';

    /**
     * PHP reserved: int
     */
    public int $int_ = 0;

    /**
     * PHP reserved: string
     */
    public string $string_ = '';

    /**
     * PHP reserved: bool
     */
    public bool $bool_ = false;

    /**
     * PHP class: Exception
     */
    public string $exception_ = '';

    /**
     * Decodes a ReservedFieldNames message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field class_', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->class_ = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field function_', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->function_ = $_value;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int_', $wireType));
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
                    $d->int_ = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->string_ = $_value;
                    break;
                case 5:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field bool_', $wireType));
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
                    $d->bool_ = $_value === 1;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field exception_', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->exception_ = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Message with many fields for stress testing
 */
class StressTest
{
    /**
     * 50 string fields
     */
    public string $field_001 = '';

    public string $field_002 = '';

    public string $field_003 = '';

    public string $field_004 = '';

    public string $field_005 = '';

    public string $field_006 = '';

    public string $field_007 = '';

    public string $field_008 = '';

    public string $field_009 = '';

    public string $field_010 = '';

    public string $field_011 = '';

    public string $field_012 = '';

    public string $field_013 = '';

    public string $field_014 = '';

    public string $field_015 = '';

    public string $field_016 = '';

    public string $field_017 = '';

    public string $field_018 = '';

    public string $field_019 = '';

    public string $field_020 = '';

    public string $field_021 = '';

    public string $field_022 = '';

    public string $field_023 = '';

    public string $field_024 = '';

    public string $field_025 = '';

    public string $field_026 = '';

    public string $field_027 = '';

    public string $field_028 = '';

    public string $field_029 = '';

    public string $field_030 = '';

    public string $field_031 = '';

    public string $field_032 = '';

    public string $field_033 = '';

    public string $field_034 = '';

    public string $field_035 = '';

    public string $field_036 = '';

    public string $field_037 = '';

    public string $field_038 = '';

    public string $field_039 = '';

    public string $field_040 = '';

    public string $field_041 = '';

    public string $field_042 = '';

    public string $field_043 = '';

    public string $field_044 = '';

    public string $field_045 = '';

    public string $field_046 = '';

    public string $field_047 = '';

    public string $field_048 = '';

    public string $field_049 = '';

    public string $field_050 = '';

    /**
     * Mix of different types
     */
    /** @var int[] */
    public array $int_list = [];

    /** @var array<string, string> */
    public array $metadata = [];

    public Address|null $address = null;

    /** @var Money[] */
    public array $transactions = [];

    /**
     * Decodes a StressTest message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_001', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_001 = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_002', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_002 = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_003', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_003 = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_004', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_004 = $_value;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_005', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_005 = $_value;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_006', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_006 = $_value;
                    break;
                case 7:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_007', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_007 = $_value;
                    break;
                case 8:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_008', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_008 = $_value;
                    break;
                case 9:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_009', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_009 = $_value;
                    break;
                case 10:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_010', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_010 = $_value;
                    break;
                case 11:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_011', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_011 = $_value;
                    break;
                case 12:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_012', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_012 = $_value;
                    break;
                case 13:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_013', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_013 = $_value;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_014', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_014 = $_value;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_015', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_015 = $_value;
                    break;
                case 16:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_016', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_016 = $_value;
                    break;
                case 17:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_017', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_017 = $_value;
                    break;
                case 18:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_018', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_018 = $_value;
                    break;
                case 19:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_019', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_019 = $_value;
                    break;
                case 20:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_020', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_020 = $_value;
                    break;
                case 21:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_021', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_021 = $_value;
                    break;
                case 22:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_022', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_022 = $_value;
                    break;
                case 23:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_023', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_023 = $_value;
                    break;
                case 24:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_024', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_024 = $_value;
                    break;
                case 25:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_025', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_025 = $_value;
                    break;
                case 26:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_026', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_026 = $_value;
                    break;
                case 27:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_027', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_027 = $_value;
                    break;
                case 28:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_028', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_028 = $_value;
                    break;
                case 29:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_029', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_029 = $_value;
                    break;
                case 30:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_030', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_030 = $_value;
                    break;
                case 31:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_031', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_031 = $_value;
                    break;
                case 32:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_032', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_032 = $_value;
                    break;
                case 33:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_033', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_033 = $_value;
                    break;
                case 34:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_034', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_034 = $_value;
                    break;
                case 35:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_035', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_035 = $_value;
                    break;
                case 36:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_036', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_036 = $_value;
                    break;
                case 37:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_037', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_037 = $_value;
                    break;
                case 38:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_038', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_038 = $_value;
                    break;
                case 39:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_039', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_039 = $_value;
                    break;
                case 40:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_040', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_040 = $_value;
                    break;
                case 41:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_041', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_041 = $_value;
                    break;
                case 42:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_042', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_042 = $_value;
                    break;
                case 43:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_043', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_043 = $_value;
                    break;
                case 44:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_044', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_044 = $_value;
                    break;
                case 45:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_045', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_045 = $_value;
                    break;
                case 46:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_046', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_046 = $_value;
                    break;
                case 47:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_047', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_047 = $_value;
                    break;
                case 48:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_048', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_048 = $_value;
                    break;
                case 49:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_049', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_049 = $_value;
                    break;
                case 50:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field field_050', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->field_050 = $_value;
                    break;
                case 51:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int_list', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = $bytes[$i++];
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
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
                        $d->int_list[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_INT32 field over/under-read');
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
                    $d->int_list[] = $_value;
                    break;
                case 52:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata', $wireType));
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
                    $_val = '';
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->metadata[$_key] = $_val;
                    break;
                case 53:
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
                case 54:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field transactions', $wireType));
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
                    $d->transactions[] = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Order item
 */
class OrderItem
{
    public string $product_id = '';

    public string $product_name = '';

    public int $quantity = 0;

    public Money|null $unit_price = null;

    public Money|null $total_price = null;

    /**
     * color, size, etc
     */
    /** @var array<string, string> */
    public array $attributes = [];

    /**
     * Decodes a OrderItem message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field product_id', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->product_id = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field product_name', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->product_name = $_value;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field quantity', $wireType));
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
                    $d->quantity = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field unit_price', $wireType));
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
                    $d->unit_price = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field total_price', $wireType));
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
                    $d->total_price = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field attributes', $wireType));
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
                    $_val = '';
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field attributes key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field attributes value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->attributes[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

/**
 * Customer order (realistic use case)
 *  Note: status as int32 (0=unspecified, 1=pending, 2=confirmed, 3=shipped, 4=delivered, 5=cancelled)
 *  Enums not yet supported by Proteus
 */
class Order
{
    public string $order_id = '';

    public string $customer_id = '';

    /**
     * Order status code
     */
    public int $status = 0;

    public Timestamp|null $created_at = null;

    public Timestamp|null $updated_at = null;

    public Timestamp|null $delivered_at = null;

    /**
     * Items
     */
    /** @var OrderItem[] */
    public array $items = [];

    /**
     * Addresses
     */
    public Address|null $shipping_address = null;

    /**
     * may be same as shipping
     */
    public Address|null $billing_address = null;

    /**
     * Pricing
     */
    public Money|null $subtotal = null;

    public Money|null $tax = null;

    public Money|null $shipping_cost = null;

    public Money|null $total = null;

    /**
     * Metadata
     */
    /** @var array<string, string> */
    public array $metadata = [];

    public string $notes = '';

    /**
     * Decodes a Order message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field order_id', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->order_id = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field customer_id', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->customer_id = $_value;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field status', $wireType));
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
                    $d->status = $_value;
                    break;
                case 4:
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
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field updated_at', $wireType));
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
                    $d->updated_at = Timestamp::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 6:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field delivered_at', $wireType));
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
                    $d->delivered_at = Timestamp::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 7:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field items', $wireType));
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
                    $d->items[] = OrderItem::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 8:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field shipping_address', $wireType));
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
                    $d->shipping_address = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 9:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field billing_address', $wireType));
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
                    $d->billing_address = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 10:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field subtotal', $wireType));
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
                    $d->subtotal = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 11:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field tax', $wireType));
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
                    $d->tax = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 12:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field shipping_cost', $wireType));
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
                    $d->shipping_cost = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 13:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field total', $wireType));
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
                    $d->total = Money::decode(array_slice($bytes, $i, $_len));
                    $i = $_postIndex;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata', $wireType));
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
                    $_val = '';
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata key', $_wireType));
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
                                $_key = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field metadata value', $_wireType));
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
                                $_val = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->metadata[$_key] = $_val;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field notes', $wireType));
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
                    $_value = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));
                    $d->notes = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

