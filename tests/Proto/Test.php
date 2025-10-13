<?php

declare(strict_types=1);

namespace Tests\Proto;

use Exception;
use BcMath\Number;
use const Proteus\DEFAULT_UINT64;
use function Proteus\skipField;
use function Proteus\isBigEndian;

class DataTypes
{
    public string $str_test = '';

    public int $int_test = 0;

    public bool $bool_test = false;

    public float $float_test = 0.0;

    public float $double_test = 0.0;

    public string $bytes_test = '';

    /** @var array<string, string> */
    public array $map_test = [];

    /** @var int[] */
    public array $int_test_list = [];

    public Number $uint64_test = DEFAULT_UINT64;

    /**
     * Deserializes a DataTypes message from binary protobuf format
     *
     * @param string $bytes Binary protobuf data
     * @return self The deserialized message instance
     * @throws Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = 0;
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) throw new Exception('Int overflow');
                if ($i >= $l) throw new Exception('Unexpected EOF');
                $b = ord($bytes[$i]);
                ++$i;
                $wire |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) throw new Exception('Invalid wire type for str_test');
                    $_byteLen = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_byteLen |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    if ($_byteLen < 0) throw new Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0) throw new Exception('Invalid length');
                    if ($_postIndex > $l) throw new Exception('Unexpected EOF');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i = $_postIndex;
                    $d->str_test = $_value;
                    break;

                case 2:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for int_test');
                    $_u = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_u |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) {
                        $_value -= 0x100000000;
                    }
                    $d->int_test = $_value;
                    break;

                case 3:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for bool_test');
                    $_u = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_u |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) {
                        $_value -= 0x100000000;
                    }
                    $d->bool_test = $_value === 1;
                    break;

                case 4:
                    if ($wireType !== 5) throw new Exception('Invalid wire type for float_test');
                    if ($i + 4 > $l) throw new Exception('Unexpected EOF');
                    $_b = substr($bytes, $i, 4);
                    $i += 4;
                    if (isBigEndian()) {
                        $_b = strrev($_b);
                    }
                    $_value = unpack('f', $_b)[1];
                    $d->float_test = $_value;
                    break;

                case 5:
                    if ($wireType !== 1) throw new Exception('Invalid wire type for double_test');
                    if ($i + 8 > $l) throw new Exception('Unexpected EOF');
                    $_b = substr($bytes, $i, 8);
                    $i += 8;
                    if (isBigEndian()) {
                        $_b = strrev($_b);
                    }
                    $_value = unpack('d', $_b)[1];
                    $d->double_test = $_value;
                    break;

                case 6:
                    if ($wireType !== 2) throw new Exception('Invalid wire type for bytes_test');
                    $_byteLen = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_byteLen |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    if ($_byteLen < 0) throw new Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0) throw new Exception('Invalid length');
                    if ($_postIndex > $l) throw new Exception('Unexpected EOF');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i = $_postIndex;
                    $d->bytes_test = $_value;
                    break;

                case 7:
                    if ($wireType !== 2) throw new Exception('Invalid wire type for map_test');

                    // Map entry: read the length-delimited entry message
                    $_entryLen = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_entryLen |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_limit = $i + $_entryLen;

                    $_key = '';
                    $_val = '';

                    while ($i < $_limit) {
                        $_tag = 0;
                        for ($shift = 0;; $shift += 7) {
                            if ($shift >= 64) throw new Exception('Int overflow');
                            if ($i >= $l) throw new Exception('Unexpected EOF');
                            $b = ord($bytes[$i]);
                            ++$i;
                            $_tag |= ($b & 0x7F) << $shift;
                            if ($b < 0x80) {
                                break;
                            }
                        }
                        $_fn = $_tag >> 3; // field number inside entry: 1=key, 2=value
                        $_wt = $_tag & 0x7; // wire type

                        switch ($_fn) {
                            case 1: // key
                                if ($_wt !== 2) throw new Exception('Invalid wire type for map_test key');
                                $_byteLen = 0;
                                for ($shift = 0;; $shift += 7) {
                                    if ($shift >= 64) throw new Exception('Int overflow');
                                    if ($i >= $l) throw new Exception('Unexpected EOF');
                                    $b = ord($bytes[$i]);
                                    ++$i;
                                    $_byteLen |= ($b & 0x7F) << $shift;
                                    if ($b < 0x80) {
                                        break;
                                    }
                                }
                                if ($_byteLen < 0) throw new Exception('Invalid length');
                                $_postIndex = $i + $_byteLen;
                                if ($_postIndex < 0) throw new Exception('Invalid length');
                                if ($_postIndex > $l) throw new Exception('Unexpected EOF');
                                $_key = substr($bytes, $i, $_byteLen);
                                $i = $_postIndex;
                                break;

                            case 2: // value
                                if ($_wt !== 2) throw new Exception('Invalid wire type for map_test value');
                                $_byteLen = 0;
                                for ($shift = 0;; $shift += 7) {
                                    if ($shift >= 64) throw new Exception('Int overflow');
                                    if ($i >= $l) throw new Exception('Unexpected EOF');
                                    $b = ord($bytes[$i]);
                                    ++$i;
                                    $_byteLen |= ($b & 0x7F) << $shift;
                                    if ($b < 0x80) {
                                        break;
                                    }
                                }
                                if ($_byteLen < 0) throw new Exception('Invalid length');
                                $_postIndex = $i + $_byteLen;
                                if ($_postIndex < 0) throw new Exception('Invalid length');
                                if ($_postIndex > $l) throw new Exception('Unexpected EOF');
                                $_val = substr($bytes, $i, $_byteLen);
                                $i = $_postIndex;
                                break;

                            default:
                                skipField($i, $l, $bytes, $_wt);
                        }
                    }

                    $d->map_test[$_key] = $_val;
                    break;

                case 8:
                    if ($wireType === 2) {
                        // Packed encoding: length-delimited sequence
                        $_len = 0;
                        for ($shift = 0;; $shift += 7) {
                            if ($shift >= 64) throw new Exception('Int overflow');
                            if ($i >= $l) throw new Exception('Unexpected EOF');
                            $b = ord($bytes[$i]);
                            ++$i;
                            $_len |= ($b & 0x7F) << $shift;
                            if ($b < 0x80) {
                                break;
                            }
                        }
                        $_end = $i + $_len;

                        while ($i < $_end) {
                            $_u = 0;
                            for ($shift = 0;; $shift += 7) {
                                if ($shift >= 64) throw new Exception('Int overflow');
                                if ($i >= $l) throw new Exception('Unexpected EOF');
                                $b = ord($bytes[$i]);
                                ++$i;
                                $_u |= ($b & 0x7F) << $shift;
                                if ($b < 0x80) {
                                    break;
                                }
                            }
                            $_value = $_u;
                            if ($_value > 0x7FFFFFFF) {
                                $_value -= 0x100000000;
                            }
                            $d->int_test_list[] = $_value;
                        }

                        if ($i !== $_end) throw new Exception('Packed int32 field over/under-read');
                    } else if ($wireType === 0) {
                        // Unpacked encoding: individual elements
                        $_u = 0;
                        for ($shift = 0;; $shift += 7) {
                            if ($shift >= 64) throw new Exception('Int overflow');
                            if ($i >= $l) throw new Exception('Unexpected EOF');
                            $b = ord($bytes[$i]);
                            ++$i;
                            $_u |= ($b & 0x7F) << $shift;
                            if ($b < 0x80) {
                                break;
                            }
                        }
                        $_value = $_u;
                        if ($_value > 0x7FFFFFFF) {
                            $_value -= 0x100000000;
                        }
                        $d->int_test_list[] = $_value;
                    } else throw new Exception('Invalid wire type for int_test_list');
                    break;

                case 9:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for uint64_test');
                    $_value = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_value |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $d->uint64_test = $d->uint64_test->add($_value);
                    break;

                default:
                    skipField($i, $l, $bytes, $wireType);
            }
        }

        return $d;
    }
}

class Empty_
{

    /**
     * Deserializes a Empty message from binary protobuf format
     *
     * @param string $bytes Binary protobuf data
     * @return self The deserialized message instance
     * @throws Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = 0;
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) throw new Exception('Int overflow');
                if ($i >= $l) throw new Exception('Unexpected EOF');
                $b = ord($bytes[$i]);
                ++$i;
                $wire |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                default:
                    skipField($i, $l, $bytes, $wireType);
            }
        }

        return $d;
    }
}

class DelayRequest
{
    public int $ms = 0;

    /**
     * Deserializes a DelayRequest message from binary protobuf format
     *
     * @param string $bytes Binary protobuf data
     * @return self The deserialized message instance
     * @throws Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = 0;
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) throw new Exception('Int overflow');
                if ($i >= $l) throw new Exception('Unexpected EOF');
                $b = ord($bytes[$i]);
                ++$i;
                $wire |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for ms');
                    $_u = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_u |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) {
                        $_value -= 0x100000000;
                    }
                    $d->ms = $_value;
                    break;

                default:
                    skipField($i, $l, $bytes, $wireType);
            }
        }

        return $d;
    }
}

class FailurePatternRequest
{
    public int $fail_times = 0;

    public int $error_code = 0;

    public string $key = '';

    /**
     * Deserializes a FailurePatternRequest message from binary protobuf format
     *
     * @param string $bytes Binary protobuf data
     * @return self The deserialized message instance
     * @throws Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = 0;
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) throw new Exception('Int overflow');
                if ($i >= $l) throw new Exception('Unexpected EOF');
                $b = ord($bytes[$i]);
                ++$i;
                $wire |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for fail_times');
                    $_u = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_u |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) {
                        $_value -= 0x100000000;
                    }
                    $d->fail_times = $_value;
                    break;

                case 2:
                    if ($wireType !== 0) throw new Exception('Invalid wire type for error_code');
                    $_u = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_u |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    $_value = $_u;
                    if ($_value > 0x7FFFFFFF) {
                        $_value -= 0x100000000;
                    }
                    $d->error_code = $_value;
                    break;

                case 3:
                    if ($wireType !== 2) throw new Exception('Invalid wire type for key');
                    $_byteLen = 0;
                    for ($shift = 0;; $shift += 7) {
                        if ($shift >= 64) throw new Exception('Int overflow');
                        if ($i >= $l) throw new Exception('Unexpected EOF');
                        $b = ord($bytes[$i]);
                        ++$i;
                        $_byteLen |= ($b & 0x7F) << $shift;
                        if ($b < 0x80) {
                            break;
                        }
                    }
                    if ($_byteLen < 0) throw new Exception('Invalid length');
                    $_postIndex = $i + $_byteLen;
                    if ($_postIndex < 0) throw new Exception('Invalid length');
                    if ($_postIndex > $l) throw new Exception('Unexpected EOF');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i = $_postIndex;
                    $d->key = $_value;
                    break;

                default:
                    skipField($i, $l, $bytes, $wireType);
            }
        }

        return $d;
    }
}

