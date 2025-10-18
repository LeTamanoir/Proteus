<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/map.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Map;

final class Map extends \Proteus\Msg
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

    /** @var array<string, \Tests\php\pb\Common\Address> */
    public array $string_address = [];

    /** @var array<string, \Tests\php\pb\Map\Repeated> */
    public array $string_repeated = [];

    /** @var array<string, \Tests\php\pb\Map\NestedMap> */
    public array $string_nested_map = [];

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
                case 10:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_key = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_key |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int32_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int32_bool[$_key] = $_val;
                    break;
                case 11:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_key = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_key |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field int64_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->int64_bool[$_key] = $_val;
                    break;
                case 12:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_key = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_key |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint32_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint32_bool[$_key] = $_val;
                    break;
                case 13:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '0';
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool key', $_wireType));
                                $_u = gmp_init(0);
                                for ($_s = 0;; ++$_s) {
                                    $_b = gmp_init(ord(@$bytes[$i++]));
                                    $_u = gmp_or($_u, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_s * 7)));
                                    if ($_b < 0x80) break;
                                }
                                $_key = gmp_strval($_u);
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field uint64_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->uint64_bool[$_key] = $_val;
                    break;
                case 14:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = ($_u >> 1) ^ -($_u & 1);
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint32_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint32_bool[$_key] = $_val;
                    break;
                case 15:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool key', $_wireType));
                                $_u = gmp_init(0);
                                for ($_s = 0;; ++$_s) {
                                    $_b = gmp_init(ord(@$bytes[$i++]));
                                    $_u = gmp_or($_u, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_s * 7)));
                                    if ($_b < 0x80) break;
                                }
                                $_key = gmp_intval(gmp_xor(gmp_div($_u, 2), gmp_neg(gmp_and($_u, 1))));
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sint64_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sint64_bool[$_key] = $_val;
                    break;
                case 16:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool key', $_wireType));
                                $_key = unpack('L', substr($bytes, $i, 4))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field fixed32_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed32_bool[$_key] = $_val;
                    break;
                case 17:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '0';
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool key', $_wireType));
                                $_key = gmp_strval(gmp_import(substr($bytes, $i, 8), GMP_BIG_ENDIAN));
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field fixed64_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->fixed64_bool[$_key] = $_val;
                    break;
                case 18:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 5) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool key', $_wireType));
                                $_key = unpack('l', substr($bytes, $i, 4))[1];
                                $i += 4;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed32_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed32_bool[$_key] = $_val;
                    break;
                case 19:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = 0;
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool key', $_wireType));
                                $_key = unpack('q', substr($bytes, $i, 8))[1];
                                $i += 8;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field sfixed64_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->sfixed64_bool[$_key] = $_val;
                    break;
                case 20:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_bool', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = false;
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_bool key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field string_bool value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_u = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = $_u === 1;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_bool[$_key] = $_val;
                    break;
                case 21:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_address value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = \Tests\php\pb\Common\Address::__decode($bytes, $i, $i + $_len);
                                $i += $_len;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_address[$_key] = $_val;
                    break;
                case 23:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_repeated value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = \Tests\php\pb\Map\Repeated::__decode($bytes, $i, $i + $_len);
                                $i += $_len;
                                break;
                            default:
                                $i = \Proteus\skipField($i, $l, $bytes, $_wireType);
                        }
                    }
                    $d->string_repeated[$_key] = $_val;
                    break;
                case 22:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_entryLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_entryLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_limit = $i + $_entryLen;
                    $_key = '';
                    $_val = [];
                    while ($i < $_limit) {
                        $_b = ord(@$bytes[$i++]);
                        $_tag = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_tag |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_fieldNum = $_tag >> 3;
                        $_wireType = $_tag & 0x7;
                        switch ($_fieldNum) {
                            case 1:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map key', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_byteLen = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_key = substr($bytes, $i, $_byteLen);
                                $i += $_byteLen;
                                break;
                            case 2:
                                if ($_wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field string_nested_map value', $_wireType));
                                $_b = ord(@$bytes[$i++]);
                                $_len = $_b & 0x7F;
                                if ($_b >= 0x80) {
                                    $_s = 0;
                                    while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                                    if ($_s > 63) throw new \Exception('Int overflow');
                                }
                                $_val = \Tests\php\pb\Map\NestedMap::__decode($bytes, $i, $i + $_len);
                                $i += $_len;
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
        if ($i !== $l) throw new \Exception('Unexpected EOF');
        return $d;
    }

    /**
     * @internal
     */
    public function __encode(): string
    {
        $buf = '';
        foreach ($this->int32_bool as $_key => $_val) {
            $buf .= "\x52";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_v = $_key;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v);
            }
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->int64_bool as $_key => $_val) {
            $buf .= "\x5a";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_v = $_key;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v);
            }
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->uint32_bool as $_key => $_val) {
            $buf .= "\x62";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_v = $_key;
            if ($_v < 0) {
                $_v &= 0x7FFFFFFFFFFFFFFF;
                for ($_i = 0; $_i < 9; ++$_i) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v | 0x01);
            } else {
                while ($_v >= 0x80) {
                    $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                    $_v >>= 7;
                }
                $_entryBuf .= chr($_v);
            }
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->uint64_bool as $_key => $_val) {
            $buf .= "\x6a";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_v = gmp_init($_key);
            while (gmp_cmp($_v, 0x80) >= 0) {
                $_entryBuf .= chr(gmp_intval(gmp_or($_v, 0x80)) & 0xFF);
                $_v = gmp_div($_v, 0x80);
            }
            $_entryBuf .= chr(gmp_intval($_v));
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->sint32_bool as $_key => $_val) {
            $buf .= "\x72";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_u = ($_key << 1) ^ ($_key >> 31);
            $_v = $_u;
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->sint64_bool as $_key => $_val) {
            $buf .= "\x7a";
            $_entryBuf = '';
            $_entryBuf .= "\x08";
            $_u = ($_key << 1) ^ ($_key >> 63);
            if ($_u < 0) {
                $_u = gmp_init($_u);
                $_u = gmp_add($_u, gmp_pow(2, 64));
                $_v = gmp_init(gmp_strval($_u));
                while (gmp_cmp($_v, 0x80) >= 0) {
                    $_entryBuf .= chr(gmp_intval(gmp_or($_v, 0x80)) & 0xFF);
                    $_v = gmp_div($_v, 0x80);
                }
                $_entryBuf .= chr(gmp_intval($_v));
            } else {
                $_v = $_u;
                if ($_v < 0) {
                    $_v &= 0x7FFFFFFFFFFFFFFF;
                    for ($_i = 0; $_i < 9; ++$_i) {
                        $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $_entryBuf .= chr($_v | 0x01);
                } else {
                    while ($_v >= 0x80) {
                        $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $_entryBuf .= chr($_v);
                }
            }
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->fixed32_bool as $_key => $_val) {
            $buf .= "\x82\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0d";
            $_entryBuf .= pack('L', $_key);
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->fixed64_bool as $_key => $_val) {
            $buf .= "\x8a\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x09";
            $_entryBuf .= gmp_export(gmp_init($_key), GMP_BIG_ENDIAN, 8);
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->sfixed32_bool as $_key => $_val) {
            $buf .= "\x92\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0d";
            $_entryBuf .= pack('l', $_key);
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->sfixed64_bool as $_key => $_val) {
            $buf .= "\x9a\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x09";
            $_entryBuf .= pack('q', $_key);
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->string_bool as $_key => $_val) {
            $buf .= "\xa2\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0a";
            $_v = strlen($_key);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_key;
            $_entryBuf .= "\x10";
            $_entryBuf .= chr($_val ? 1 : 0);
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->string_address as $_key => $_val) {
            $buf .= "\xaa\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0a";
            $_v = strlen($_key);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_key;
            $_entryBuf .= "\x12";
            $_msgBuf = $_val->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_msgBuf;
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->string_repeated as $_key => $_val) {
            $buf .= "\xba\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0a";
            $_v = strlen($_key);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_key;
            $_entryBuf .= "\x12";
            $_msgBuf = $_val->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_msgBuf;
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        foreach ($this->string_nested_map as $_key => $_val) {
            $buf .= "\xb2\x01";
            $_entryBuf = '';
            $_entryBuf .= "\x0a";
            $_v = strlen($_key);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_key;
            $_entryBuf .= "\x12";
            $_msgBuf = $_val->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $_entryBuf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $_entryBuf .= chr($_v);
            $_entryBuf .= $_msgBuf;
            $_v = strlen($_entryBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_entryBuf;
        }
        return $buf;
    }
}

