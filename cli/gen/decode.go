package gen

import (
	"fmt"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genDecodeMethod generates the decode method for a message
func (g *gen) genDecodeMethod(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto) error {
	g.w.Docblock(fmt.Sprintf(`Decodes a %s message from binary protobuf format
@param  int[] $bytes Binary protobuf data
@return self  The decoded message instance
@throws Exception if the data is malformed or contains invalid wire types`, message.GetName()))

	g.w.Line("public static function decode(array $bytes): self")
	g.w.Line("{")
	g.w.In()

	g.w.Line("$d = new self();")
	g.w.Line("$l = count($bytes);")
	g.w.Line("$i = 0;")

	g.w.Line("while ($i < $l) {")
	g.w.In()

	g.w.InlineReadVarint("wire")
	g.w.Line("$fieldNum = $wire >> 3;")
	g.w.Line("$wireType = $wire & 0x7;")
	g.w.Line("switch ($fieldNum) {")
	g.w.In()

	for _, field := range message.GetField() {
		g.w.Line(fmt.Sprintf("case %d:", field.GetNumber()))
		g.w.In()

		var err error
		switch {
		case isMapField(field, file):
			err = g.genMapFieldCode(field, file)
		case isRepeated(field):
			err = g.genRepeatedFieldCode(field)
		default:
			err = g.genRegularFieldCode(field)
		}
		if err != nil {
			return err
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
