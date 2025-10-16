<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/benchmark/proteus.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\benchmark\proteus;

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
        return self::__decode($bytes, 0, strlen($bytes));
    }

    /**
     * @throws \Exception if the data is malformed or contains invalid wire types
     */
    public static function __decode(string $bytes, int $i, int $l): self
    {
        $d = new self();
        while ($i < $l) {
            $_b = ord($bytes[$i++]);
            $wire = $_b & 0x7F;
            if ($_b >= 0x80) {
                $_s = 0;
                while ($_b >= 0x80) $wire |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                if ($_s > 63) throw new \Exception('Int overflow');
            }
            if ($i > $l) throw new \Exception('Unexpected EOF');
            $fieldNum = $wire >> 3;
            $wireType = $wire & 0x7;
            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field street', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->street = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field city', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->city = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field state', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->state = $_value;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field zip_code', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->zip_code = $_value;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field country', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->country = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

