package gen

import (
	"fmt"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genRegularFieldCode generates code for deserializing a regular field
func (g *gen) genRegularFieldCode(field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()
	expectedWireType := getWireType(field.GetType())

	g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
	g.inlineReadCode(field, "_value")
	g.w.Line(fmt.Sprintf("$d->%s = $_value;", fieldName))
}
