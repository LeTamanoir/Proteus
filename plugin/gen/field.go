package gen

import (
	"fmt"

	"plugin/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genRegularFieldCode generates code for deserializing a regular field
func (g *gen) genRegularFieldCode(field *descriptorpb.FieldDescriptorProto) error {
	fieldName := field.GetName()
	expectedWireType, err := getWireType(field.GetType())
	if err != nil {
		return err
	}

	g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))

	if isMessage(field) {
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
		phpType := php.GetType(field)
		g.w.Line(fmt.Sprintf("$d->%s = %s::decode(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		if err := g.inlineReadCode(field.GetType(), "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s = (string) $_value;", fieldName))
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		if err := g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s = $_value === 1;", fieldName))
	} else {
		if err := g.inlineReadCode(field.GetType(), "_value"); err != nil {
			return err
		}
		g.w.Line(fmt.Sprintf("$d->%s = $_value;", fieldName))
	}

	return nil
}
