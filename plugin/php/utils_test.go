package php

import (
	"testing"

	"google.golang.org/protobuf/types/descriptorpb"
)

func TestGetClassName_ReservedWords(t *testing.T) {
	tests := []struct {
		name  string
		input string
		want  string
	}{
		{
			name:  "Empty is reserved",
			input: "Empty",
			want:  "Empty_",
		},
		{
			name:  "String is reserved",
			input: "String",
			want:  "String_",
		},
		{
			name:  "Normal name unchanged",
			input: "Normal",
			want:  "Normal",
		},
		{
			name:  "lowercase empty is reserved",
			input: "empty",
			want:  "empty_",
		},
		{
			name:  "Exception is reserved",
			input: "Exception",
			want:  "Exception_",
		},
		{
			name:  "int is reserved",
			input: "int",
			want:  "int_",
		},
		{
			name:  "Already suffixed name passes through",
			input: "Empty_",
			want:  "Empty_",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := GetClassName(tt.input)
			if got != tt.want {
				t.Errorf("GetClassName(%q) = %q, want %q", tt.input, got, tt.want)
			}
		})
	}
}

func TestGetType(t *testing.T) {
	tests := []struct {
		name      string
		fieldType descriptorpb.FieldDescriptorProto_Type
		want      string
	}{
		{
			name:      "int32",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_INT32,
			want:      "int",
		},
		{
			name:      "uint64 becomes string",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_UINT64,
			want:      "string",
		},
		{
			name:      "float",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_FLOAT,
			want:      "float",
		},
		{
			name:      "bool",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_BOOL,
			want:      "bool",
		},
		{
			name:      "string",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_STRING,
			want:      "string",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			field := &descriptorpb.FieldDescriptorProto{
				Type: &tt.fieldType,
			}
			got := GetType(field)
			if got != tt.want {
				t.Errorf("GetType(%v) = %q, want %q", tt.fieldType, got, tt.want)
			}
		})
	}
}

func TestGetDefaultValue(t *testing.T) {
	tests := []struct {
		name      string
		fieldType descriptorpb.FieldDescriptorProto_Type
		want      string
	}{
		{
			name:      "int32 defaults to 0",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_INT32,
			want:      "0",
		},
		{
			name:      "uint64 defaults to '0'",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_UINT64,
			want:      "'0'",
		},
		{
			name:      "float defaults to 0.0",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_FLOAT,
			want:      "0.0",
		},
		{
			name:      "bool defaults to false",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_BOOL,
			want:      "false",
		},
		{
			name:      "string defaults to ''",
			fieldType: descriptorpb.FieldDescriptorProto_TYPE_STRING,
			want:      "''",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			field := &descriptorpb.FieldDescriptorProto{
				Type: &tt.fieldType,
			}
			got := GetDefaultValue(field)
			if got != tt.want {
				t.Errorf("GetDefaultValue(%v) = %q, want %q", tt.fieldType, got, tt.want)
			}
		})
	}
}

func TestGetNamespace(t *testing.T) {
	tests := []struct {
		name      string
		file      *descriptorpb.FileDescriptorProto
		wantNs    string
		wantFound bool
	}{
		{
			name: "With php_namespace option",
			file: &descriptorpb.FileDescriptorProto{
				Options: &descriptorpb.FileOptions{
					PhpNamespace: stringPtr("Test\\Namespace"),
				},
			},
			wantNs:    "Test\\Namespace",
			wantFound: true,
		},
		{
			name: "Without php_namespace option",
			file: &descriptorpb.FileDescriptorProto{
				Options: &descriptorpb.FileOptions{},
			},
			wantNs:    "",
			wantFound: false,
		},
		{
			name:      "No options at all",
			file:      &descriptorpb.FileDescriptorProto{},
			wantNs:    "",
			wantFound: false,
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			gotNs, gotFound := GetNamespace(tt.file)
			if gotNs != tt.wantNs {
				t.Errorf("GetNamespace() namespace = %q, want %q", gotNs, tt.wantNs)
			}
			if gotFound != tt.wantFound {
				t.Errorf("GetNamespace() found = %v, want %v", gotFound, tt.wantFound)
			}
		})
	}
}

func stringPtr(s string) *string {
	return &s
}
