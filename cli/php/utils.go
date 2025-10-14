package php

import (
	"strings"

	"google.golang.org/protobuf/types/descriptorpb"
)

var PHP_RESERVED_WORDS = map[string]bool{
	// from https://www.php.net/manual/en/reserved.other-reserved-words.php
	"int":      true,
	"float":    true,
	"bool":     true,
	"string":   true,
	"true":     true,
	"false":    true,
	"null":     true,
	"void":     true,
	"iterable": true,
	"object":   true,
	"mixed":    true,
	"never":    true,

	// from https://www.php.net/manual/en/reserved.classes.php
	// Predefined Classes
	"Directory":              true,
	"stdClass":               true,
	"__PHP_Incomplete_Class": true,
	"Exception":              true,
	"ErrorException":         true,
	"php_user_filter":        true,
	"Closure":                true,
	"Generator":              true,
	"ArithmeticError":        true,
	"AssertionError":         true,
	"DivisionByZeroError":    true,
	"Error":                  true,
	"Throwable":              true,
	"ParseError":             true,
	"TypeError":              true,
	"self":                   true,
	"parent":                 true,

	// from https://www.php.net/manual/en/reserved.keywords.php
	// PHP Keywords
	"__halt_compiler": true,
	"abstract":        true,
	"and":             true,
	"array":           true,
	"as":              true,
	"break":           true,
	"callable":        true,
	"case":            true,
	"catch":           true,
	"class":           true,
	"clone":           true,
	"const":           true,
	"continue":        true,
	"declare":         true,
	"default":         true,
	"die":             true,
	"do":              true,
	"echo":            true,
	"else":            true,
	"elseif":          true,
	"empty":           true,
	"enddeclare":      true,
	"endfor":          true,
	"endforeach":      true,
	"endif":           true,
	"endswitch":       true,
	"endwhile":        true,
	"eval":            true,
	"exit":            true,
	"extends":         true,
	"final":           true,
	"finally":         true,
	"fn":              true,
	"for":             true,
	"foreach":         true,
	"function":        true,
	"global":          true,
	"goto":            true,
	"if":              true,
	"implements":      true,
	"include":         true,
	"include_once":    true,
	"instanceof":      true,
	"insteadof":       true,
	"interface":       true,
	"isset":           true,
	"list":            true,
	"match":           true,
	"namespace":       true,
	"new":             true,
	"or":              true,
	"print":           true,
	"private":         true,
	"protected":       true,
	"public":          true,
	"readonly":        true,
	"require":         true,
	"require_once":    true,
	"return":          true,
	"static":          true,
	"switch":          true,
	"throw":           true,
	"trait":           true,
	"try":             true,
	"unset":           true,
	"use":             true,
	"var":             true,
	"while":           true,
	"xor":             true,
	"yield":           true,
	"yield from":      true,

	// Compile-time constants
	"__CLASS__":     true,
	"__DIR__":       true,
	"__FILE__":      true,
	"__FUNCTION__":  true,
	"__LINE__":      true,
	"__METHOD__":    true,
	"__PROPERTY__":  true,
	"__NAMESPACE__": true,
	"__TRAIT__":     true,
}

// GetClassName returns the PHP class name for a field
func GetClassName(name string) string {
	if _, ok := PHP_RESERVED_WORDS[strings.ToLower(name)]; ok {
		return GetClassName(name + "_")
	}
	return name
}

// GetType returns the PHP type for a field
func GetType(field *descriptorpb.FieldDescriptorProto) string {
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
		return GetClassName(parts[len(parts)-1])
	default:
		return "mixed"
	}
}

// GetDefaultValue returns the PHP default value for a field type
func GetDefaultValue(field *descriptorpb.FieldDescriptorProto) string {
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

// GetNamespace extracts the PHP namespace from file options
func GetNamespace(file *descriptorpb.FileDescriptorProto) (string, bool) {
	if file.Options != nil && file.Options.PhpNamespace != nil {
		return file.Options.GetPhpNamespace(), true
	}
	return "", false
}
