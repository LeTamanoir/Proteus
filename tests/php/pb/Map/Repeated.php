<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/map.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Map;

class Repeated implements \Proteus\Msg
{
    /** @var \Tests\php\pb\Common\Address[] */
    public array $addresses = [];

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
            $wire = 0;
            for ($_shift = 0;; $_shift += 7) {
                if ($_shift >= 64) throw new \Exception('Int overflow');
                if ($i >= $l) throw new \Exception('Unexpected EOF');
                $_b = ord($bytes[$i++]);
                $wire |= ($_b & 0x7F) << $_shift;
                if ($_b < 0x80) break;
            }
            $fieldNum = $wire >> 3;
            $wireType = $wire & 0x7;
            switch ($fieldNum) {
                case 1:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field addresses', $wireType));
                    $_len = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_len |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    $_msgLen = $i + $_len;
                    if ($_msgLen < 0 || $_msgLen > $l) throw new \Exception('Invalid length');
                    $d->addresses[] = \Tests\php\pb\Common\Address::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

