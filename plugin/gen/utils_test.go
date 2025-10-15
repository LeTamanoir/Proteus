package gen

import (
	"testing"

	"google.golang.org/protobuf/types/descriptorpb"
)

func TestGetWireType(t *testing.T) {
	tests := []struct {
		name      string
		fieldType descriptorpb.FieldDescriptorProto_Type
		want      int
	}{
		{
			name:      "int32 is varint (0)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_INT32,
			want:      0,
		},
		{
			name:      "fixed64 is 64-bit (1)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_FIXED64,
			want:      1,
		},
		{
			name:      "string is length-delimited (2)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_STRING,
			want:      2,
		},
		{
			name:      "message is length-delimited (2)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_MESSAGE,
			want:      2,
		},
		{
			name:      "fixed32 is 32-bit (5)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
			want:      5,
		},
		{
			name:      "bool is varint (0)",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_BOOL,
			want:      0,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := getWireType(tt.fieldType)
			if got != tt.want {
				t.Errorf("getWireType(%v) = %d, want %d", tt.fieldType, got, tt.want)
			}
		})
	}
}

func TestIsPackable(t *testing.T) {
	tests := []struct {
		name      string
		fieldType descriptorpb.FieldDescriptorProto_Type
		want      bool
	}{
		{
			name:      "int32 is packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_INT32,
			want:      true,
		},
		{
			name:      "string is not packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_STRING,
			want:      false,
		},
		{
			name:      "bytes is not packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_BYTES,
			want:      false,
		},
		{
			name:      "message is not packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_MESSAGE,
			want:      false,
		},
		{
			name:      "fixed32 is packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
			want:      true,
		},
		{
			name:      "bool is packable",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_BOOL,
			want:      true,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := isPackable(tt.fieldType)
			if got != tt.want {
				t.Errorf("isPackable(%v) = %v, want %v", tt.fieldType, got, tt.want)
			}
		})
	}
}

func TestIsRepeated(t *testing.T) {
	repeated := descriptorpb.FieldDescriptorProto_LABEL_REPEATED
	optional := descriptorpb.FieldDescriptorProto_LABEL_OPTIONAL

	tests := []struct {
		name  string
		field *descriptorpb.FieldDescriptorProto
		want  bool
	}{
		{
			name: "repeated field",
			field: &descriptorpb.FieldDescriptorProto{
				Label: &repeated,
			},
			want: true,
		},
		{
			name: "optional field",
			field: &descriptorpb.FieldDescriptorProto{
				Label: &optional,
			},
			want: false,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := isRepeated(tt.field)
			if got != tt.want {
				t.Errorf("isRepeated() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestIsOptional(t *testing.T) {
	tests := []struct {
		name  string
		field *descriptorpb.FieldDescriptorProto
		want  bool
	}{
		{
			name: "proto3 optional field",
			field: &descriptorpb.FieldDescriptorProto{
				Proto3Optional: boolPtr(true),
			},
			want: true,
		},
		{
			name: "non-optional field",
			field: &descriptorpb.FieldDescriptorProto{
				Proto3Optional: boolPtr(false),
			},
			want: false,
		},
		{
			name:  "field without proto3_optional set",
			field: &descriptorpb.FieldDescriptorProto{},
			want:  false,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := isOptional(tt.field)
			if got != tt.want {
				t.Errorf("isOptional() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestIsMessage(t *testing.T) {
	messageType := descriptorpb.FieldDescriptorProto_TYPE_MESSAGE
	stringType := descriptorpb.FieldDescriptorProto_TYPE_STRING

	tests := []struct {
		name  string
		field *descriptorpb.FieldDescriptorProto
		want  bool
	}{
		{
			name: "message type",
			field: &descriptorpb.FieldDescriptorProto{
				Type: &messageType,
			},
			want: true,
		},
		{
			name: "string type",
			field: &descriptorpb.FieldDescriptorProto{
				Type: &stringType,
			},
			want: false,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := isMessage(tt.field)
			if got != tt.want {
				t.Errorf("isMessage() = %v, want %v", got, tt.want)
			}
		})
	}
}

func TestIsMapField(t *testing.T) {
	repeated := descriptorpb.FieldDescriptorProto_LABEL_REPEATED
	messageType := descriptorpb.FieldDescriptorProto_TYPE_MESSAGE
	stringType := descriptorpb.FieldDescriptorProto_TYPE_STRING

	tests := []struct {
		name  string
		field *descriptorpb.FieldDescriptorProto
		file  *descriptorpb.FileDescriptorProto
		want  bool
	}{
		{
			name: "not repeated",
			field: &descriptorpb.FieldDescriptorProto{
				Type: &messageType,
			},
			file: &descriptorpb.FileDescriptorProto{},
			want: false,
		},
		{
			name: "repeated but not message",
			field: &descriptorpb.FieldDescriptorProto{
				Label: &repeated,
				Type:  &stringType,
			},
			file: &descriptorpb.FileDescriptorProto{},
			want: false,
		},
		{
			name: "repeated message with MapEntry option",
			field: &descriptorpb.FieldDescriptorProto{
				Label:    &repeated,
				Type:     &messageType,
				TypeName: stringPtr(".test.Message.MapFieldEntry"),
			},
			file: &descriptorpb.FileDescriptorProto{
				MessageType: []*descriptorpb.DescriptorProto{
					{
						Name: stringPtr("Message"),
						NestedType: []*descriptorpb.DescriptorProto{
							{
								Name: stringPtr("MapFieldEntry"),
								Options: &descriptorpb.MessageOptions{
									MapEntry: boolPtr(true),
								},
							},
						},
					},
				},
			},
			want: true,
		},
		{
			name: "repeated message without MapEntry option",
			field: &descriptorpb.FieldDescriptorProto{
				Label:    &repeated,
				Type:     &messageType,
				TypeName: stringPtr(".test.Message.RegularEntry"),
			},
			file: &descriptorpb.FileDescriptorProto{
				MessageType: []*descriptorpb.DescriptorProto{
					{
						Name: stringPtr("Message"),
						NestedType: []*descriptorpb.DescriptorProto{
							{
								Name: stringPtr("RegularEntry"),
								Options: &descriptorpb.MessageOptions{
									MapEntry: boolPtr(false),
								},
							},
						},
					},
				},
			},
			want: false,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := isMapField(tt.field, tt.file)
			if got != tt.want {
				t.Errorf("isMapField() = %v, want %v", got, tt.want)
			}
		})
	}
}

func boolPtr(b bool) *bool {
	return &b
}
