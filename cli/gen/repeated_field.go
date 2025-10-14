package gen

import (
	"fmt"

	"cli/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *gen) genRepeatedFieldCode(field *descriptorpb.FieldDescriptorProto) error {
	fieldName := field.GetName()

	// Message types are never packed
	if isMessage(field) {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
		phpType := php.GetType(field)
		g.w.Line(fmt.Sprintf("$d->%s[] = %s::decode(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
		return nil
	}

	expectedWireType, err := getWireType(field.GetType())
	if err != nil {
		return err
	}
	packable := isPackable(field.GetType())

	if packable {
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", fieldName))

		g.w.InlineReadVarint("_len")
		g.w.Line("$_end = $i + $_len;")
		g.w.Line("while ($i < $_end) {")
		g.w.In()

		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
			err = g.inlineReadCode(field.GetType(), "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = (string) $_value;", fieldName))
		} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
			err = g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
		} else {
			err = g.inlineReadCode(field.GetType(), "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}

		g.w.Out()
		g.w.Line("}")
		g.w.Line(fmt.Sprintf("if ($i !== $_end) throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))

		// Unpacked format
		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
			err = g.inlineReadCode(field.GetType(), "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = (string) $_value;", fieldName))
		} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
			err = g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
		} else {
			err = g.inlineReadCode(field.GetType(), "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}
	} else {
		// Non-packable types
		g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING ||
			field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES {
			err = g.inlineReadCode(field.GetType(), "_value")
			if err != nil {
				return err
			}
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}
	}

	return nil
}
