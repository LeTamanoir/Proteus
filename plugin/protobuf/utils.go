package protobuf

import (
	"fmt"
	"strings"

	"google.golang.org/protobuf/types/descriptorpb"
)

// GetMapKeyValueTypes extracts key and value field types from a map entry message
func GetMapKeyValueTypes(field *descriptorpb.FieldDescriptorProto, message *descriptorpb.DescriptorProto) (keyField, valueField *descriptorpb.FieldDescriptorProto) {
	typeName := field.GetTypeName()

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

	panic(fmt.Sprintf("map entry message %s not found in message %s", typeName, message.GetName()))
}
