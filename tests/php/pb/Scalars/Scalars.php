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
final class Scalars extends \Proteus\Msg
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

    /**
     * @internal
     */
    public function __encode(): string
    {
        $buf = '';
        if ($this->double !== 0.0) {
            $buf .= "\x09";
            $buf .= pack('d', $this->double);
        }
        if ($this->int32 !== 0) {
            $buf .= "\x18";
            $_v = $this->int32;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v);
            }
        }
        if ($this->int64 !== 0) {
            $buf .= "\x20";
            $_v = $this->int64;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v);
            }
        }
        if ($this->uint32 !== 0) {
            $buf .= "\x28";
            $_v = $this->uint32;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $buf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $buf .= chr($_v);
            }
        }
        if ($this->uint64 !== '0') {
            $buf .= "\x30";
            $_v = gmp_init($this->uint64);
            while (gmp_cmp($_v, 0x80) >= 0) {
                $buf .= chr(gmp_intval(gmp_or($_v, 0x80)) & 0xFF);
                $_v = gmp_div($_v, 0x80);
            }
            $buf .= chr(gmp_intval($_v));
        }
        if ($this->sint32 !== 0) {
            $buf .= "\x38";
            $_u = ($this->sint32 << 1) ^ ($this->sint32 >> 31);
            $_v = $_u;
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
        }
        if ($this->sint64 !== 0) {
            $buf .= "\x40";
            $_u = ($this->sint64 << 1) ^ ($this->sint64 >> 63);
            if ($_u < 0) {
                $_u = gmp_init($_u);
                $_u = gmp_add($_u, gmp_pow(2, 64));
                $_v = gmp_init(gmp_strval($_u));
                while (gmp_cmp($_v, 0x80) >= 0) {
                    $buf .= chr(gmp_intval(gmp_or($_v, 0x80)) & 0xFF);
                    $_v = gmp_div($_v, 0x80);
                }
                $buf .= chr(gmp_intval($_v));
            } else {
                $_v = $_u;
                if ($_v < 0) {
                    $_v &= 0x7FFFFFFFFFFFFFFF;
                    for ($_i = 0; $_i < 9; ++$_i) {
                        $buf .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $buf .= chr($_v | 0x01);
                } else {
                    while ($_v >= 0x80) {
                        $buf .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $buf .= chr($_v);
                }
            }
        }
        if ($this->fixed32 !== 0) {
            $buf .= "\x4d";
            $buf .= pack('L', $this->fixed32);
        }
        if ($this->fixed64 !== '0') {
            $buf .= "\x51";
            $buf .= gmp_export(gmp_init($this->fixed64), GMP_BIG_ENDIAN, 8);
        }
        if ($this->sfixed32 !== 0) {
            $buf .= "\x5d";
            $buf .= pack('l', $this->sfixed32);
        }
        if ($this->sfixed64 !== 0) {
            $buf .= "\x61";
            $buf .= pack('q', $this->sfixed64);
        }
        if ($this->bool !== false) {
            $buf .= "\x68";
            $buf .= chr($this->bool ? 1 : 0);
        }
        if ($this->string !== '') {
            $buf .= "\x72";
            $_v = strlen($this->string);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->string;
        }
        if ($this->bytes !== '') {
            $buf .= "\x7a";
            $_bytes = base64_decode($this->bytes);
            $_v = strlen($_bytes);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_bytes;
        }
        return $buf;
    }
}

