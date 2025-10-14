package writer

import (
	"fmt"
	"strings"
)

// Writer helps generate PHP code with proper indentation
type Writer struct {
	output      strings.Builder
	indentLevel int
	indent      string
}

// NewWriter creates a new code writer
func NewWriter() *Writer {
	return &Writer{
		indentLevel: 0,
		indent:      "    ",
	}
}

// WithIndent allows customizing the indent string
func (w *Writer) WithIndent(indent string) {
	w.indent = indent
}

// In increases indentation level
func (w *Writer) In() {
	w.indentLevel++
}

// Out decreases indentation level
func (w *Writer) Out() {
	w.indentLevel--
	if w.indentLevel < 0 {
		panic("indent level cannot be negative")
	}
}

// Line writes a single line with current indentation
func (w *Writer) Line(line string) {
	w.output.WriteString(strings.Repeat(w.indent, w.indentLevel))
	w.output.WriteString(line)
	w.output.WriteString("\n")
}

// Lines writes multiple lines with current indentation
func (w *Writer) Lines(lines string) {
	for line := range strings.SplitSeq(lines, "\n") {
		w.output.WriteString(strings.Repeat(w.indent, w.indentLevel))
		w.output.WriteString(line)
		w.output.WriteString("\n")
	}
}

// Comment writes a single-line comment
func (w *Writer) Comment(comment string) {
	w.output.WriteString(strings.Repeat(w.indent, w.indentLevel))
	w.output.WriteString("/** ")
	w.output.WriteString(comment)
	w.output.WriteString(" */\n")
}

// Docblock writes a multi-line docblock comment
func (w *Writer) Docblock(comment string) {
	indent := strings.Repeat(w.indent, w.indentLevel)
	w.output.WriteString(indent)
	w.output.WriteString("/**\n")
	for line := range strings.SplitSeq(comment, "\n") {
		w.output.WriteString(indent)
		w.output.WriteString(" * ")
		w.output.WriteString(line)
		w.output.WriteString("\n")
	}
	w.output.WriteString(indent)
	w.output.WriteString(" */\n")
}

// Newline writes a blank line
func (w *Writer) Newline() {
	w.output.WriteString("\n")
}

// GetOutput returns the generated code
func (w *Writer) GetOutput() string {
	return w.output.String()
}

// InlineReadVarint generates inline code for reading a varint
func (w *Writer) InlineReadVarint(varName string) {
	w.Line(fmt.Sprintf("$%s = 0;", varName))
	w.Line("for ($_shift = 0;; $_shift += 7) {")
	w.In()
	w.Line("if ($_shift >= 64) throw new \\Exception('Int overflow');")
	w.Line("if ($i >= $l) throw new \\Exception('Unexpected EOF');")
	w.Line("$_b = $bytes[$i++];")
	w.Line(fmt.Sprintf("$%s |= ($_b & 0x7F) << $_shift;", varName))
	w.Line("if ($_b < 0x80) break;")
	w.Out()
	w.Line("}")
}

// InlineReadInt32 generates inline code for reading int32 with sign extension
func (w *Writer) InlineReadInt32(varName string) {
	w.InlineReadVarint("_u")
	w.Line(fmt.Sprintf("$%s = $_u;", varName))
	w.Line(fmt.Sprintf("if ($%s > 0x7FFFFFFF) $%s -= 0x100000000;", varName, varName))
}

// InlineReadSint32 generates inline code for reading sint32 with ZigZag decoding
func (w *Writer) InlineReadSint32(varName string) {
	w.InlineReadVarint("_u")
	w.Line(fmt.Sprintf("$%s = ($_u >> 1) ^ -($_u & 1);", varName))
	w.Line(fmt.Sprintf("if ($%s > 0x7FFFFFFF) $%s -= 0x100000000;", varName, varName))
}

// InlineReadSint64 generates inline code for reading sint64 with ZigZag decoding
func (w *Writer) InlineReadSint64(varName string) {
	w.InlineReadVarint("_u")
	w.Line(fmt.Sprintf("$%s = ($_u >> 1) ^ -($_u & 1);", varName))
}

// InlineReadFixed32 generates inline code for reading fixed32
func (w *Writer) InlineReadFixed32(varName string) {
	w.Line("if ($i + 4 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('V', pack('C*', ...array_slice($bytes, $i, 4)))[1];", varName))
	w.Line("$i += 4;")
}

// InlineReadFixed64 generates inline code for reading fixed64
func (w *Writer) InlineReadFixed64(varName string) {
	w.Line("if ($i + 8 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line(fmt.Sprintf("$%s = unpack('P', pack('C*', ...array_slice($bytes, $i, 8)))[1];", varName))
	w.Line("$i += 8;")
}

// InlineReadFloat generates inline code for reading float
func (w *Writer) InlineReadFloat(varName string) {
	w.Line("if ($i + 4 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line("$_b = array_slice($bytes, $i, 4);")
	w.Line("$i += 4;")
	w.Line("if (\\Proteus\\isBigEndian()) $_b = array_reverse($_b);")
	w.Line(fmt.Sprintf("$%s = unpack('f', pack('C*', ...$_b))[1];", varName))
}

// InlineReadDouble generates inline code for reading double
func (w *Writer) InlineReadDouble(varName string) {
	w.Line("if ($i + 8 > $l) throw new \\Exception('Unexpected EOF');")
	w.Line("$_b = array_slice($bytes, $i, 8);")
	w.Line("$i += 8;")
	w.Line("if (\\Proteus\\isBigEndian()) $_b = array_reverse($_b);")
	w.Line(fmt.Sprintf("$%s = unpack('d', pack('C*', ...$_b))[1];", varName))
}

// InlineReadBytes generates inline code for reading bytes
func (w *Writer) InlineReadBytes(varName string) {
	w.InlineReadVarint("_byteLen")
	w.Line("if ($_byteLen < 0) throw new \\Exception('Invalid length');")
	w.Line("$_postIndex = $i + $_byteLen;")
	w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
	w.Line(fmt.Sprintf("$%s = implode('', array_map('chr', array_slice($bytes, $i, $_byteLen)));", varName))
}
