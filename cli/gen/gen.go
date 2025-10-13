package gen

import (
	"cli/writer"
	"fmt"
	"path/filepath"
	"strings"

	"google.golang.org/protobuf/proto"
	"google.golang.org/protobuf/types/descriptorpb"
	"google.golang.org/protobuf/types/pluginpb"
)

type Gen struct {
	w *writer.Writer
}

// inlineReadCode returns inline code for reading a specific protobuf type
func (g *Gen) inlineReadCode(fieldType descriptorpb.FieldDescriptorProto_Type, varName string) {
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

// getPhpType returns the PHP type for a field
func getPhpType(field *descriptorpb.FieldDescriptorProto) string {
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
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_FIXED64:
		return "int"
	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
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
		// Extract just the message name from the type name
		typeName := field.GetTypeName()
		parts := strings.Split(typeName, ".")
		return GetPhpClassName(parts[len(parts)-1])
	default:
		return "mixed"
	}
}

// getPhpDefaultValue returns the PHP default value for a field type
func getPhpDefaultValue(field *descriptorpb.FieldDescriptorProto) string {
	switch field.GetType() {
	case descriptorpb.FieldDescriptorProto_TYPE_INT32,
		descriptorpb.FieldDescriptorProto_TYPE_UINT32,
		descriptorpb.FieldDescriptorProto_TYPE_SINT32,
		descriptorpb.FieldDescriptorProto_TYPE_INT64,
		descriptorpb.FieldDescriptorProto_TYPE_SINT64,
		descriptorpb.FieldDescriptorProto_TYPE_FIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_FIXED64,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED32,
		descriptorpb.FieldDescriptorProto_TYPE_SFIXED64:
		return "0"
	case descriptorpb.FieldDescriptorProto_TYPE_UINT64:
		return "'0'"
	case descriptorpb.FieldDescriptorProto_TYPE_FLOAT,
		descriptorpb.FieldDescriptorProto_TYPE_DOUBLE:
		return "0.0"
	case descriptorpb.FieldDescriptorProto_TYPE_BOOL:
		return "false"
	case descriptorpb.FieldDescriptorProto_TYPE_STRING:
		return "''"
	case descriptorpb.FieldDescriptorProto_TYPE_BYTES:
		return "''"
	default:
		return "[]"
	}
}

// genRegularFieldCode generates code for deserializing a regular field
func (g *Gen) genRegularFieldCode(field *descriptorpb.FieldDescriptorProto, fieldName string) {
	expectedWireType := getWireType(field.GetType())
	g.w.Line(fmt.Sprintf("if ($wireType !== %d) {", expectedWireType))
	g.w.In()
	g.w.Line(fmt.Sprintf("throw new \\Exception('Invalid wire type for %s');", fieldName))
	g.w.Out()
	g.w.Line("}")

	if isMessage(field) {
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) {")
		g.w.In()
		g.w.Line("throw new \\Exception('Invalid length');")
		g.w.Out()
		g.w.Line("}")
		phpType := getPhpType(field)
		g.w.Line(fmt.Sprintf("$d->%s = %s::fromBytes(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(field.GetType(), "_value")
		g.w.Line(fmt.Sprintf("$d->%s = bcadd($d->%s, (string) $_value);", fieldName, fieldName))
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
		g.w.Line(fmt.Sprintf("$d->%s = $_value === 1;", fieldName))
	} else {
		g.inlineReadCode(field.GetType(), "_value")
		g.w.Line(fmt.Sprintf("$d->%s = $_value;", fieldName))
	}
}

// genRepeatedFieldCode generates code for deserializing a repeated field
func (g *Gen) genRepeatedFieldCode(field *descriptorpb.FieldDescriptorProto, fieldName string) {
	// Message types are never packed
	if isMessage(field) {
		g.w.Line("if ($wireType !== 2) {")
		g.w.In()
		g.w.Line(fmt.Sprintf("throw new \\Exception('Invalid wire type for %s');", fieldName))
		g.w.Out()
		g.w.Line("}")

		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) {")
		g.w.In()
		g.w.Line("throw new \\Exception('Invalid length');")
		g.w.Out()
		g.w.Line("}")
		phpType := getPhpType(field)
		g.w.Line(fmt.Sprintf("$d->%s[] = %s::fromBytes(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
		return
	}

	expectedWireType := getWireType(field.GetType())
	packable := isPackable(field.GetType())

	if packable {
		g.w.Line("if ($wireType === 2) {")
		g.w.In()

		g.w.InlineReadVarint("_len")
		g.w.Line("$_end = $i + $_len;")
		g.w.Line("while ($i < $_end) {")
		g.w.In()

		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = new Number((string) $_value);", fieldName))
		} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
			g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
		} else {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}

		g.w.Out()
		g.w.Line("}")
		g.w.Newline()
		g.w.Line("if ($i !== $_end) {")
		g.w.In()
		g.w.Line(fmt.Sprintf("throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))
		g.w.Out()
		g.w.Line("}")
		g.w.Newline()

		// Unpacked format
		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = new Number((string) $_value);", fieldName))
		} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
			g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
		} else {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}

		g.w.Out()
		g.w.Line("} else {")
		g.w.In()
		g.w.Line(fmt.Sprintf("throw new \\Exception('Invalid wire type for %s');", fieldName))
		g.w.Out()
		g.w.Line("}")
	} else {
		// Non-packable types
		g.w.Line(fmt.Sprintf("if ($wireType !== %d) {", expectedWireType))
		g.w.In()
		g.w.Line(fmt.Sprintf("throw new \\Exception('Invalid wire type for %s');", fieldName))
		g.w.Out()
		g.w.Line("}")

		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING ||
			field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}
	}
}

// genMapFieldCode generates code for deserializing a map field
// Note: This is a simplified version - full implementation would need map detection
func (g *Gen) genMapFieldCode(w *writer.Writer, field *descriptorpb.FieldDescriptorProto, fieldName string) {
	// Maps are encoded as repeated entries with key/value fields
	// This is a placeholder for now
	g.w.Line("// Map field handling would go here")
}

// generateFromBytesMethod generates the fromBytes method for a message
func (g *Gen) genFromBytesMethod(message *descriptorpb.DescriptorProto) {
	g.w.Docblock(fmt.Sprintf(`Deserializes a %s message from binary protobuf format
@param  int[] $bytes Binary protobuf data
@return self  The deserialized message instance
@throws Exception if the data is malformed or contains invalid wire types`, message.GetName()))

	g.w.Line("public static function fromBytes(array $bytes): self")
	g.w.Line("{")
	g.w.In()

	g.w.Line("$d = new self();")
	g.w.Line("$l = count($bytes);")
	g.w.Line("$i = 0;")

	g.w.Line("while ($i < $l) {")
	g.w.In()

	g.w.InlineReadVarint("wire")
	g.w.Line("$fieldNum = $wire >> 3;")
	g.w.Line("$wireType = $wire & 0x7;")
	g.w.Line("switch ($fieldNum) {")
	g.w.In()

	for _, field := range message.GetField() {
		fieldName := field.GetName()
		g.w.Line(fmt.Sprintf("case %d:", field.GetNumber()))
		g.w.In()

		// Check if it's a map field (maps are encoded as repeated messages with key/value)
		// For now, we'll handle regular and repeated fields
		if isRepeated(field) && !isMessage(field) {
			g.genRepeatedFieldCode(field, fieldName)
		} else if isRepeated(field) {
			g.genRepeatedFieldCode(field, fieldName)
		} else {
			g.genRegularFieldCode(field, fieldName)
		}

		g.w.Line("break;")
		g.w.Newline()
		g.w.Out()
	}

	g.w.Line("default:")
	g.w.In()
	g.w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $wireType);")
	g.w.Out()
	g.w.Out()
	g.w.Line("}")
	g.w.Out()
	g.w.Line("}")
	g.w.Line("return $d;")
	g.w.Out()
	g.w.Line("}")
}

// genMessage generates code for a message type
func (g *Gen) genMessage(message *descriptorpb.DescriptorProto) {
	g.w.Line(fmt.Sprintf("class %s", GetPhpClassName(message.GetName())))
	g.w.Line("{")
	g.w.In()

	for _, field := range message.GetField() {
		phpType := getPhpType(field)
		fieldName := field.GetName()

		if isRepeated(field) {
			g.w.Comment(fmt.Sprintf("@var %s[]", phpType))
			g.w.Line(fmt.Sprintf("public array $%s = [];", fieldName))
		} else if isOptional(field) || isMessage(field) {
			g.w.Line(fmt.Sprintf("public %s|null $%s = null;", phpType, fieldName))
		} else {
			defaultValue := getPhpDefaultValue(field)
			g.w.Line(fmt.Sprintf("public %s $%s = %s;", phpType, fieldName, defaultValue))
		}

		g.w.Newline()
	}

	g.genFromBytesMethod(message)
	g.w.Out()
	g.w.Line("}")
	g.w.Newline()
}

// getPhpNamespace extracts the PHP namespace from file options
func getPhpNamespace(file *descriptorpb.FileDescriptorProto) string {
	if file.Options != nil && file.Options.PhpNamespace != nil {
		return file.Options.GetPhpNamespace()
	}
	return ""
}

// genFile generates PHP code for a proto file
func (g *Gen) genFile(file *descriptorpb.FileDescriptorProto) (string, error) {
	phpNamespace := getPhpNamespace(file)
	if phpNamespace == "" {
		return "", fmt.Errorf("php_namespace option is required in %s", file.GetName())
	}

	g.w.Line("<?php")
	g.w.Newline()
	g.w.Docblock(fmt.Sprintf(`Auto-generated file, DO NOT EDIT!
Proto file: %s`, file.GetName()))
	g.w.Newline()
	g.w.Line("declare(strict_types=1);")
	g.w.Newline()
	g.w.Line(fmt.Sprintf("namespace %s;", phpNamespace))
	g.w.Newline()

	// Generate all messages
	for _, message := range file.GetMessageType() {
		g.genMessage(message)
	}

	return g.w.GetOutput(), nil
}

func Run(req *pluginpb.CodeGeneratorRequest) (*pluginpb.CodeGeneratorResponse, error) {
	resp := &pluginpb.CodeGeneratorResponse{
		SupportedFeatures: proto.Uint64(uint64(pluginpb.CodeGeneratorResponse_FEATURE_PROTO3_OPTIONAL)),
	}

	// Build a map of all files for resolving dependencies
	fileByName := make(map[string]*descriptorpb.FileDescriptorProto)
	for _, f := range req.GetProtoFile() {
		fileByName[f.GetName()] = f
	}

	for _, fileName := range req.GetFileToGenerate() {
		file, ok := fileByName[fileName]
		if !ok {
			return nil, fmt.Errorf("file %s not found", fileName)
		}

		if file.Syntax == nil || *file.Syntax != "proto3" {
			return nil, fmt.Errorf("file %s is not a proto3 file", fileName)
		}

		content, err := (&Gen{w: writer.NewWriter()}).genFile(file)
		if err != nil {
			return nil, err
		}

		outputName := strings.TrimSuffix(fileName, ".proto") + ".php"
		outputName = filepath.Base(outputName)

		resp.File = append(resp.File, &pluginpb.CodeGeneratorResponse_File{
			Name:    proto.String(outputName),
			Content: proto.String(content),
		})
	}

	return resp, nil
}
