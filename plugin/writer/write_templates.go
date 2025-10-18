package writer

import (
	"fmt"
)

// InlineWriteVarintGmp generates inline code for writing a varint using GMP
func (w *Writer) InlineWriteVarintGmp(value, dest string) {
	w.Line("$_v = gmp_init(%s);", value)
	w.Line("while (gmp_cmp($_v, 0x80) >= 0) {")
	w.In()
	w.Line("%s .= chr(gmp_intval(gmp_or($_v, 0x80)) & 0xFF);", dest)
	w.Line("$_v = gmp_div($_v, 0x80);")
	w.Out()
	w.Line("}")
	w.Line("%s .= chr(gmp_intval($_v));", dest)
}

// InlineWriteInt64 generates inline code for writing a int64
func (w *Writer) InlineWriteInt64(value, dest string) {
	w.Line("$_v = %s;", value)
	w.Line("if ($_v < 0) {")
	w.In()
	w.Line("$_v &= 0x7FFFFFFFFFFFFFFF;")
	w.Line("for ($_i = 0; $_i < 9; ++$_i) {")
	w.In()
	w.Line("%s .= chr(($_v | 0x80) & 0xFF);", dest)
	w.Line("$_v >>= 7;")
	w.Out()
	w.Line("}")
	w.Line("%s .= chr($_v | 0x01);", dest)
	w.Out()
	w.Line("} else {")
	w.In()
	w.Line("while ($_v >= 0x80) {")
	w.In()
	w.Line("%s .= chr(($_v | 0x80) & 0xFF);", dest)
	w.Line("$_v >>= 7;")
	w.Out()
	w.Line("}")
	w.Line("%s .= chr($_v);", dest)
	w.Out()
	w.Line("}")
}

// InlineWritePositiveInt64 generates inline code for writing a positive int64
func (w *Writer) InlineWritePositiveInt64(value, dest string) {
	w.Line("$_v = %s;", value)
	w.Line("while ($_v >= 0x80) {")
	w.In()
	w.Line("%s .= chr(($_v | 0x80) & 0xFF);", dest)
	w.Line("$_v >>= 7;")
	w.Out()
	w.Line("}")
	w.Line("%s .= chr($_v);", dest)
}

// InlineWriteBool generates inline code for writing a bool
func (w *Writer) InlineWriteBool(value, dest string) {
	w.Line("%s .= chr(%s ? 1 : 0);", dest, value)
}

// InlineWriteInt32 generates inline code for writing int32
func (w *Writer) InlineWriteInt32(value, dest string) {
	w.InlineWriteInt64(value, dest)
}

// InlineWriteSint32 generates inline code for writing sint32 with ZigZag encoding
// TODO FIX THIS
func (w *Writer) InlineWriteSint32(value, dest string) {
	// as we are reading a int32 we ignore the potential overflow
	w.Line("$_u = (%s << 1) ^ (%s >> 31);", value, value)
	w.InlineWritePositiveInt64("$_u", dest)
}

// InlineWriteSint64 generates inline code for writing sint64 with ZigZag encoding
// TODO FIX THIS
func (w *Writer) InlineWriteSint64(value, dest string) {
	w.Line("$_u = (%s << 1) ^ (%s >> 63);", value, value)
	w.Line("if ($_u < 0) {")
	w.In()
	w.Line("$_u = gmp_init($_u);")
	w.Line("$_u = gmp_add($_u, gmp_pow(2, 64));")
	w.InlineWriteVarintGmp("gmp_strval($_u)", dest)
	w.Out()
	w.Line("} else {")
	w.In()
	w.InlineWriteInt64("$_u", dest)
	w.Out()
	w.Line("}")
}

// InlineWriteFixed32 generates inline code for writing fixed32
func (w *Writer) InlineWriteFixed32(value, dest string) {
	w.Line("%s .= pack('L', %s);", dest, value)
}

// InlineWriteSfixed32 generates inline code for writing sfixed32
func (w *Writer) InlineWriteSfixed32(value, dest string) {
	w.Line("%s .= pack('l', %s);", dest, value)
}

// InlineWriteFixed64 generates inline code for writing fixed64
func (w *Writer) InlineWriteFixed64(value, dest string) {
	w.Line("%s .= gmp_export(gmp_init(%s), GMP_BIG_ENDIAN, 8);", dest, value)
}

// InlineWriteSfixed64 generates inline code for writing sfixed64
func (w *Writer) InlineWriteSfixed64(value, dest string) {
	w.Line("%s .= pack('q', %s);", dest, value)
}

// InlineWriteFloat generates inline code for writing float
func (w *Writer) InlineWriteFloat(value, dest string) {
	w.Line("%s .= pack('f', %s);", dest, value)
}

// InlineWriteDouble generates inline code for writing double
func (w *Writer) InlineWriteDouble(value, dest string) {
	w.Line("%s .= pack('d', %s);", dest, value)
}

// InlineWriteBytes generates inline code for writing bytes
func (w *Writer) InlineWriteBytes(value, dest string) {
	w.Line("$_bytes = base64_decode(%s);", value)
	w.InlineWritePositiveInt64("strlen($_bytes)", dest)
	w.Line("%s .= $_bytes;", dest)
}

// InlineWriteString generates inline code for writing a string
func (w *Writer) InlineWriteString(value, dest string) {
	w.InlineWritePositiveInt64(fmt.Sprintf("strlen(%s)", value), dest)
	w.Line("%s .= %s;", dest, value)
}

func (w *Writer) InlineWriteTag(tag int32, dest string) {
	var buf []byte
	if tag < 0 {
		panic("tag can not be negative")
	}
	v := uint64(tag)
	for v >= 0x80 {
		buf = append(buf, byte(v)|0x80)
		v >>= 7
	}
	buf = append(buf, byte(v))

	var result string
	for _, b := range buf {
		result += fmt.Sprintf("\\x%02x", b)
	}
	w.Line("%s .= \"%s\";", dest, result)
}
