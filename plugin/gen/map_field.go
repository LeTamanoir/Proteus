package gen

import (
	"fmt"
	"strings"

	"github.com/LeTamanoir/Proteus/plugin/php"
	"github.com/LeTamanoir/Proteus/plugin/writer"

	"google.golang.org/protobuf/types/descriptorpb"
)

// getMapKeyValueTypes extracts key and value field types from a map entry message
func getMapKeyValueTypes(field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) (keyField, valueField *descriptorpb.FieldDescriptorProto) {
	typeName := field.GetTypeName()

	for _, nested := range message.GetNestedType() {
		if strings.HasSuffix(typeName, "."+nested.GetName()) && nested.GetOptions().GetMapEntry() {
			// Map entry messages have exactly 2 fields: key (field 1) and value (field 2)
			// see https://github.com/protocolbuffers/protobuf-go/blob/f9fa50e26c0ffec610c509850484a5fdecdb26ec/types/descriptorpb/descriptor.pb.go#L2677-L2701
			for _, f := range nested.GetField() {
				if f.GetNumber() == 1 {
					keyField = f
				} else if f.GetNumber() == 2 {
					valueField = f
				}
			}
			return keyField, valueField
		}
	}

	return nil, nil
}

// genMapFieldCode generates code for deserializing a map field
func (g *generator) genMapFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) error {
	keyField, valueField := getMapKeyValueTypes(field, message)

	if keyField == nil || valueField == nil {
		return fmt.Errorf("map entry message %s not found", field.GetTypeName())
	}

	fieldName := field.GetName()
	w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
	w.InlineReadVarint("$_entryLen")
	w.Line("$_limit = $i + $_entryLen;")
	w.Line(fmt.Sprintf("$_key = %s;", php.GetDefaultValue(keyField)))
	w.Line(fmt.Sprintf("$_val = %s;", php.GetDefaultValue(valueField)))
	w.Line("while ($i < $_limit) {")
	w.In()
	w.InlineReadVarint("$_tag")
	w.Line("$_fieldNum = $_tag >> 3;")
	w.Line("$_wireType = $_tag & 0x7;")
	w.Line("switch ($_fieldNum) {")
	w.In()
	w.Line("case 1:")
	w.In()
	keyWireType := getWireType(keyField.GetType())
	w.Line(fmt.Sprintf("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s key', $_wireType));", keyWireType, fieldName))

	g.inlineReadCode(w, keyField, "$_key")
	w.Line("break;")
	w.Out()
	w.Line("case 2:")
	w.In()
	valueWireType := getWireType(valueField.GetType())
	w.Line(fmt.Sprintf("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s value', $_wireType));", valueWireType, fieldName))
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
	w.Line(fmt.Sprintf("$d->%s[$_key] = $_val;", fieldName))

	return nil
}
