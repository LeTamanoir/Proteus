<?php

declare(strict_types=1);

namespace Proteus;

if (!function_exists('skipField')) {
    /**
     * Skips an unknown field in the protobuf binary data
     *
     * This is the only field reading operation that remains as a function,
     * since unknown fields are by definition not performance-critical.
     *
     * @param int $i Current position in the byte string (passed by reference, will be updated)
     * @param int $l Total length of the byte string
     * @param string $bytes The binary data
     * @param int $wireType The wire type of the field to skip (0, 1, 2, or 5)
     * @throws \Exception if wire type is unsupported or data is malformed
     */
    function skipField(int &$i, int $l, string $bytes, int $wireType): void
    {
        switch ($wireType) {
            case 0: // varint - inline the varint skip
                for ($shift = 0;; $shift += 7) {
                    if ($shift >= 64) {
                        throw new \Exception('Int overflow');
                    }
                    if ($i >= $l) {
                        throw new \Exception('Unexpected EOF');
                    }
                    $b = ord($bytes[$i]);
                    ++$i;
                    if ($b < 0x80) {
                        break;
                    }
                }
                return;

            case 1: // 64-bit
                if (($i + 8) > $l) {
                    throw new \Exception('Unexpected EOF');
                }
                $i += 8;
                return;

            case 2: // length-delimited - inline the length read
                $len = 0;
                for ($shift = 0;; $shift += 7) {
                    if ($shift >= 64) {
                        throw new \Exception('Int overflow');
                    }
                    if ($i >= $l) {
                        throw new \Exception('Unexpected EOF');
                    }
                    $b = ord($bytes[$i]);
                    ++$i;
                    $len |= ($b & 0x7F) << $shift;
                    if ($b < 0x80) {
                        break;
                    }
                }
                if ($len < 0) {
                    throw new \Exception('Invalid length');
                }
                $postIndex = $i + $len;
                if ($postIndex < 0 || $postIndex > $l) {
                    throw new \Exception('Invalid length');
                }
                $i = $postIndex;
                return;

            case 5: // 32-bit
                if (($i + 4) > $l) {
                    throw new \Exception('Unexpected EOF');
                }
                $i += 4;
                return;

            default:
                throw new \Exception("Unsupported wire type: {$wireType}");
        }
    }
}

if (!function_exists('isBigEndian')) {
    /**
     * Detects if the system uses big-endian byte order
     *
     * Result is cached to avoid repeated checks.
     * Used by inline float/double reading code.
     *
     * @return bool True if system is big-endian, false if little-endian
     */
    function isBigEndian(): bool
    {
        static $endianness;

        if (null === $endianness) {
            [, $result] = unpack('L', pack('V', 1));
            $endianness = $result !== 1;
        }

        return $endianness;
    }
}
