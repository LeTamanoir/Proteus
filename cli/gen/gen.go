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
	w            *writer.Writer
	typeRegistry map[string]string
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

// getMapKeyValueTypes extracts key and value field types from a map entry message
func getMapKeyValueTypes(field *descriptorpb.FieldDescriptorProto, file *descriptorpb.FileDescriptorProto) (*descriptorpb.FieldDescriptorProto, *descriptorpb.FieldDescriptorProto) {
	typeName := field.GetTypeName()

	// Find the map entry message
	for _, message := range file.GetMessageType() {
		for _, nested := range message.GetNestedType() {
			if strings.HasSuffix(typeName, "."+nested.GetName()) && nested.GetOptions().GetMapEntry() {
				// Map entry messages have exactly 2 fields: key (field 1) and value (field 2)
				var keyField, valueField *descriptorpb.FieldDescriptorProto
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
	}

	return nil, nil
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
	g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception('Invalid wire type for %s');", expectedWireType, fieldName))

	if isMessage(field) {
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
		phpType := getPhpType(field)
		g.w.Line(fmt.Sprintf("$d->%s = %s::fromBytes(array_slice($bytes, $i, $_len));", fieldName, phpType))
		g.w.Line("$i = $_postIndex;")
	} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(field.GetType(), "_value")
		g.w.Line(fmt.Sprintf("$d->%s = (string) $_value;", fieldName))
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
		g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception('Invalid wire type for %s');", fieldName))
		g.w.InlineReadVarint("_len")
		g.w.Line("$_postIndex = $i + $_len;")
		g.w.Line("if ($_postIndex < 0 || $_postIndex > $l) throw new \\Exception('Invalid length');")
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
			g.w.Line(fmt.Sprintf("$d->%s[] = (string) $_value;", fieldName))
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
		g.w.Line(fmt.Sprintf("if ($i !== $_end) throw new \\Exception('Packed %s field over/under-read');", field.GetType().String()))
		g.w.Newline()

		// Unpacked format
		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = (string) $_value;", fieldName))
		} else if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
			g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value === 1;", fieldName))
		} else {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}

		g.w.Out()
		g.w.Line(fmt.Sprintf("} else throw new \\Exception('Invalid wire type for %s');", fieldName))
	} else {
		// Non-packable types
		g.w.Line(fmt.Sprintf("if ($wireType !== %d) throw new \\Exception('Invalid wire type for %s');", expectedWireType, fieldName))
		if field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_STRING ||
			field.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BYTES {
			g.inlineReadCode(field.GetType(), "_value")
			g.w.Line(fmt.Sprintf("$d->%s[] = $_value;", fieldName))
		}
	}
}

// genMapFieldCode generates code for deserializing a map field
func (g *Gen) genMapFieldCode(field *descriptorpb.FieldDescriptorProto, keyField *descriptorpb.FieldDescriptorProto, valueField *descriptorpb.FieldDescriptorProto, fieldName string) {
	g.w.Line(fmt.Sprintf("if ($wireType !== 2) throw new \\Exception('Invalid wire type for %s');", fieldName))

	g.w.InlineReadVarint("_entryLen")
	g.w.Line("$_limit = $i + $_entryLen;")

	// Initialize key and value with defaults
	keyDefault := getPhpDefaultValue(keyField)
	valueDefault := getPhpDefaultValue(valueField)

	g.w.Line(fmt.Sprintf("$_key = %s;", keyDefault))
	g.w.Line(fmt.Sprintf("$_val = %s;", valueDefault))
	g.w.Line("while ($i < $_limit) {")
	g.w.In()

	g.w.InlineReadVarint("_tag")
	g.w.Line("$_fn = $_tag >> 3;")
	g.w.Line("$_wt = $_tag & 0x7;")
	g.w.Line("switch ($_fn) {")
	g.w.In()

	// Case 1: key
	g.w.Line("case 1:")
	g.w.In()
	keyWireType := getWireType(keyField.GetType())
	g.w.Line(fmt.Sprintf("if ($_wt !== %d) throw new \\Exception('Invalid wire type for %s key');", keyWireType, fieldName))

	if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_keyValue")
		g.w.Line("$_key = $_keyValue === 1;")
	} else if keyField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(keyField.GetType(), "_keyTemp")
		g.w.Line("$_key = (string) $_keyTemp;")
	} else {
		g.inlineReadCode(keyField.GetType(), "_key")
	}
	g.w.Line("break;")
	g.w.Newline()
	g.w.Out()

	// Case 2: value
	g.w.Line("case 2:")
	g.w.In()
	valueWireType := getWireType(valueField.GetType())
	g.w.Line(fmt.Sprintf("if ($_wt !== %d) throw new \\Exception('Invalid wire type for %s value');", valueWireType, fieldName))

	if isMessage(valueField) {
		g.w.InlineReadVarint("_msgLen")
		g.w.Line("$_msgEnd = $i + $_msgLen;")
		g.w.Line("if ($_msgEnd < 0 || $_msgEnd > $l) throw new \\Exception('Invalid length');")
		valueType := getPhpType(valueField)
		g.w.Line(fmt.Sprintf("$_val = %s::fromBytes(array_slice($bytes, $i, $_msgLen));", valueType))
		g.w.Line("$i = $_msgEnd;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_UINT64 {
		g.inlineReadCode(valueField.GetType(), "_valTemp")
		g.w.Line("$_val = (string) $_valTemp;")
	} else if valueField.GetType() == descriptorpb.FieldDescriptorProto_TYPE_BOOL {
		g.inlineReadCode(descriptorpb.FieldDescriptorProto_TYPE_INT32, "_valTemp")
		g.w.Line("$_val = $_valTemp === 1;")
	} else {
		g.inlineReadCode(valueField.GetType(), "_val")
	}
	g.w.Line("break;")
	g.w.Newline()
	g.w.Out()

	// Default case
	g.w.Line("default:")
	g.w.In()
	g.w.Line("$i = \\Proteus\\skipField($i, $l, $bytes, $_wt);")
	g.w.Out()
	g.w.Out()
	g.w.Line("}")
	g.w.Out()
	g.w.Line("}")
	g.w.Line(fmt.Sprintf("$d->%s[$_key] = $_val;", fieldName))
}

// generateFromBytesMethod generates the fromBytes method for a message
func (g *Gen) genFromBytesMethod(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto) {
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

		// Check if it's a map field
		if isMapField(field, file) {
			keyField, valueField := getMapKeyValueTypes(field, file)
			if keyField != nil && valueField != nil {
				g.genMapFieldCode(field, keyField, valueField, fieldName)
			}
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
func (g *Gen) genMessage(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto) {
	g.w.Line(fmt.Sprintf("class %s", GetPhpClassName(message.GetName())))
	g.w.Line("{")
	g.w.In()

	for _, field := range message.GetField() {
		phpType := getPhpType(field)
		fieldName := field.GetName()

		// Check if this is a map field
		if isMapField(field, file) {
			keyField, valueField := getMapKeyValueTypes(field, file)
			if keyField != nil && valueField != nil {
				keyType := getPhpType(keyField)
				valueType := getPhpType(valueField)
				g.w.Comment(fmt.Sprintf("@var array<%s, %s>", keyType, valueType))
				g.w.Line(fmt.Sprintf("public array $%s = [];", fieldName))
			}
		} else if isRepeated(field) {
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

	g.genFromBytesMethod(message, file)
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

// buildTypeRegistry builds a map from proto type names to PHP FQNs from imported files
func buildTypeRegistry(file *descriptorpb.FileDescriptorProto, fileByName map[string]*descriptorpb.FileDescriptorProto) map[string]string {
	registry := make(map[string]string)

	for _, importPath := range file.GetDependency() {
		importedFile, ok := fileByName[importPath]
		if !ok {
			continue
		}

		importedNamespace := getPhpNamespace(importedFile)
		if importedNamespace == "" {
			continue
		}

		// Register all messages from the imported file
		for _, message := range importedFile.GetMessageType() {
			phpClassName := GetPhpClassName(message.GetName())
			phpFqn := importedNamespace + "\\" + phpClassName

			// Store both the simple name and the fully qualified proto name
			registry[message.GetName()] = phpFqn
			if importedFile.GetPackage() != "" {
				protoFqn := "." + importedFile.GetPackage() + "." + message.GetName()
				registry[protoFqn] = phpFqn
			}
		}
	}

	return registry
}

// collectUsedImports collects all imported types that are actually used in the file
func collectUsedImports(file *descriptorpb.FileDescriptorProto, typeRegistry map[string]string) map[string]bool {
	usedImports := make(map[string]bool)

	for _, message := range file.GetMessageType() {
		for _, field := range message.GetField() {
			if isMessage(field) {
				typeName := field.GetTypeName()

				// Check if this is an imported type
				if phpFqn, ok := typeRegistry[typeName]; ok {
					usedImports[phpFqn] = true
				}
			}
		}
	}

	return usedImports
}

// genFile generates PHP code for a proto file
func (g *Gen) genFile(file *descriptorpb.FileDescriptorProto, fileByName map[string]*descriptorpb.FileDescriptorProto) (string, error) {
	phpNamespace := getPhpNamespace(file)
	if phpNamespace == "" {
		return "", fmt.Errorf("php_namespace option is required in %s", file.GetName())
	}

	// Build type registry from imports
	typeRegistry := buildTypeRegistry(file, fileByName)

	// Store the type registry in the generator for use in type resolution
	g.typeRegistry = typeRegistry

	// Collect used imports
	usedImports := collectUsedImports(file, typeRegistry)

	g.w.Line("<?php")
	g.w.Newline()
	g.w.Docblock(fmt.Sprintf(`Auto-generated file, DO NOT EDIT!
Proto file: %s`, file.GetName()))
	g.w.Newline()
	g.w.Line("declare(strict_types=1);")
	g.w.Newline()
	g.w.Line(fmt.Sprintf("namespace %s;", phpNamespace))
	g.w.Newline()

	// Add use statements for imported types
	if len(usedImports) > 0 {
		for phpFqn := range usedImports {
			g.w.Line(fmt.Sprintf("use %s;", phpFqn))
		}
		g.w.Newline()
	}

	// Generate all messages
	for _, message := range file.GetMessageType() {
		// Skip map entry messages (they are internal representations)
		if message.GetOptions().GetMapEntry() {
			continue
		}
		g.genMessage(message, file)
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

		content, err := (&Gen{w: writer.NewWriter()}).genFile(file, fileByName)
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
