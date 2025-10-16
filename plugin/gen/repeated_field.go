package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *generator) genRepeatedFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()

	expectedWireType := getWireType(field.GetType())

	switch {
	case isPackable(field.GetType()):
		w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		w.InlineReadVarint("$_len")
		w.Line("$_end = $i + $_len;")
		w.Line("while ($i < $_end) {")
		w.In()
		g.inlineReadCode(w, field, "$_value")
		w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		w.Out()
		w.Line("}")
		w.Line(fmt.Sprintf("if ($i !== $_end) throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))

	case isMessage(field):
		w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		w.InlineReadVarint("$_len")
		w.Line("$_msgLen = $i + $_len;")
		w.Line("if ($_msgLen < 0 || $_msgLen > $l) throw new \\Exception('Invalid length');")
		phpType := g.getPhpType(field)
		w.Line(fmt.Sprintf("$d->%s[] = %s::__decode($bytes, $i, $_msgLen);", fieldName, phpType))
		w.Line("$i = $_msgLen;")

	case field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING || field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
		g.inlineReadCode(w, field, "$_value")
		w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
	}
}
