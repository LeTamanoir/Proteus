package writer

import "fmt"

// InlineReadVarint generates inline code for reading a varint
func (w *Writer) InlineReadVarint(varName string) {
	w.Line(fmt.Sprintf("$%s = 0;", varName))
	w.Line("for ($_shift = 0;; $_shift += 7) {")
	w.In()
	w.Line("if ($_shift >= 64) throw new \\Exception('Int overflow');")
	w.Line("if ($i >= $l) throw new \\Exception('Unexpected EOF');")
	w.Line("$_b = ord($bytes[$i++]);")
	w.Line(fmt.Sprintf("$%s |= ($_b & 0x7F) << $_shift;", varName))
	w.Line("if ($_b < 0x80) break;")
	w.Out()
	w.Line("}")
}

// InlineReadVarintGmp generates inline code for reading a varint using GMP to prevent overflow
func (w *Writer) InlineReadVarintGmp(varName string) {
	w.Line(fmt.Sprintf("$%s = gmp_init(0);", varName))
	w.Line("for ($_shift = 0;; $_shift += 7) {")
	w.In()
	w.Line("if ($_shift >= 64) throw new \\Exception('Int overflow');")
	w.Line("if ($i >= $l) throw new \\Exception('Unexpected EOF');")
	w.Line("$_b = gmp_init(ord($bytes[$i++]));")
	w.Line(fmt.Sprintf("$%s = gmp_or($%s, gmp_mul(gmp_and($_b, 0x7F), gmp_pow(2, $_shift)));", varName, varName))
	w.Line("if ($_b < 0x80) break;")
	w.Out()
	w.Line("}")
}

// InlineReadInt32 generates inline code for reading int32 with sign extension
func (w *Writer) InlineReadInt32(varName string) {
	// as we are reading a int32 we ignore the potential overflow
	w.InlineReadVarint("_u")
	w.Line(fmt.Sprintf("$%s = $_u;", varName))
	w.Line(fmt.Sprintf("if ($%s > 0x7FFFFFFF) $%s -= 0x100000000;", varName, varName))
}

// InlineReadSint32 generates inline code for reading sint32 with ZigZag decoding
func (w *Writer) InlineReadSint32(varName string) {
	// as we are reading a int32 we ignore the potential overflow
	w.InlineReadVarint("_u")
	w.Line(fmt.Sprintf("$%s = ($_u >> 1) ^ -($_u & 1);", varName))
	w.Line(fmt.Sprintf("if ($%s > 0x7FFFFFFF) $%s -= 0x100000000;", varName, varName))
}

// InlineReadSint64 generates inline code for reading sint64 with ZigZag decoding
func (w *Writer) InlineReadSint64(varName string) {
	// zigzag encoding will use a full uint64 so we need to make sur we don't overflow
	w.InlineReadVarintGmp("_u")
	// we can safely use the intval after the zigzag decoding
	w.Line(fmt.Sprintf("$%s = gmp_intval(gmp_xor(gmp_div($_u, 2), gmp_neg(gmp_and($_u, 1))));", varName))
}

func (w *Writer) InlineReadUint64(varName string) {
	w.InlineReadVarintGmp(varName)
	w.Line(fmt.Sprintf("$%s = gmp_strval($%s);", varName, varName))
}

// InlineReadFixed32 generates inline code for reading fixed32
func (w *Writer) InlineReadFixed32(varName string) {
	w.Line("if ($i + 4 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('V', substr($bytes, $i, 4))[1];", varName))
	w.Line("$i += 4;")
}

// InlineReadFixed64 generates inline code for reading fixed64
func (w *Writer) InlineReadFixed64(varName string) {
	w.Line("if ($i + 8 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = gmp_strval(gmp_import(substr($bytes, $i, 8), GMP_BIG_ENDIAN));", varName))
	w.Line("$i += 8;")
}

// InlineReadSfixed64 generates inline code for reading sfixed64
func (w *Writer) InlineReadSfixed64(varName string) {
	w.Line("if ($i + 8 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('q', substr($bytes, $i, 8))[1];", varName))
	w.Line("$i += 8;")
}

// InlineReadFloat generates inline code for reading float
func (w *Writer) InlineReadFloat(varName string) {
	w.Line("if ($i + 4 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('f', substr($bytes, $i, 4))[1];", varName))
	w.Line("$i += 4;")
}

// InlineReadDouble generates inline code for reading double
func (w *Writer) InlineReadDouble(varName string) {
	w.Line("if ($i + 8 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('d', substr($bytes, $i, 8))[1];", varName))
	w.Line("$i += 8;")
}

// InlineReadBytes generates inline code for reading bytes
func (w *Writer) InlineReadBytes(varName string) {
	w.InlineReadString(varName)
	w.Line(fmt.Sprintf("$%s = base64_encode($%s);", varName, varName))
}

// InlineReadString generates inline code for reading a string
func (w *Writer) InlineReadString(varName string) {
	w.InlineReadVarint("_byteLen")
	w.Line("if ($_byteLen < 0) throw new \\Exception('Invalid length');")
	w.Line("$_postIndex = $i + $_byteLen;")
	w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
	w.Line(fmt.Sprintf("$%s = substr($bytes, $i, $_byteLen);", varName))
	w.Line("$i = $_postIndex;")
}
