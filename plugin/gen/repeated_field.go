package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *gen) genRepeatedFieldCode(field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()

	expectedWireType := getWireType(field.GetType())

	if isPackable(field.GetType()) {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		g.w.InlineReadVarint("$_len")
		g.w.Line("$_end = $i + $_len;")
		g.w.Line("while ($i < $_end) {")
		g.w.In()
		g.inlineReadCode(field, "$_value")
		g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		g.w.Out()
		g.w.Line("}")
		g.w.Line(fmt.Sprintf("if ($i !== $_end) throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))
	} else if isMessage(field) {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		g.w.InlineReadVarint("$_len")
		g.w.Line("$_msgLen = $i + $_len;")
		g.w.Line("if ($_msgLen < 0 || $_msgLen > $l) throw new \\Exception('Invalid length');")
		phpType := php.GetType(field)
		g.w.Line(fmt.Sprintf("$d->%s[] = %s::__decode($bytes, $i, $_msgLen);", fieldName, phpType))
		g.w.Line("$i = $_msgLen;")
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING || field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES {
		g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
		g.inlineReadCode(field, "$_value")
		g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
	}
}
