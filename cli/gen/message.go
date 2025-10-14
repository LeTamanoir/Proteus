package gen

import (
	"fmt"

	"cli/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// genMessage generates code for a message type
func (g *gen) genMessage(message *descriptorpb.DescriptorProto, file *descriptorpb.FileDescriptorProto, messageIndex int) error {
	// Add class docblock if comment exists
	if comment, ok := g.commentMap[getMessagePath(messageIndex)]; ok {
		g.w.Docblock(comment)
	}

	g.w.Line(fmt.Sprintf("class %s", php.GetClassName(message.GetName())))
	g.w.Line("{")
	g.w.In()

	for fieldIndex, field := range message.GetField() {
		phpType := php.GetType(field)
		fieldName := field.GetName()

		if comment, ok := g.commentMap[getFieldPath(messageIndex, fieldIndex)]; ok {
			g.w.Docblock(comment)
		}

		switch {
		case isMapField(field, file):
			keyField, valueField := getMapKeyValueTypes(field, file)
			if keyField == nil || valueField == nil {
				return fmt.Errorf("map entry message %s not found", field.GetTypeName())
			}
			keyType := php.GetType(keyField)
			valueType := php.GetType(valueField)
			g.w.Comment(fmt.Sprintf("@var array<%s, %s>", keyType, valueType))
			g.w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case isRepeated(field):
			g.w.Comment(fmt.Sprintf("@var %s[]", phpType))
			g.w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case isOptional(field) || isMessage(field):
			g.w.Line(fmt.Sprintf("public %s|null $%s = null;", phpType, fieldName))

		default:
			defaultValue := php.GetDefaultValue(field)
			g.w.Line(fmt.Sprintf("public %s $%s = %s;", phpType, fieldName, defaultValue))
		}

		g.w.Newline()
	}

	if err := g.genDecodeMethod(message, file); err != nil {
		return err
	}

	g.w.Out()
	g.w.Line("}")
	g.w.Newline()

	return nil
}
