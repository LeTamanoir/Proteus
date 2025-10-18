package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/protobuf"
	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// genEncodeMethods generates the encode methods for all messages
func (g *generator) genEncodeMethods(w *writer.Writer, message *descriptorpb.DescriptorProto) {
	w.Docblock(`@internal`)
	w.Line("public function __encode(): string")
	w.Line("{")
	w.In()
	w.Line("$buf = '';")

	for _, field := range message.GetField() {
		fieldName := field.GetName()
		fieldNumber := field.GetNumber()

		switch {
		case protobuf.IsMapField(field, message):
			g.genMapFieldEncodeCode(w, field, message, fieldNumber)

		case protobuf.IsRepeated(field):
			g.genRepeatedFieldEncodeCode(w, field, fieldNumber)

		default:
			g.genRegularFieldEncodeCode(w, field, fieldNumber, fieldName)
		}
	}

	w.Line("return $buf;")
	w.Out()
	w.Line("}")
}

// genRegularFieldEncodeCode generates code for encoding a regular field
func (g *generator) genRegularFieldEncodeCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, fieldNumber int32, fieldName string) {
	wireType := protobuf.GetWireType(field.GetType())
	tag := (fieldNumber << 3) | wireType

	w.Line("if ($this->%s !== %s) {", fieldName, getDefaultValue(field))
	w.In()
	w.InlineWriteTag(tag, "$buf")
	g.inlineWriteCode(w, field, fmt.Sprintf("$this->%s", fieldName), "$buf")
	w.Out()
	w.Line("}")
}

// genRepeatedFieldEncodeCode generates code for encoding a repeated field
func (g *generator) genRepeatedFieldEncodeCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, fieldNumber int32) {
	fieldName := field.GetName()

	switch {
	case protobuf.IsPackable(field.GetType()):
		tag := (fieldNumber << 3) | 2
		w.Line("if (!empty($this->%s)) {", fieldName)
		w.In()
		w.InlineWriteTag(tag, "$buf")
		w.Line("$_packed = '';")
		w.Line("foreach ($this->%s as $_value) {", fieldName)
		w.In()
		g.inlineWriteCode(w, field, "$_value", "$_packed")
		w.Out()
		w.Line("}")
		w.InlineWritePositiveInt64("strlen($_packed)", "$buf")
		w.Line("$buf .= $_packed;")
		w.Out()
		w.Line("}")

	case protobuf.IsMessage(field):
		tag := (fieldNumber << 3) | 2
		w.Line("foreach ($this->%s as $_value) {", fieldName)
		w.In()
		w.InlineWriteTag(tag, "$buf")
		w.Line("$_msgBuf = $_value->__encode();")
		w.InlineWritePositiveInt64("strlen($_msgBuf)", "$buf")
		w.Line("$buf .= $_msgBuf;")
		w.Out()
		w.Line("}")

	case field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING || field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		wireType := protobuf.GetWireType(field.GetType())
		tag := (fieldNumber << 3) | wireType
		w.Line("foreach ($this->%s as $_value) {", fieldName)
		w.In()
		w.InlineWriteTag(tag, "$buf")
		g.inlineWriteCode(w, field, "$_value", "$buf")
		w.Out()
		w.Line("}")
	}
}

// genMapFieldEncodeCode generates code for encoding a map field
func (g *generator) genMapFieldEncodeCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto, fieldNumber int32) {
	keyField, valueField := protobuf.GetMapKeyValueTypes(field, message)
	fieldName := field.GetName()
	tag := (fieldNumber << 3) | 2 // Maps are always length-delimited

	w.Line("foreach ($this->%s as $_key => $_val) {", fieldName)
	w.In()
	w.InlineWriteTag(tag, "$buf")

	w.Line("$_entryBuf = '';")

	// Write key (field number 1)
	keyWireType := protobuf.GetWireType(keyField.GetType())
	keyTag := (1 << 3) | keyWireType
	w.InlineWriteTag(keyTag, "$_entryBuf")
	g.inlineWriteCode(w, keyField, "$_key", "$_entryBuf")

	// Write value (field number 2)
	valueWireType := protobuf.GetWireType(valueField.GetType())
	valueTag := (2 << 3) | valueWireType
	w.InlineWriteTag(valueTag, "$_entryBuf")
	g.inlineWriteCode(w, valueField, "$_val", "$_entryBuf")

	w.InlineWritePositiveInt64("strlen($_entryBuf)", "$buf")
	w.Line("$buf .= $_entryBuf;")

	w.Out()
	w.Line("}")
}
