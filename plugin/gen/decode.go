package gen

import (
	"fmt"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genDecodeMethod generates the decode method for a message
func (g *gen) genDecodeMethod(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto) error {
	g.w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)

	g.w.Line("public static function decode(string $bytes): self")
	g.w.Line("{")
	g.w.In()
	g.w.Line("return self::__decode($bytes, 0, strlen($bytes));")
	g.w.Out()
	g.w.Line("}")
	g.w.Newline()

	g.w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)

	g.w.Line("public static function __decode(string $bytes, int $i, int $l): self")
	g.w.Line("{")
	g.w.In()
	g.w.Line("$d = new self();")
	g.w.Line("while ($i < $l) {")
	g.w.In()

	// Google uses uint32 in their CPP implem so it's fair
	// to assume we can ignore the uint64 overflow here
	// see https://stackoverflow.com/questions/57520857/maximum-field-number-in-protobuf-message
	g.w.InlineReadVarint("$wire")
	g.w.Line("$fieldNum = $wire >> 3;")
	g.w.Line("$wireType = $wire & 0x7;")
	g.w.Line("switch ($fieldNum) {")
	g.w.In()

	for _, field := range message.GetField() {
		g.w.Line(fmt.Sprintf("case %d:", field.GetNumber()))
		g.w.In()

		switch {
		case isMapField(field, file):
			if err := g.genMapFieldCode(field, file); err != nil {
				return err
			}
		case isRepeated(field):
			g.genRepeatedFieldCode(field)
		default:
			g.genRegularFieldCode(field)
		}

		g.w.Line("break;")
		g.w.Out()
	}

	g.w.Line("default:")
	g.w.In()
	g.w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $wireType);")
	g.w.Out()
	g.w.Out()
	g.w.Line("}")
	g.w.Out()
	g.w.Line("}")
	g.w.Line("return $d;")
	g.w.Out()
	g.w.Line("}")

	return nil
}
