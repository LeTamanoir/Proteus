<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/repeated.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Repeated;

final class Organization extends \Proteus\Msg
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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field users', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->users[] = \Tests\php\pb\Imports\User::__decode($bytes, $i, $i + $_len);
                    $i += $_len;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field emails', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->emails[] = $_value;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field ages', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_b = ord(@$bytes[$i++]);
                        $_value = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_value |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $d->ages[] = $_value;
                    }
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field is_admin', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_len = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_len |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $_end = $i + $_len;
                    while ($i < $_end) {
                        $_b = ord(@$bytes[$i++]);
                        $_u = $_b & 0x7F;
                        if ($_b >= 0x80) {
                            $_s = 0;
                            while ($_b >= 0x80) $_u |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                            if ($_s > 63) throw new \Exception('Int overflow');
                        }
                        $_value = $_u === 1;
                        $d->is_admin[] = $_value;
                    }
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
        foreach ($this->users as $_value) {
            $buf .= "\x0a";
            $_msgBuf = $_value->__encode();
            $_v = strlen($_msgBuf);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_msgBuf;
        }
        foreach ($this->emails as $_value) {
            $buf .= "\x12";
            $_v = strlen($_value);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_value;
        }
        if (!empty($this->ages)) {
            $buf .= "\x1a";
            $_packed = '';
            foreach ($this->ages as $_value) {
                $_v = $_value;
                if ($_v < 0) {
                    $_v &= 0x7FFFFFFFFFFFFFFF;
                    for ($_i = 0; $_i < 9; ++$_i) {
                        $_packed .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $_packed .= chr($_v | 0x01);
                } else {
                    while ($_v >= 0x80) {
                        $_packed .= chr(($_v | 0x80) & 0xFF);
                        $_v >>= 7;
                    }
                    $_packed .= chr($_v);
                }
            }
            $_v = strlen($_packed);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_packed;
        }
        if (!empty($this->is_admin)) {
            $buf .= "\x22";
            $_packed = '';
            foreach ($this->is_admin as $_value) {
                $_packed .= chr($_value ? 1 : 0);
            }
            $_v = strlen($_packed);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $_packed;
        }
        return $buf;
    }
}

