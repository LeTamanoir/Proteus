package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/protobuf"
	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genDecodeMethods generates the decode methods for all messages
func (g *generator) genDecodeMethods(w *writer.Writer, message *descriptorpb.DescriptorProto) {
	w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)
	w.Line("public static function decode(string $bytes): self")
	w.Line("{")
	w.In()
	w.Line("return self::__decode($bytes, 0, strlen($bytes));")
	w.Out()
	w.Line("}")
	w.Newline()

	w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)
	w.Line("public static function __decode(string $bytes, int $i, int $l): self")
	w.Line("{")
	w.In()
	w.Line("$d = new self();")
	w.Line("while ($i < $l) {")
	w.In()

	// Google uses uint32 in their CPP implem so it's fair
	// to assume we can ignore the uint64 overflow here
	// see https://stackoverflow.com/questions/57520857/maximum-field-number-in-protobuf-message
	w.InlineReadVarint("$wire")
	w.Line("$fieldNum = $wire >> 3;")
	w.Line("$wireType = $wire & 0x7;")
	w.Line("switch ($fieldNum) {")
	w.In()

	for _, field := range message.GetField() {
		w.Line(fmt.Sprintf("case %d:", field.GetNumber()))
		w.In()

		switch {
		case protobuf.IsMapField(field, message):
			g.genMapFieldCode(w, field, message)

		case protobuf.IsRepeated(field):
			g.genRepeatedFieldCode(w, field)

		default:
			g.genRegularFieldCode(w, field)
		}

		w.Line("break;")
		w.Out()
	}

	w.Line("default:")
	w.In()
	w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $wireType);")
	w.Out()
	w.Out()
	w.Line("}")
	w.Out()
	w.Line("}")
	w.Line("if ($i !== $l) throw new \\Exception('Unexpected EOF');")
	w.Line("return $d;")
	w.Out()
	w.Line("}")
	w.Newline()
}
