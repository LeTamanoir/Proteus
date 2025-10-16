package gen

import (
	"fmt"
	"strings"

	"github.com/LeTamanoir/Proteus/plugin/phpgen"
	"github.com/LeTamanoir/Proteus/plugin/protobuf"
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

	nsParts := strings.Split(m.phpFqn, "\\")
	namepsace := strings.Trim(strings.Join(nsParts[:len(nsParts)-1], "\\"), "\\")
	w.Line(fmt.Sprintf("namespace %s;", namepsace))
	w.Newline()

	// Add class docblock if comment exists
	if comment, ok := g.commentByFqn[m.protoFqn]; ok {
		w.Docblock(comment)
	}

	className := phpgen.GetSafeName(m.msg.GetName())

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
		case protobuf.IsMapField(field, m.msg):
			keyField, valueField := protobuf.GetMapKeyValueTypes(field, m.msg)
			w.Comment(fmt.Sprintf("@var array<%s, %s>", g.getPhpType(keyField), g.getPhpType(valueField)))
			w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case protobuf.IsRepeated(field):
			w.Comment(fmt.Sprintf("@var %s[]", phpType))
			w.Line(fmt.Sprintf("public array $%s = [];", fieldName))

		case protobuf.IsOptional(field) || protobuf.IsMessage(field):
			w.Line(fmt.Sprintf("public %s|null $%s = null;", phpType, fieldName))

		default:
			defaultValue := getDefaultValue(field)
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
