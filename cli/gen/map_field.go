package gen

import (
	"fmt"
	"strings"

	"cli/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// getMapKeyValueTypes extracts key and value field types from a map entry message
func getMapKeyValueTypes(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) (keyField, valueField *descriptorpb.FieldDescriptorProto) {
	typeName := field.GetTypeName()

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
func (g *gen) genMapFieldCode(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) error {
	keyField, valueField := getMapKeyValueTypes(field, file)

	if keyField == nil || valueField == nil {
		return fmt.Errorf("map entry message %s not found", field.GetTypeName())
	}

	fieldName := field.GetName()
	g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
	g.w.InlineReadVarint("_entryLen")
	g.w.Line("$_limit = $i + $_entryLen;")
	g.w.Line(fmt.Sprintf("$_key = %s;", php.GetDefaultValue(keyField)))
	g.w.Line(fmt.Sprintf("$_val = %s;", php.GetDefaultValue(valueField)))
	g.w.Line("while ($i < $_limit) {")
	g.w.In()
	g.w.InlineReadVarint("_tag")
	g.w.Line("$_fieldNum = $_tag >> 3;")
	g.w.Line("$_wireType = $_tag & 0x7;")
	g.w.Line("switch ($_fieldNum) {")
	g.w.In()
	g.w.Line("case 1:")
	g.w.In()
	keyWireType, err := getWireType(keyField.GetType())
	if err != nil {
		return err
	}
	g.w.Line(fmt.Sprintf("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s key', $_wireType));", keyWireType, fieldName))

	if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		if e := g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_keyValue"); e != nil {
			return e
		}
		g.w.Line("$_key = $_keyValue === 1;")
	} else if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		if e := g.inlineReadCode(keyField.GetType(), "_keyTemp"); e != nil {
			return e
		}
		g.w.Line("$_key = (string) $_keyTemp;")
	} else {
		if e := g.inlineReadCode(keyField.GetType(), "_key"); e != nil {
			return e
		}
	}
	g.w.Line("break;")
	g.w.Out()
	g.w.Line("case 2:")
	g.w.In()
	valueWireType, err := getWireType(valueField.GetType())
	if err != nil {
		return err
	}
	g.w.Line(fmt.Sprintf("if ($_wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s value', $_wireType));", valueWireType, fieldName))

	if isMessage(valueField) {
		g.w.InlineReadVarint("_msgLen")
		g.w.Line("$_msgEnd = $i + $_msgLen;")
		g.w.Line("if ($_msgEnd < 0 || $_msgEnd > $l) throw new \\Exception('Invalid length');")
		valueType := php.GetType(valueField)
		g.w.Line(fmt.Sprintf("$_val = %s::decode(array_slice($bytes, $i, $_msgLen));", valueType))
		g.w.Line("$i = $_msgEnd;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		if e := g.inlineReadCode(valueField.GetType(), "_valTemp"); e != nil {
			return e
		}
		g.w.Line("$_val = (string) $_valTemp;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		if e := g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_valTemp"); e != nil {
			return e
		}
		g.w.Line("$_val = $_valTemp === 1;")
	} else {
		if e := g.inlineReadCode(valueField.GetType(), "_val"); e != nil {
			return e
		}
	}
	g.w.Line("break;")
	g.w.Out()
	g.w.Line("default:")
	g.w.In()
	g.w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $_wireType);")
	g.w.Out()
	g.w.Out()
	g.w.Line("}")
	g.w.Out()
	g.w.Line("}")
	g.w.Line(fmt.Sprintf("$d->%s[$_key] = $_val;", fieldName))

	return nil
}
