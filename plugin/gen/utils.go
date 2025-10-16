package gen

import (
	"fmt"
	"strings"

	"github.com/LeTamanoir/Proteus/plugin/php"
	"github.com/LeTamanoir/Proteus/plugin/writer"
	"google.golang.org/protobuf/types/descriptorpb"
)

// inlineReadCode returns inline code for reading a specific protobuf type
// inspired by gogoproto: https://github.com/cosmos/gogoproto/blob/main/plugin/unmarshal/unmarshal.go#L345
func (g *generator) inlineReadCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, varName string) {
	switch field.GetType() {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32:
		w.InlineReadInt32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_SINT32:
		w.InlineReadSint32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_SINT64:
		w.InlineReadSint64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64:
		w.InlineReadVarint(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		w.InlineReadUint64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		w.InlineReadVarint(varName)
		w.Line(fmt.Sprintf("%s = %s === 1;", varName, varName))
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED32:
		w.InlineReadFixed32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64:
		w.InlineReadFixed64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		w.InlineReadSfixed64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT:
		w.InlineReadFloat(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		w.InlineReadDouble(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_STRING:
		w.InlineReadString(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		w.InlineReadBytes(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		w.InlineReadVarint("$_len")
		w.Line("$_msgLen = $i + $_len;")
		w.Line("if ($_msgLen < 0 || $_msgLen > $l) throw new \\Exception('Invalid length');")
		phpType := g.getPhpType(field)
		w.Line(fmt.Sprintf("%s = %s::__decode($bytes, $i, $_msgLen);", varName, phpType))
		w.Line("$i = $_msgLen;")
	}
}

// getWireType returns the wire type for a field type
func getWireType(fieldType descriptorpb.FieldDescriptorProto_Type) int {
	switch fieldType {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64,
		descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_UINT64,
		descriptorpb.FieldDescriptorProto_TYPE_SINT32,
		descriptorpb.FieldDescriptorProto_TYPE_SINT64,
		descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		return 0 // Varint
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		return 1 // 64-bit
	case descriptorpb.FieldDescriptorProto_TYPE_STRING,
		descriptorpb.FieldDescriptorProto_TYPE_BYTES,
		descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		return 2 // Length-delimited
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_FLOAT:
		return 5 // 32-bit
	default:
		panic(fmt.Sprintf("unknown wire type for: %v", fieldType))
	}
}

// isPackable returns whether a type can be packed
func isPackable(fieldType descriptorpb.FieldDescriptorProto_Type) bool {
	switch fieldType {
	case descriptorpb.FieldDescriptorProto_TYPE_STRING,
		descriptorpb.FieldDescriptorProto_TYPE_BYTES,
		descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		return false
	default:
		return true
	}
}

// isRepeated checks if a field is repeated
func isRepeated(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetLabel() == descriptorpb.FieldDescriptorProto_LABEL_REPEATED
}

// isOptional checks if a field is explicitly optional
func isOptional(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetProto3Optional()
}

// isMessage checks if a field is a message type
func isMessage(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_MESSAGE
}

// isMapField checks if a field is a map field by looking at the message descriptor
func isMapField(field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) bool {
	if !isRepeated(field) || !isMessage(field) {
		return false
	}

	// Map fields are encoded as repeated messages with the MapEntry option set
	typeName := field.GetTypeName()

	// Look for the nested message type in the parent message
	for _, nested := range message.GetNestedType() {
		if strings.HasSuffix(typeName, "."+nested.GetName()) {
			return nested.GetOptions().GetMapEntry()
		}
	}

	return false
}

// GetType returns the PHP type for a field
func (g *generator) getPhpType(field *descriptorpb.FieldDescriptorProto) string {
	switch field.GetType() {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32,
		descriptorpb.FieldDescriptorProto_TYPE_SINT32,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED32:
		return "int"
	case descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_FIXED32:
		return "int"
	case descriptorpb.FieldDescriptorProto_TYPE_INT64,
		descriptorpb.FieldDescriptorProto_TYPE_SINT64,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		return "int"
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		return "string"
	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT,
		descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		return "float"
	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		return "bool"
	case descriptorpb.FieldDescriptorProto_TYPE_STRING:
		return "string"
	case descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		return "string"
	case descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		if entry, ok := g.msgByFqn[field.GetTypeName()]; ok {
			return entry.phpFqn
		}

		typeName := field.GetTypeName()
		parts := strings.Split(typeName, ".")
		return php.GetSafeName(parts[len(parts)-1])
	default:
		return "mixed"
	}
}
