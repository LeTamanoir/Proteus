package gen

import (
	"fmt"
	"strings"

	"cli/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// getMapKeyValueTypes extracts key and value field types from a map entry message
func getMapKeyValueTypes(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) (*descriptorpb.FieldDescriptorProto, *descriptorpb.FieldDescriptorProto) {
	typeName := field.GetTypeName()
	var keyField, valueField *descriptorpb.FieldDescriptorProto

	for _, message := range file.GetMessageType() {
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
	}

	return nil, nil
}

// genMapFieldCode generates code for deserializing a map field
func (g *gen) genMapFieldCode(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) {
	keyField, valueField := getMapKeyValueTypes(field, file)

	if keyField == nil || valueField == nil {
		panic(fmt.Sprintf("Map entry message %s not found", field.GetTypeName()))
	}

	fieldName := field.GetName()

	g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))

	g.w.InlineReadVarint("_entryLen")
	g.w.Line("$_limit = $i + $_entryLen;")

	// Initialize key and value with defaults
	keyDefault := php.GetDefaultValue(keyField)
	valueDefault := php.GetDefaultValue(valueField)

	g.w.Line(fmt.Sprintf("$_key = %s;", keyDefault))
	g.w.Line(fmt.Sprintf("$_val = %s;", valueDefault))
	g.w.Line("while ($i < $_limit) {")
	g.w.In()

	g.w.InlineReadVarint("_tag")
	g.w.Line("$_fn = $_tag >> 3;")
	g.w.Line("$_wt = $_tag & 0x7;")
	g.w.Line("switch ($_fn) {")
	g.w.In()

	// Case 1: key
	g.w.Line("case 1:")
	g.w.In()
	keyWireType := getWireType(keyField.GetType())
	g.w.Line(fmt.Sprintf("if ($_wt !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s key', $_wt));", keyWireType, fieldName))

	if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_keyValue")
		g.w.Line("$_key = $_keyValue === 1;")
	} else if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(keyField.GetType(), "_keyTemp")
		g.w.Line("$_key = (string) $_keyTemp;")
	} else {
		g.inlineReadCode(keyField.GetType(), "_key")
	}
	g.w.Line("break;")
	g.w.Out()

	// Case 2: value
	g.w.Line("case 2:")
	g.w.In()
	valueWireType := getWireType(valueField.GetType())
	g.w.Line(fmt.Sprintf("if ($_wt !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s value', $_wt));", valueWireType, fieldName))

	if isMessage(valueField) {
		g.w.InlineReadVarint("_msgLen")
		g.w.Line("$_msgEnd = $i + $_msgLen;")
		g.w.Line("if ($_msgEnd < 0 || $_msgEnd > $l) throw new \\Exception('Invalid length');")
		valueType := php.GetType(valueField)
		g.w.Line(fmt.Sprintf("$_val = %s::fromBytes(array_slice($bytes, $i, $_msgLen));", valueType))
		g.w.Line("$i = $_msgEnd;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(valueField.GetType(), "_valTemp")
		g.w.Line("$_val = (string) $_valTemp;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_valTemp")
		g.w.Line("$_val = $_valTemp === 1;")
	} else {
		g.inlineReadCode(valueField.GetType(), "_val")
	}
	g.w.Line("break;")
	g.w.Out()

	// Default case
	g.w.Line("default:")
	g.w.In()
	g.w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $_wt);")
	g.w.Out()
	g.w.Out()
	g.w.Line("}")
	g.w.Out()
	g.w.Line("}")
	g.w.Line(fmt.Sprintf("$d->%s[$_key] = $_val;", fieldName))
}
