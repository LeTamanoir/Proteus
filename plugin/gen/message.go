package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/php"
	"github.com/LeTamanoir/Proteus/plugin/writer"
)

// genMessage generates code for a message type
func (g *generator) genMessage(m *message) (string, error) {
	w := writer.NewWriter()

	w.Line("<?php")
	w.Newline()
	w.Docblock(fmt.Sprintf(`Auto-generated file, DO NOT EDIT!
Proto file: %s`, m.protoFilePath))
	w.Newline()
	w.Line("declare(strict_types=1);")
	w.Newline()
	w.Line(fmt.Sprintf("namespace %s;", m.PhpNamespace()))
	w.Newline()

	// Add class docblock if comment exists
	if comment, ok := g.commentByFqn[m.protoFqn]; ok {
		w.Docblock(comment)
	}

	className := php.GetSafeName(m.msg.GetName())

	w.Line(fmt.Sprintf("class %s implements \\Proteus\\Msg", className))
	w.Line("{")
	w.In()

	for _, field := range m.msg.GetField() {
		phpType := g.getPhpType(field)
		fieldName := field.GetName()

		if comment, ok := g.commentByFqn[m.protoFqn+":"+fieldName]; ok {
			w.Docblock(comment)
		}

		switch {
		case isMapField(field, m.msg):
			keyField, valueField := getMapKeyValueTypes(field, m.msg)
			if keyField == nil || valueField == nil {
				return "", fmt.Errorf("map entry message %s not found", field.GetTypeName())
			}
			w.Comment(fmt.Sprintf("@var array<%s, %s>", g.getPhpType(keyField), g.getPhpType(valueField)))
			w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case isRepeated(field):
			w.Comment(fmt.Sprintf("@var %s[]", phpType))
			w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case isOptional(field) || isMessage(field):
			w.Line(fmt.Sprintf("public %s|null $%s = null;", phpType, fieldName))

		default:
			defaultValue := php.GetDefaultValue(field)
			w.Line(fmt.Sprintf("public %s $%s = %s;", phpType, fieldName, defaultValue))
		}

		w.Newline()
	}

	if err := g.genDecodeMethods(w, m.msg); err != nil {
		return "", err
	}

	w.Out()
	w.Line("}")
	w.Newline()

	return w.GetOutput(), nil
}
