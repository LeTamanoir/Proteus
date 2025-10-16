<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/common.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Common;

class Coordinates implements \Proteus\Msg
{
    public float $latitude = 0.0;

    public float $longitude = 0.0;

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
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field latitude', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('d', substr($bytes, $i, 8))[1];
                    $i += 8;
                    $d->latitude = $_value;
                    break;
                case 2:
                    if ($wireType !== 1) throw new \Exception(sprintf('Invalid wire type %d for field longitude', $wireType));
                    if ($i + 8 > $l) throw new \Exception('Unexpected EOF');
                    $_value = unpack('d', substr($bytes, $i, 8))[1];
                    $i += 8;
                    $d->longitude = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

