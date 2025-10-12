<?php

declare(strict_types=1);

const DEFAULT_UINT64 = new \BcMath\Number('0');

/**
 * Skips an unknown field in the protobuf binary data
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
        case 0: // varint
            readVarint($i, $l, $bytes);
            return;

        case 1: // 64-bit
            $i += 8;
            return;

        case 2: // length-delimited
            $len = readVarint($i, $l, $bytes);
            $i += $len;
            return;

        case 5: // 32-bit
            $i += 4;
            return;

        default:
            throw new \Exception("Unsupported wire type: {$wireType}");
    }
}

/**
 * Reads a varint (variable-length integer) from the binary data
 *
 * Varints are used in protobuf to efficiently encode integers. Each byte uses
 * 7 bits for data and 1 bit (MSB) as a continuation flag.
 *
 * @param int $i Current position in the byte string (passed by reference, will be updated)
 * @param int $l Total length of the byte string
 * @param string $bytes The binary data
 * @return int The decoded integer value
 * @throws \Exception if varint is too large (>64 bits) or EOF is reached
 */
function readVarint(int &$i, int $l, string $bytes): int
{
    $wire = 0;

    for ($shift = 0;; $shift += 7) {
        if ($shift >= 64) {
            throw new \Exception('Int overflow');
        }
        if ($i >= $l) {
            throw new \Exception('Unexpected EOF');
        }

        $b = ord($bytes[$i]);
        ++$i;
        $wire |= ($b & 0x7F) << $shift;
        if ($b < 0x80) {
            break;
        }
    }

    return $wire;
}

/**
 * Reads a 32-bit floating point number (little-endian)
 *
 * @param int $i Current position (passed by reference, will be updated)
 * @param int $l Total length
 * @param string $bytes The binary data
 * @return float The decoded float value
 * @throws \Exception if EOF is reached
 */
function readFloat32(int &$i, int $l, string $bytes): float
{
    $b = substr($bytes, $i, 4);
    $i += 4;
    if ($i > $l) {
        throw new \Exception('Unexpected EOF');
    }
    if (isBigEndian()) {
        $b = strrev($b);
    }
    return unpack('f', $b)[1];
}

/**
 * Reads a 32-bit fixed integer (little-endian unsigned)
 *
 * @param int $i Current position (passed by reference, will be updated)
 * @param int $l Total length
 * @param string $bytes The binary data
 * @return int The decoded integer value
 * @throws \Exception if EOF is reached
 */
function readFixed32(int &$i, int $l, string $bytes): int
{
    $b = substr($bytes, $i, 4);
    $i += 4;
    if ($i > $l) {
        throw new \Exception('Unexpected EOF');
    }
    return unpack('V', $b)[1];
}

/**
 * Reads a 64-bit fixed integer (little-endian unsigned)
 *
 * @param int $i Current position (passed by reference, will be updated)
 * @param int $l Total length
 * @param string $bytes The binary data
 * @return int The decoded integer value
 * @throws \Exception if EOF is reached
 */
function readFixed64(int &$i, int $l, string $bytes): int
{
    $b = substr($bytes, $i, 8);
    $i += 8;
    if ($i > $l) {
        throw new \Exception('Unexpected EOF');
    }
    return unpack('P', $b)[1];
}

/**
 * Reads a 64-bit floating point number (little-endian)
 *
 * @param int $i Current position (passed by reference, will be updated)
 * @param int $l Total length
 * @param string $bytes The binary data
 * @return float The decoded double value
 * @throws \Exception if EOF is reached
 */
function readFloat64(int &$i, int $l, string $bytes): float
{
    $b = substr($bytes, $i, 8);
    $i += 8;
    if ($i > $l) {
        throw new \Exception('Unexpected EOF');
    }
    if (isBigEndian()) {
        $b = strrev($b);
    }
    return unpack('d', $b)[1];
}

/**
 * Detects if the system uses big-endian byte order
 *
 * Result is cached to avoid repeated checks.
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

/**
 * Reads a length-delimited byte sequence (string or bytes field)
 *
 * First reads a varint indicating the length, then extracts that many bytes.
 *
 * @param int $i Current position (passed by reference, will be updated)
 * @param int $l Total length
 * @param string $bytes The binary data
 * @return string The extracted byte sequence
 * @throws \Exception if length is invalid or EOF is reached
 */
function readBytes(int &$i, int $l, string $bytes): string
{
    $byteLen = readVarint($i, $l, $bytes);
    if ($byteLen < 0) {
        throw new \Exception('Invalid length');
    }
    $postIndex = $i + $byteLen;
    if ($postIndex < 0) {
        throw new \Exception('Invalid length');
    }
    if ($postIndex > $l) {
        throw new \Exception('Unexpected EOF');
    }
    $dest = substr($bytes, $i, $byteLen);
    $i = $postIndex;
    return $dest;
}
