package protobuf

import (
	"fmt"
	"strings"

	"google.golang.org/protobuf/types/descriptorpb"
)

// GetWireType returns the wire type for a field type
func GetWireType(fieldType descriptorpb.FieldDescriptorProto_Type) int32 {
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

// IsPackable returns whether a type can be packed
func IsPackable(fieldType descriptorpb.FieldDescriptorProto_Type) bool {
	switch fieldType {
	case descriptorpb.FieldDescriptorProto_TYPE_STRING,
		descriptorpb.FieldDescriptorProto_TYPE_BYTES,
		descriptorpb.FieldDescriptorProto_TYPE_MESSAGE:
		return false
	default:
		return true
	}
}

// IsRepeated checks if a field is repeated
func IsRepeated(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetLabel() == descriptorpb.FieldDescriptorProto_LABEL_REPEATED
}

// IsOptional checks if a field is explicitly optional
func IsOptional(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetProto3Optional()
}

// IsMessage checks if a field is a message type
func IsMessage(field *descriptorpb.FieldDescriptorProto) bool {
	return field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_MESSAGE
}

// IsMapField checks if a field is a map field by looking at the message descriptor
func IsMapField(field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) bool {
	if !IsRepeated(field) || !IsMessage(field) {
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
