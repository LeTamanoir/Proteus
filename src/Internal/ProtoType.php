<?php

declare(strict_types=1);

namespace Proteus\Internal;

enum ProtoType: string
{
    case Int32 = 'int32';
    case Sint32 = 'sint32';
    case Uint32 = 'uint32';
    case Int64 = 'int64';
    case Sint64 = 'sint64';
    case Uint64 = 'uint64';
    case Bool = 'bool';
    case Fixed64 = 'fixed64';
    case Sfixed64 = 'sfixed64';
    case Double = 'double';
    case String = 'string';
    case Bytes = 'bytes';
    case Map = 'map';
    case Fixed32 = 'fixed32';
    case Sfixed32 = 'sfixed32';
    case Float = 'float';
    case Message = 'message';

    /**
     * Checks if a field type can be packed when repeated
     *
     * In proto3, repeated numeric fields are packed by default.
     * String, bytes, and message types cannot be packed.
     */
    public function isPackable(): bool
    {
        return match ($this) {
            self::Int32,
            self::Sint32,
            self::Uint32,
            self::Int64,
            self::Sint64,
            self::Uint64,
            self::Fixed32,
            self::Sfixed32,
            self::Fixed64,
            self::Sfixed64,
            self::Float,
            self::Double,
            self::Bool,
                => true,
            default => false,
        };
    }

    /**
     * Maps protobuf wire types to their numeric identifiers
     *
     * Wire types in protobuf:
     * 0 = VARINT (int32, int64, uint32, uint64, sint32, sint64, bool, enum)
     * 1 = 64-BIT (fixed64, sfixed64, double)
     * 2 = LENGTH_DELIMITED (string, bytes, embedded messages, packed repeated fields)
     * 5 = 32-BIT (fixed32, sfixed32, float)
     */
    public function toWireType(): int
    {
        return match ($this) {
            // Varint encoded (wire type 0)
            self::Int32, self::Sint32, self::Uint32, self::Int64, self::Sint64, self::Uint64, self::Bool => 0,
            // 64-bit (wire type 1)
            self::Fixed64, self::Sfixed64, self::Double => 1,
            // Length-delimited (wire type 2)
            self::String, self::Bytes, self::Map, self::Message => 2,
            // 32-bit (wire type 5)
            self::Fixed32, self::Sfixed32, self::Float => 5,
        };
    }
}
