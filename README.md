# 🐙 Proteus

## Known Issues

### Float32 Precision Loss

PHP does not natively support 32-bit floats (float32) - all PHP floats are 64-bit (double precision).

When decoding protobuf `float` fields, the 32-bit binary value is unpacked into a 64-bit PHP float. This causes precision artifacts because the conversion adds extra digits that weren't in the original float32 representation.

**Example:**
- Original float32 value: `0.73484236`
- After decoding in PHP: `0.7348423600196838`

This doesn't affect the actual numeric value significantly, but JSON serialization will show these extra digits. If you need exact float32 representation in JSON, you may need to manually round the values.
