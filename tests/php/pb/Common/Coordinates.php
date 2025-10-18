<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Common;

final class Coordinates extends \Proteus\Msg
{
    public float $latitude = 0.0;

    public float $longitude = 0.0;

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
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field latitude', $wireType));
                    $d->latitude = unpack('d', substr($bytes, $i, 8))[1];
                    $i += 8;
                    break;
                case 2:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field longitude', $wireType));
                    $d->longitude = unpack('d', substr($bytes, $i, 8))[1];
                    $i += 8;
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
        if ($this->latitude !== 0.0) {
            $buf .= "\x09";
            $buf .= pack('d', $this->latitude);
        }
        if ($this->longitude !== 0.0) {
            $buf .= "\x11";
            $buf .= pack('d', $this->longitude);
        }
        return $buf;
    }
}

