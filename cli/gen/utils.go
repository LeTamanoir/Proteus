package gen

import (
	"fmt"
	"strings"

	"google.golang.org/protobuf/types/descriptorpb"
)

// inlineReadCode returns inline code for reading a specific protobuf type
func (g *gen) inlineReadCode(fieldType descriptorpb.FieldDescriptorProto_Type, varName string) {
	switch fieldType {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32:
		g.w.InlineReadInt32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_SINT32:
		g.w.InlineReadSint32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_SINT64:
		g.w.InlineReadSint64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64,
		descriptorpb.FieldDescriptorProto_TYPE_UINT64,
		descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		g.w.InlineReadVarint(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED32:
		g.w.InlineReadFixed32(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_FIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		g.w.InlineReadFixed64(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT:
		g.w.InlineReadFloat(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		g.w.InlineReadDouble(varName)
	case descriptorpb.FieldDescriptorProto_TYPE_STRING,
		descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		g.w.InlineReadBytes(varName)
	default:
		panic(fmt.Sprintf("Unknown inline read for type: %v", fieldType))
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
		panic(fmt.Sprintf("Unknown wire type for: %v", fieldType))
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
func isMapField(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) bool {
	if !isRepeated(field) || !isMessage(field) {
		return false
	}

	// Map fields are encoded as repeated messages with the MapEntry option set
	typeName := field.GetTypeName()

	// Look for the nested message type in the parent message
	for _, message := range file.GetMessageType() {
		for _, nested := range message.GetNestedType() {
			if strings.HasSuffix(typeName, "."+nested.GetName()) {
				return nested.GetOptions().GetMapEntry()
			}
		}
	}

	return false
}
