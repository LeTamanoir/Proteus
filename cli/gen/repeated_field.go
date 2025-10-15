package gen

import (
	"cli/php"
	"fmt"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genFieldValueAppend generates code to append a field value to a repeated field array
func (g *gen) genFieldValueAppend(field *descriptorpb.FieldDescriptorProto, fieldName string) error {
	switch field.GetType() {
	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		if err := g.inlineReadCode(field.GetType(), "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s[] = (string) $_value;", fieldName))
	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		if err := g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
	default:
		if err := g.inlineReadCode(field.GetType(), "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
	}
	return nil
}

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *gen) genRepeatedFieldCode(field *descriptorpb.FieldDescriptorProto) error {
	fieldName := field.GetName()

	expectedWireType, err := getWireType(field.GetType())
	if err != nil {
		return err
	}

	if isPackable(field.GetType()) {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		g.w.InlineReadVarint("_len")
		g.w.Line("$_end = $i + $_len;")
		g.w.Line("while ($i < $_end) {")
		g.w.In()
		if err := g.genFieldValueAppend(field, fieldName); err != nil {
			return err
		}
		g.w.Out()
		g.w.Line("}")
		g.w.Line(fmt.Sprintf("if ($i !== $_end) throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))
	} else if isMessage(field) {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
		phpType := php.GetType(field)
		g.w.Line(fmt.Sprintf("$d->%s[] = %s::decode(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
		return nil
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING || field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES {
		g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
		if e := g.inlineReadCode(field.GetType(), "_value"); e != nil {
			return e
		}
		g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
	}

	return nil
}
