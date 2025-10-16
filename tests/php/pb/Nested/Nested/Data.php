<?php

/**
 * Auto-generated file, DO NOT EDIT!
 * Proto file: tests/protos/nested.proto
 */

declare(strict_types=1);

namespace Tests\php\pb\Nested\Nested;

class Data implements \Proteus\Msg
{
    public string $value = '';

    public \Tests\php\pb\Nested\Nested\Data\NestedData|null $nested_data = null;

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
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field value', $wireType));
                    $_byteLen = 0;
                    for ($_shift = 0;; $_shift += 7) {
                        if ($_shift >= 64) throw new \Exception('Int overflow');
                        if ($i >= $l) throw new \Exception('Unexpected EOF');
                        $_b = ord($bytes[$i++]);
                        $_byteLen |= ($_b & 0x7F) << $_shift;
                        if ($_b < 0x80) break;
                    }
                    if ($_byteLen < 0 || $i + $_byteLen > $l) throw new \Exception('Invalid length');
                    $_value = substr($bytes, $i, $_byteLen);
                    $i += $_byteLen;
                    $d->value = $_value;
                    break;
                case 2:
                    if ($wireType !== 2) throw new \Exception(sprintf('Invalid wire type %d for field nested_data', $wireType));
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
                    $_value = \Tests\php\pb\Nested\Nested\Data\NestedData::__decode($bytes, $i, $_msgLen);
                    $i = $_msgLen;
                    $d->nested_data = $_value;
                    break;
                default:
                    $i = \Proteus\skipField($i, $l, $bytes, $wireType);
            }
        }
        return $d;
    }

}

