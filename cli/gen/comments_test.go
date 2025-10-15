package gen

import (
	"testing"

	"google.golang.org/protobuf/types/descriptorpb"
)

func TestPathToString(t *testing.T) {
	tests := []struct {
		name string
		path []int32
		want string
	}{
		{
			name: "empty path",
			path: []int32{},
			want: "",
		},
		{
			name: "single element",
			path: []int32{4},
			want: "4",
		},
		{
			name: "message path",
			path: []int32{4, 0},
			want: "4.0",
		},
		{
			name: "field path",
			path: []int32{4, 0, 2, 1},
			want: "4.0.2.1",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := pathToString(tt.path)
			if got != tt.want {
				t.Errorf("pathToString(%v) = %q, want %q", tt.path, got, tt.want)
			}
		})
	}
}

func TestGetMessagePath(t *testing.T) {
	tests := []struct {
		name         string
		messageIndex int
		want         string
	}{
		{
			name:         "first message",
			messageIndex: 0,
			want:         "4.0",
		},
		{
			name:         "fifth message",
			messageIndex: 5,
			want:         "4.5",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := getMessagePath(tt.messageIndex)
			if got != tt.want {
				t.Errorf("getMessagePath(%d) = %q, want %q", tt.messageIndex, got, tt.want)
			}
		})
	}
}

func TestGetFieldPath(t *testing.T) {
	tests := []struct {
		name         string
		messageIndex int
		fieldIndex   int
		want         string
	}{
		{
			name:         "first field of first message",
			messageIndex: 0,
			fieldIndex:   0,
			want:         "4.0.2.0",
		},
		{
			name:         "third field of second message",
			messageIndex: 1,
			fieldIndex:   2,
			want:         "4.1.2.2",
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := getFieldPath(tt.messageIndex, tt.fieldIndex)
			if got != tt.want {
				t.Errorf("getFieldPath(%d, %d) = %q, want %q", tt.messageIndex, tt.fieldIndex, got, tt.want)
			}
		})
	}
}

func TestBuildCommentMap(t *testing.T) {
	tests := []struct {
		name string
		file *descriptorpb.FileDescriptorProto
		want map[string]string
	}{
		{
			name: "no source code info",
			file: &descriptorpb.FileDescriptorProto{},
			want: map[string]string{},
		},
		{
			name: "with leading comment",
			file: &descriptorpb.FileDescriptorProto{
				SourceCodeInfo: &descriptorpb.SourceCodeInfo{
					Location: []*descriptorpb.SourceCodeInfo_Location{
						{
							Path:            []int32{4, 0},
							LeadingComments: stringPtr("  This is a message comment  "),
						},
					},
				},
			},
			want: map[string]string{
				"4.0": "This is a message comment",
			},
		},
		{
			name: "with trailing comment",
			file: &descriptorpb.FileDescriptorProto{
				SourceCodeInfo: &descriptorpb.SourceCodeInfo{
					Location: []*descriptorpb.SourceCodeInfo_Location{
						{
							Path:             []int32{4, 0, 2, 0},
							TrailingComments: stringPtr("  Field comment  "),
						},
					},
				},
			},
			want: map[string]string{
				"4.0.2.0": "Field comment",
			},
		},
		{
			name: "with both leading and trailing comments",
			file: &descriptorpb.FileDescriptorProto{
				SourceCodeInfo: &descriptorpb.SourceCodeInfo{
					Location: []*descriptorpb.SourceCodeInfo_Location{
						{
							Path:             []int32{4, 0},
							LeadingComments:  stringPtr("Leading"),
							TrailingComments: stringPtr("Trailing"),
						},
					},
				},
			},
			want: map[string]string{
				"4.0": "Leading\nTrailing",
			},
		},
		{
			name: "skips empty comments",
			file: &descriptorpb.FileDescriptorProto{
				SourceCodeInfo: &descriptorpb.SourceCodeInfo{
					Location: []*descriptorpb.SourceCodeInfo_Location{
						{
							Path:            []int32{4, 0},
							LeadingComments: stringPtr("   "),
						},
					},
				},
			},
			want: map[string]string{},
		},
	}

	for _, tt := range tests {
		t.Run(tt.name, func(t *testing.T) {
			got := buildCommentMap(tt.file)
			if len(got) != len(tt.want) {
				t.Errorf("buildCommentMap() returned map with %d entries, want %d", len(got), len(tt.want))
			}
			for key, wantValue := range tt.want {
				gotValue, ok := got[key]
				if !ok {
					t.Errorf("buildCommentMap() missing key %q", key)
					continue
				}
				if gotValue != wantValue {
					t.Errorf("buildCommentMap()[%q] = %q, want %q", key, gotValue, wantValue)
				}
			}
		})
	}
}

func stringPtr(s string) *string {
	return &s
}
