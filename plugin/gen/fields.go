package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/protobuf"
	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genRegularFieldCode generates code for deserializing a regular field
func (g *generator) genRegularFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()
	expectedWireType := protobuf.GetWireType(field.GetType())

	w.Line("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName)
	g.inlineReadCode(w, field, fmt.Sprintf("$d->%s", fieldName))
}

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *generator) genRepeatedFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()

	expectedWireType := protobuf.GetWireType(field.GetType())

	switch {
	case protobuf.IsPackable(field.GetType()):
		w.Line("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName)
		w.InlineReadVarint("$_len")
		w.Line("$_end = $i + $_len;")
		w.Line("while ($i < $_end) {")
		w.In()
		g.inlineReadCode(w, field, "$_value")
		w.Line("$d->%s[] = $_value;", fieldName)
		w.Out()
		w.Line("}")

	case protobuf.IsMessage(field):
		w.Line("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName)
		w.InlineReadVarint("$_len")
		phpType := g.getPhpType(field)
		w.Line("$d->%s[] = %s::__decode($bytes, $i, $i + $_len);", fieldName, phpType)
		w.Line("$i += $_len;")

	case field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING || field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		w.Line("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName)
		g.inlineReadCode(w, field, "$_value")
		w.Line("$d->%s[] = $_value;", fieldName)
	}
}

// genMapFieldCode generates code for deserializing a map field
func (g *generator) genMapFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) {
	keyField, valueField := protobuf.GetMapKeyValueTypes(field, message)
	fieldName := field.GetName()

	w.Line("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName)
	w.InlineReadVarint("$_entryLen")
	w.Line("$_limit = $i + $_entryLen;")
	w.Line("$_key = %s;", getDefaultValue(keyField))
	w.Line("$_val = %s;", getDefaultValue(valueField))
	w.Line("while ($i < $_limit) {")
	w.In()
	w.InlineReadVarint("$_tag")
	w.Line("$_fieldNum = $_tag >> 3;")
	w.Line("$_wireType = $_tag & 0x7;")
	w.Line("switch ($_fieldNum) {")
	w.In()
	w.Line("case 1:")
	w.In()
	w.Line("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s key', $_wireType));",
		protobuf.GetWireType(keyField.GetType()), fieldName)
	g.inlineReadCode(w, keyField, "$_key")
	w.Line("break;")
	w.Out()
	w.Line("case 2:")
	w.In()
	w.Line("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s value', $_wireType));",
		protobuf.GetWireType(valueField.GetType()), fieldName)
	g.inlineReadCode(w, valueField, "$_val")
	w.Line("break;")
	w.Out()
	w.Line("default:")
	w.In()
	w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $_wireType);")
	w.Out()
	w.Out()
	w.Line("}")
	w.Out()
	w.Line("}")
	w.Line("$d->%s[$_key] = $_val;", fieldName)
}
