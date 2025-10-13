# Proteus Code Generation Improvements

## Summary

This document tracks the improvements made to the Proteus protobuf code generator based on the comparison with gogoproto and protobuf best practices.

## Completed Improvements (Phase 1 & 2)

### Safety Improvements ✅

#### 1. ZigZag Encoding for sint32/sint64
**Status**: ✅ Complete

Added proper ZigZag decoding for signed integer types:
- `readSint32()` - Decodes sint32 with ZigZag + 32-bit sign extension
- `readSint64()` - Decodes sint64 with ZigZag
- Updated both regular and packed repeated field handling

**Impact**: Negative numbers now decode correctly for `sint32` and `sint64` fields.

**Code**: `src/Codegen.php:239-265`

#### 2. Overflow Protection in skipField
**Status**: ✅ Complete

Enhanced `skipField()` with comprehensive bounds checking:
- Validates postIndex doesn't overflow before incrementing
- Checks for negative length values
- Verifies buffer boundaries for all wire types

**Impact**: Prevents malicious data from causing buffer over-reads.

**Code**: `src/Codegen.php:154-190`

#### 3. Bounds Checking Before Unpack Operations
**Status**: ✅ Complete

Updated all read functions to check bounds BEFORE reading:
- `readFloat32()` - Checks $i + 4 <= $l
- `readFixed32()` - Checks $i + 4 <= $l
- `readFixed64()` - Checks $i + 8 <= $l
- `readFloat64()` - Checks $i + 8 <= $l

**Impact**: Prevents reading beyond buffer boundaries.

**Code**: `src/Codegen.php:295-365`

#### 4. int32 Sign Extension
**Status**: ✅ Complete

Added `readInt32()` function with proper sign extension:
- Handles values > 0x7FFFFFFF correctly
- Works for both regular and packed repeated fields

**Impact**: Large positive int32 values are now correctly treated as negative when appropriate.

**Code**: `src/Codegen.php:276-284, 115, 568-573`

### Major Features ✅

#### 5. Nested Message Support
**Status**: ✅ Complete

Implemented full support for nested messages:
- Detects message-type fields vs primitive types
- Generates recursive `fromBytes()` calls for message fields
- Handles both singular and repeated message fields
- Message fields are nullable (proto3 semantics)

**Features**:
- Regular message fields: `$d->address = Address::fromBytes(substr($bytes, $i, $len))`
- Repeated message fields: `$d->employees[] = Person::fromBytes(substr($bytes, $i, $len))`
- Proper type annotations: `public Address|null $address = null`
- Length validation with overflow protection

**Impact**: Can now deserialize complex protobuf messages with nested structures.

**Code**: `src/Codegen.php:46-58, 517-547, 562-582, 867-875`

**Test**: Created `test-server/proto/nested.proto` with Address, Person, and Company messages.

## Performance Impact

**Before improvements**:
- Average generation time: 7.02 ms
- Utils file size: 5.25 KB
- Memory usage: 0.49 MB

**After improvements**:
- Average generation time: 7.43 ms (+5.8%)
- Utils file size: 7.48 KB (+42.5% due to new functions)
- Memory usage: 0.49 MB (unchanged)

**Analysis**: Small performance hit is acceptable given the significant safety and functionality improvements.

## Remaining Work

### Phase 2 (Continued)

#### Oneof Field Support
**Priority**: HIGH
**Status**: ⏳ Pending

Need to implement:
- Parse oneof groups from proto definitions
- Generate discriminator property to track which field is set
- Ensure only one field in a oneof is set at a time

#### Better Error Messages
**Priority**: MEDIUM
**Status**: ⏳ Pending

Improve error context:
- Include field names and numbers in exceptions
- Add wire format debugging information
- More descriptive validation errors

### Phase 3 (Optional)

#### Proto2 Group Support
**Priority**: LOW
- Support deprecated group wire types (3, 4)

#### Extension Field Storage
**Priority**: LOW
- Store unknown fields for later processing

#### Required Field Validation (proto2)
**Priority**: LOW
- Bitmask tracking for required fields

## Testing

### Test Files Created

1. `test-server/proto/nested.proto` - Nested message test cases
2. `benchmarks/CodegenBenchmark.php` - Performance benchmarking
3. `docs/COMPARISON_GOGOPROTO.md` - Feature comparison matrix

### Verification

All improvements verified through:
- ✅ Benchmark suite passes
- ✅ Generated code compiles correctly
- ✅ Nested message deserialization works
- ✅ Safety checks trigger on invalid data

## References

- [gogoproto unmarshal.go](https://github.com/cosmos/gogoproto/blob/main/plugin/unmarshal/unmarshal.go)
- [Protocol Buffers Encoding](https://protobuf.dev/programming-guides/encoding/)
- [ZigZag Encoding](https://protobuf.dev/programming-guides/encoding/#signed-ints)
