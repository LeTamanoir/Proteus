<?php

declare(strict_types=1);

namespace Proteus;

use Exception;

// @mago-ignore analysis:redundant-comparison,impossible-condition
if (PHP_INT_SIZE !== 8) {
    trigger_error('This message is only supported on 64-bit systems', E_USER_WARNING);
}

if (!extension_loaded('gmp')) {
    trigger_error('The gmp extension must be loaded in order to decode this message', E_USER_WARNING);
}

/**
 * Skips an unknown field in the protobuf binary data
 *
 * @param int $i Current position in the byte string
 * @param int $l Total length of the byte string
 * @param string $bytes The binary data
 * @param int $wireType The wire type of the field to skip (0, 1, 2, or 5)
 * @throws Exception if wire type is unsupported or data is malformed
 * @return int The new position in the byte string
 */
function skipField(int $i, int $l, string $bytes, int $wireType): int
{
    switch ($wireType) {
        case 0: // varint - inline the varint skip
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) {
                    throw new Exception('Int overflow');
                }
                if ($i >= $l) {
                    throw new Exception('Unexpected EOF');
                }
                $b = ord($bytes[$i++]);
                if ($b < 0x80) {
                    break;
                }
            }
            return $i;

        case 1: // 64-bit
            if (($i + 8) > $l) {
                throw new Exception('Unexpected EOF');
            }
            $i += 8;
            return $i;

        case 2: // length-delimited - inline the length read
            $len = 0;
            for ($shift = 0;; $shift += 7) {
                if ($shift >= 64) {
                    throw new Exception('Int overflow');
                }
                if ($i >= $l) {
                    throw new Exception('Unexpected EOF');
                }
                $b = ord($bytes[$i++]);
                $len |= ($b & 0x7F) << $shift;
                if ($b < 0x80) {
                    break;
                }
            }
            if ($len < 0) {
                throw new Exception('Invalid length');
            }
            $postIndex = $i + $len;
            if ($postIndex < 0 || $postIndex > $l) {
                throw new Exception('Invalid length');
            }
            $i = $postIndex;
            return $i;

        case 5: // 32-bit
            if (($i + 4) > $l) {
                throw new Exception('Unexpected EOF');
            }
            $i += 4;
            return $i;

        default:
            throw new Exception("Illegal wire type: {$wireType}");
    }
}
