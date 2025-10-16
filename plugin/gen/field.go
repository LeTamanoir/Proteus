package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genRegularFieldCode generates code for deserializing a regular field
func (g *generator) genRegularFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto) {
	fieldName := field.GetName()
	expectedWireType := getWireType(field.GetType())

	w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception(sprintf('Invalid wire type %%d for field %s', $wireType));", expectedWireType, fieldName))
	g.inlineReadCode(w, field, "$_value")
	w.Line(fmt.Sprintf("$d->%s = $_value;", fieldName))
}
