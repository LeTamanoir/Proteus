package gen

import (
	"fmt"
	"path/filepath"
	"strings"

	"github.com/LeTamanoir/Proteus/plugin/php"
	"github.com/LeTamanoir/Proteus/plugin/writer"

	"google.golang.org/protobuf/proto"
	"google.golang.org/protobuf/types/descriptorpb"
	"google.golang.org/protobuf/types/pluginpb"
)

type gen struct {
	w            *writer.Writer
	typeRegistry map[string]string
	commentMap   map[string]string
}

// genFile generates PHP code for a proto file
func (g *gen) genFile(file *descriptorpb.FileDescriptorProto, fileByName map[string]*descriptorpb.FileDescriptorProto) (string, error) {
	phpNamespace, ok := php.GetNamespace(file)
	if !ok {
		return "", fmt.Errorf("php_namespace option is required in %s", file.GetName())
	}

	typeRegistry, err := buildTypeRegistry(file, fileByName)
	if err != nil {
		return "", fmt.Errorf("buildTypeRegistry: %w", err)
	}

	g.typeRegistry = typeRegistry

	g.commentMap = buildCommentMap(file)

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
		for _, phpFqn := range usedImports {
			g.w.Line(fmt.Sprintf("use %s;", phpFqn))
		}
		g.w.Newline()
	}

	g.w.Line("if (PHP_INT_SIZE !== 8) {")
	g.w.In()
	g.w.Line("trigger_error('This message is only supported on 64-bit systems', E_USER_WARNING);")
	g.w.Out()
	g.w.Line("}")
	g.w.Newline()

	g.w.Line("if (!extension_loaded('gmp')) {")
	g.w.In()
	g.w.Line("trigger_error('The gmp extension must be loaded in order to decode this message', E_USER_WARNING);")
	g.w.Out()
	g.w.Line("}")
	g.w.Newline()

	// Generate all messages
	for messageIndex, message := range file.GetMessageType() {
		// Skip map entry messages (they are internal representations)
		if message.GetOptions().GetMapEntry() {
			continue
		}
		if err := g.genMessage(message, file, messageIndex); err != nil {
			return "", err
		}
	}

	return g.w.GetOutput(), nil
}

func Run(req *pluginpb.CodeGeneratorRequest) *pluginpb.CodeGeneratorResponse {
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
			resp.Error = proto.String(fmt.Sprintf("file %s not found", fileName))
			return resp
		}

		if file.Syntax == nil || *file.Syntax != "proto3" {
			resp.Error = proto.String(fmt.Sprintf("file %s is not a proto3 file", fileName))
			return resp
		}

		content, err := (&gen{w: writer.NewWriter()}).genFile(file, fileByName)
		if err != nil {
			resp.Error = proto.String(err.Error())
			return resp
		}

		outputName := strings.TrimSuffix(fileName, ".proto") + ".pb.php"
		outputName = filepath.Base(outputName)

		resp.File = append(resp.File, &pluginpb.CodeGeneratorResponse_File{
			Name:    proto.String(outputName),
			Content: proto.String(content),
		})
	}

	return resp
}
