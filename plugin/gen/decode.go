package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/php"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genDecodeMethods generates the decode methods for all messages
func (g *gen) genDecodeMethods() error {
	for _, decodeFunction := range g.decodeFunctions {
		message := decodeFunction.message
		file := decodeFunction.file

		g.w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)

		className := php.GetClassName(message.GetName())
		g.w.Line(fmt.Sprintf("function decode%s(string $bytes, int $i, int $l): %s", className, className))
		g.w.Line("{")
		g.w.In()
		g.w.Line(fmt.Sprintf("$d = new %s();", className))
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
		g.w.Newline()
	}

	return nil
}

// addDecodeMethod adds the decode method for a message to the decode functions
func (g *gen) addDecodeMethod(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto) error {
	g.w.Docblock(`@throws \Exception if the data is malformed or contains invalid wire types`)

	g.w.Line("public static function decode(string $bytes): self")
	g.w.Line("{")
	g.w.In()
	g.w.Line(fmt.Sprintf("return decode%s($bytes, 0, strlen($bytes));", php.GetClassName(message.GetName())))
	g.w.Out()
	g.w.Line("}")

	g.decodeFunctions = append(g.decodeFunctions, struct {
		message *descriptorpb.DescriptorProto
		file    *descriptorpb.FileDescriptorProto
	}{message, file})

	return nil
}
