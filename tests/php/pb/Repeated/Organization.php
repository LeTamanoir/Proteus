<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/repeated.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Repeated;

class Organization implements \Proteus\Msg
{
    /** @var \Tests\php\pb\Imports\User[] */
    public array $users = [];

    /** @var string[] */
    public array $emails = [];

    /** @var int[] */
    public array $ages = [];

    /** @var bool[] */
    public array $is_admin = [];

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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field users', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $d->users[] = \Tests\php\pb\Imports\User::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field emails', $wireType));
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
                    $d->emails[] = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field ages', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_b = ord($bytes[$i++]);
                        $_u = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_u |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        if ($i > $l) throw new \Exception('Unexpected EOF');
                        $_value = $_u;
                        if ($_value > 0x7FFFFFFF) $_value -= 0x100000000;
                        $d->ages[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_INT32 field over/under-read');
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field is_admin', $wireType));
                    $_b = ord($bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    if ($i > $l) throw new \Exception('Unexpected EOF');
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_b = ord($bytes[$i++]);
                        $_value = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_value |= (($_b = ord($bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        if ($i > $l) throw new \Exception('Unexpected EOF');
                        $_value = $_value === 1;
                        $d->is_admin[] = $_value;
                    }
                    if ($i !== $_end) throw new \Exception('Packed TYPE_BOOL field over/under-read');
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

