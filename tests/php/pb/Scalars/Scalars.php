<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/scalars.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Scalars;

/**
 * see https://protobuf.dev/programming-guides/proto3/#scalar
 */
class Scalars implements \Proteus\Msg
{
    /**
     * Uses IEEE 754 double-precision format.
     */
    public float $double = 0.0;

    /**
     * Uses variable-length encoding. Inefficient for encoding negative numbers - if your field is likely to have negative values, use sint32 instead.
     */
    public int $int32 = 0;

    /**
     * Uses variable-length encoding. Inefficient for encoding negative numbers - if your field is likely to have negative values, use sint64 instead.
     */
    public int $int64 = 0;

    /**
     * Uses variable-length encoding.
     */
    public int $uint32 = 0;

    /**
     * Uses variable-length encoding.
     */
    public string $uint64 = '0';

    /**
     * Uses variable-length encoding. Signed int value. These more efficiently encode negative numbers than regular int32s.
     */
    public int $sint32 = 0;

    /**
     * Uses variable-length encoding. Signed int value. These more efficiently encode negative numbers than regular int64s.
     */
    public int $sint64 = 0;

    /**
     * Always four bytes. More efficient than uint32 if values are often greater than 228.
     */
    public int $fixed32 = 0;

    /**
     * Always eight bytes. More efficient than uint64 if values are often greater than 256.
     */
    public string $fixed64 = '0';

    /**
     * Always four bytes.
     */
    public int $sfixed32 = 0;

    /**
     * Always eight bytes.
     */
    public int $sfixed64 = 0;

    public bool $bool = false;

    /**
     * A string must always contain UTF-8 encoded or 7-bit ASCII text, and cannot be longer than 232.
     */
    public string $string = '';

    /**
     * May contain any arbitrary sequence of bytes no longer than 232.
     */
    public string $bytes = '';

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
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field double', $wireType));
                    $d->double = unpack('d', substr($bytes, $i, 8))[1];
                    $i += 8;
                    break;
                case 3:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $d->int32 = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $d->int32 |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    break;
                case 4:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $d->int64 = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $d->int64 |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    break;
                case 5:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $d->uint32 = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $d->uint32 |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    break;
                case 6:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64', $wireType));
                    $_u = gmp_init(0);
                    for ($_s = 0;; ++$_s) {
                        $_b = gmp_init(ord(@$bytes[$i++]));
                        $_u = gmp_or($_u, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_s * 7)));
                        if ($_b < 0x80) break;
                    }
                    $d->uint64 = gmp_strval($_u);
                    break;
                case 7:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_u = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->sint32 = ($_u >> 1) ^ -($_u & 1);
                    break;
                case 8:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64', $wireType));
                    $_u = gmp_init(0);
                    for ($_s = 0;; ++$_s) {
                        $_b = gmp_init(ord(@$bytes[$i++]));
                        $_u = gmp_or($_u, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_s * 7)));
                        if ($_b < 0x80) break;
                    }
                    $d->sint64 = gmp_intval(gmp_xor(gmp_div($_u, 2), gmp_neg(gmp_and($_u, 1))));
                    break;
                case 9:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field fixed32', $wireType));
                    $d->fixed32 = unpack('L', substr($bytes, $i, 4))[1];
                    $i += 4;
                    break;
                case 10:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field fixed64', $wireType));
                    $d->fixed64 = gmp_strval(gmp_import(substr($bytes, $i, 8), GMP_BIG_ENDIAN));
                    $i += 8;
                    break;
                case 11:
                    if ($wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32', $wireType));
                    $d->sfixed32 = unpack('l', substr($bytes, $i, 4))[1];
                    $i += 4;
                    break;
                case 12:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64', $wireType));
                    $d->sfixed64 = unpack('q', substr($bytes, $i, 8))[1];
                    $i += 8;
                    break;
                case 13:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_u = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->bool = $_u === 1;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->string = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field bytes', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->bytes = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->bytes = base64_encode($d->bytes);
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        if ($i !== $l) throw new \Exception('Unexpected EOF');
        return $d;
    }

}

