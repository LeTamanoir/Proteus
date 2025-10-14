package gen

import (
	"fmt"
	"strings"

	"google.golang.org/protobuf/types/descriptorpb"
)

// pathToString converts a path array to a string key for the comment map
func pathToString(path []int32) string {
	parts := make([]string, len(path))
	for i, p := range path {
		parts[i] = fmt.Sprintf("%d", p)
	}
	return strings.Join(parts, ".")
}

// buildCommentMap builds a map from element paths to their comments
func buildCommentMap(file *descriptorpb.FileDescriptorProto) map[string]string {
	commentMap := make(map[string]string)

	if file.SourceCodeInfo == nil {
		return commentMap
	}

	for _, loc := range file.SourceCodeInfo.GetLocation() {
		if loc.Path == nil {
			continue
		}

		pathKey := pathToString(loc.Path)

		// Combine leading and trailing comments
		var comment string
		if loc.LeadingComments != nil {
			comment = strings.TrimSpace(loc.GetLeadingComments())
		}
		if loc.TrailingComments != nil {
			trailing := strings.TrimSpace(loc.GetTrailingComments())
			if trailing != "" {
				if comment != "" {
					comment += "\n" + trailing
				} else {
					comment = trailing
				}
			}
		}

		if comment != "" {
			commentMap[pathKey] = comment
		}
	}

	return commentMap
}

// getMessagePath returns the path for a message
func getMessagePath(messageIndex int) string {
	// Field 4 in FileDescriptorProto is message_type
	return fmt.Sprintf("4.%d", messageIndex)
}

// getFieldPath returns the path for a field within a message
func getFieldPath(messageIndex, fieldIndex int) string {
	// Field 4 in FileDescriptorProto is message_type
	// Field 2 in DescriptorProto is field
	return fmt.Sprintf("4.%d.2.%d", messageIndex, fieldIndex)
}
