<?php

declare(strict_types=1);

namespace Tests\Proto;

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

    public \BcMath\Number $uint64_test = DEFAULT_UINT64;

    /**
     * Deserializes a DataTypes message from binary protobuf format
     *
     * @param string $bytes Binary protobuf data
     * @return self The deserialized message instance
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = readVarint($i, $l, $bytes);
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) {
                        throw new \Exception('Invalid wire type for str_test');
                    }
                    $d->str_test = readBytes($i, $l, $bytes);
                    break;

                case 2:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for int_test');
                    }
                    $d->int_test = readVarint($i, $l, $bytes);
                    break;

                case 3:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for bool_test');
                    }
                    $d->bool_test = readVarint($i, $l, $bytes) === 1;
                    break;

                case 4:
                    if ($wireType !== 5) {
                        throw new \Exception('Invalid wire type for float_test');
                    }
                    $d->float_test = readFloat32($i, $l, $bytes);
                    break;

                case 5:
                    if ($wireType !== 1) {
                        throw new \Exception('Invalid wire type for double_test');
                    }
                    $d->double_test = readFloat64($i, $l, $bytes);
                    break;

                case 6:
                    if ($wireType !== 2) {
                        throw new \Exception('Invalid wire type for bytes_test');
                    }
                    $d->bytes_test = readBytes($i, $l, $bytes);
                    break;

                case 7:
                    if ($wireType !== 2) {
                        throw new \Exception('Invalid wire type for map_test');
                    }

                    // Map entry: read the length-delimited entry message
                    $entryLen = readVarint($i, $l, $bytes);
                    $limit = $i + $entryLen;

                    $key = '';
                    $val = '';

                    while ($i < $limit) {
                        $tag = readVarint($i, $l, $bytes);
                        $fn = $tag >> 3; // field number inside entry: 1=key, 2=value
                        $wt = $tag & 0x7; // wire type

                        switch ($fn) {
                            case 1: // key
                                if ($wt !== 2) {
                                    throw new \Exception('Invalid wire type for map_test key');
                                }
                                $key = readBytes($i, $l, $bytes);
                                break;

                            case 2: // value
                                if ($wt !== 2) {
                                    throw new \Exception('Invalid wire type for map_test value');
                                }
                                $val = readBytes($i, $l, $bytes);
                                break;

                            default:
                                skipField($i, $l, $bytes, $wt);
                        }
                    }

                    $d->map_test[$key] = $val;
                    break;

                case 8:
                    if ($wireType === 2) {
                        // Packed encoding: length-delimited sequence
                        $len = readVarint($i, $l, $bytes);
                        $end = $i + $len;

                        while ($i < $end) {
                            $u = readVarint($i, $l, $bytes);
                            if ($u > 0x7FFFFFFF) {
                                $u -= 0x100000000;
                            }
                            $d->int_test_list[] = $u;
                        }

                        if ($i !== $end) {
                            throw new \Exception('Packed int32 field over/under-read');
                        }
                    } else if ($wireType === 0) {
                        // Unpacked encoding: individual elements
                        $d->int_test_list[] = readVarint($i, $l, $bytes);
                    } else {
                        throw new \Exception('Invalid wire type for int_test_list');
                    }
                    break;

                case 9:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for uint64_test');
                    }
                    $d->uint64_test = $d->uint64_test->add(readVarint($i, $l, $bytes));
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
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = readVarint($i, $l, $bytes);
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
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = readVarint($i, $l, $bytes);
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for ms');
                    }
                    $d->ms = readVarint($i, $l, $bytes);
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
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function fromBytes(string $bytes): self
    {
        $d = new self();

        $l = strlen($bytes);
        $i = 0;

        while ($i < $l) {
            $wire = readVarint($i, $l, $bytes);
            $fieldNum = ($wire >> 3) & 0xFFFFFFFF;
            $wireType = $wire & 0x7;

            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for fail_times');
                    }
                    $d->fail_times = readVarint($i, $l, $bytes);
                    break;

                case 2:
                    if ($wireType !== 0) {
                        throw new \Exception('Invalid wire type for error_code');
                    }
                    $d->error_code = readVarint($i, $l, $bytes);
                    break;

                case 3:
                    if ($wireType !== 2) {
                        throw new \Exception('Invalid wire type for key');
                    }
                    $d->key = readBytes($i, $l, $bytes);
                    break;

                default:
                    skipField($i, $l, $bytes, $wireType);
            }
        }

        return $d;
    }
}

