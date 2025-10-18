<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Common;

final class Timestamp extends \Proteus\Msg
{
    public int $seconds = 0;

    public int $nanos = 0;

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
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field seconds', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $d->seconds = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $d->seconds |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
                    }
                    break;
                case 2:
                    if ($wireType !== 0) throw new \Exception(sprintf('Invalid wire type %d for field nanos', $wireType));
                    $_b = ord(@$bytes[$i++]);
                    $d->nanos = $_b & 0x7F;
                    if ($_b >= 0x80) {
                        $_s = 0;
                        while ($_b >= 0x80) $d->nanos |= (($_b = ord(@$bytes[$i++])) & 0x7F) << ($_s += 7);
                        if ($_s > 63) throw new \Exception('Int overflow');
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
        if ($this->seconds !== 0) {
            $buf .= "\x08";
            $_v = $this->seconds;
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
        if ($this->nanos !== 0) {
            $buf .= "\x10";
            $_v = $this->nanos;
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
        return $buf;
    }
}

