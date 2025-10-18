<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Common;

final class Address extends \Proteus\Msg
{
    public string $street = '';

    public string $city = '';

    public string $state = '';

    public string $zip_code = '';

    public string $country = '';

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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field street', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->street = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field city', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->city = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    break;
                case 3:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field state', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->state = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    break;
                case 4:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field zip_code', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->zip_code = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    break;
                case 5:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field country', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $_byteLen = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $_byteLen |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    $d->country = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
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
        if ($this->street !== '') {
            $buf .= "\x0a";
            $_v = strlen($this->street);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->street;
        }
        if ($this->city !== '') {
            $buf .= "\x12";
            $_v = strlen($this->city);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->city;
        }
        if ($this->state !== '') {
            $buf .= "\x1a";
            $_v = strlen($this->state);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->state;
        }
        if ($this->zip_code !== '') {
            $buf .= "\x22";
            $_v = strlen($this->zip_code);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->zip_code;
        }
        if ($this->country !== '') {
            $buf .= "\x2a";
            $_v = strlen($this->country);
            while ($_v >= 0x80) {
                $buf .= chr(($_v | 0x80) & 0xFF);
                $_v >>= 7;
            }
            $buf .= chr($_v);
            $buf .= $this->country;
        }
        return $buf;
    }
}

