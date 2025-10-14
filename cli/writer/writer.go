package writer

import (
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
