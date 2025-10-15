<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: map.proto
 */

declare(strict_types=1);

namespace Tests\PB;

use Tests\PB\Address;

if (PHP_INT_SIZE !== 8) {
    trigger_error('This message is only supported on 64-bit systems', E_USER_WARNING);
}

if (!extension_loaded('gmp')) {
    trigger_error('The gmp extension must be loaded in order to decode this message', E_USER_WARNING);
}

class NestedMap
{
    /** @var array<string, Address> */
    public array $string_address = [];

    /**
     * Decodes a NestedMap message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address key', $_wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address value', $_wireType));
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
                    $d->string_address[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

class Repeated
{
    /** @var Address[] */
    public array $addresses = [];

    /**
     * Decodes a Repeated message from binary protobuf format
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field addresses', $wireType));
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
                    $d->addresses[] = Address::decode(array_slice($bytes, $i, $_len));
                    $i = $_msgLen;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

class Map
{
    /** @var array<int, bool> */
    public array $int32_bool = [];

    /** @var array<int, bool> */
    public array $int64_bool = [];

    /** @var array<int, bool> */
    public array $uint32_bool = [];

    /** @var array<string, bool> */
    public array $uint64_bool = [];

    /** @var array<int, bool> */
    public array $sint32_bool = [];

    /** @var array<int, bool> */
    public array $sint64_bool = [];

    /** @var array<int, bool> */
    public array $fixed32_bool = [];

    /** @var array<string, bool> */
    public array $fixed64_bool = [];

    /** @var array<int, bool> */
    public array $sfixed32_bool = [];

    /** @var array<int, bool> */
    public array $sfixed64_bool = [];

    /** @var array<string, bool> */
    public array $string_bool = [];

    /** @var array<string, Address> */
    public array $string_address = [];

    /** @var array<string, Repeated> */
    public array $string_repeated = [];

    /** @var array<string, NestedMap> */
    public array $string_nested_map = [];

    /**
     * Decodes a Map message from binary protobuf format
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
                case 10:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool key', $_wireType));
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int32_bool[$_key] = $_val;
                    break;
                case 11:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool key', $_wireType));
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int64_bool[$_key] = $_val;
                    break;
                case 12:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool key', $_wireType));
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint32_bool[$_key] = $_val;
                    break;
                case 13:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool key', $_wireType));
                                $_key = gmp_init(0);
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = gmp_init($bytes[$i++]);
                                    $_key = gmp_or($_key, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_shift)));
                                    if ($_b < 0x80) break;
                                }
                                $_key = gmp_strval($_key);
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint64_bool[$_key] = $_val;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool key', $_wireType));
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint32_bool[$_key] = $_val;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool key', $_wireType));
                                $_u = gmp_init(0);
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = gmp_init($bytes[$i++]);
                                    $_u = gmp_or($_u, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_shift)));
                                    if ($_b < 0x80) break;
                                }
                                $_key = gmp_intval(gmp_xor(gmp_div($_u, 2), gmp_neg(gmp_and($_u, 1))));
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint64_bool[$_key] = $_val;
                    break;
                case 16:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool key', $_wireType));
                                if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed32_bool[$_key] = $_val;
                    break;
                case 17:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool key', $_wireType));
                                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                                $_key = gmp_strval(gmp_import(pack('C*', ...array_slice($bytes, $i, 8)), GMP_BIG_ENDIAN));
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed64_bool[$_key] = $_val;
                    break;
                case 18:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool key', $_wireType));
                                if ($i + 4 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed32_bool[$_key] = $_val;
                    break;
                case 19:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool key', $_wireType));
                                if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                                $_key = unpack('q', pack('C*', ...array_slice($bytes, $i, 8)))[1];
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed64_bool[$_key] = $_val;
                    break;
                case 20:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_bool', $wireType));
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
                    $_val = false;
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_bool key', $_wireType));
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
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field string_bool value', $_wireType));
                                $_val = 0;
                                for ($_shift = 0;; $_shift += 7) {
                                    if ($_shift >= 64) throw new \Exception('Int overflow');
                                    if ($i >= $l) throw new \Exception('Unexpected EOF');
                                    $_b = $bytes[$i++];
                                    $_val |= ($_b & 0x7F) << $_shift;
                                    if ($_b < 0x80) break;
                                }
                                $_val = $_val === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_bool[$_key] = $_val;
                    break;
                case 21:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address key', $_wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address value', $_wireType));
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
                    $d->string_address[$_key] = $_val;
                    break;
                case 23:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated key', $_wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated value', $_wireType));
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
                                $_val = Repeated::decode(array_slice($bytes, $i, $_len));
                                $i = $_msgLen;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_repeated[$_key] = $_val;
                    break;
                case 22:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map', $wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map key', $_wireType));
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
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map value', $_wireType));
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
                                $_val = NestedMap::decode(array_slice($bytes, $i, $_len));
                                $i = $_msgLen;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_nested_map[$_key] = $_val;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }
}

