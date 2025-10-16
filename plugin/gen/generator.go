package gen

import (
	"fmt"
	"strings"

	"google.golang.org/protobuf/proto"
	"google.golang.org/protobuf/types/descriptorpb"
	"google.golang.org/protobuf/types/pluginpb"
)

type message struct {
	phpFqn   string
	protoFqn string

	msg *descriptorpb.DescriptorProto

	protoFilePath string
}

type generator struct {
	msgByFqn     map[string]*message
	fileByPath   map[string]*descriptorpb.FileDescriptorProto
	commentByFqn map[string]string
}

func (g *generator) populateRegistry(file *descriptorpb.FileDescriptorProto) error {
	opts := file.GetOptions()
	if opts == nil {
		return fmt.Errorf("file %s is missing options", file.GetName())
	}
	phpNamespace := opts.GetPhpNamespace()
	if phpNamespace == "" {
		return fmt.Errorf("file %s is missing php_namespace option", file.GetName())
	}

	for i, msg := range file.GetMessageType() {
		g.populateMsg(file, msg, phpNamespace, file.GetPackage(), i)
	}

	for _, importPath := range file.GetDependency() {
		importedFile, ok := g.fileByPath[importPath]
		if !ok {
			return fmt.Errorf("imported file %s not found", importPath)
		}

		if err := g.populateRegistry(importedFile); err != nil {
			return err
		}
	}

	return nil
}

func Run(req *pluginpb.CodeGeneratorRequest) *pluginpb.CodeGeneratorResponse {
	resp := &pluginpb.CodeGeneratorResponse{
		SupportedFeatures: proto.Uint64(uint64(pluginpb.CodeGeneratorResponse_FEATURE_PROTO3_OPTIONAL)),
	}

	gen := &generator{
		msgByFqn:     make(map[string]*message),
		commentByFqn: make(map[string]string),
		fileByPath:   make(map[string]*descriptorpb.FileDescriptorProto),
	}

	for _, file := range req.GetProtoFile() {
		gen.fileByPath[file.GetName()] = file
	}

	for _, fileName := range req.GetFileToGenerate() {
		file := gen.fileByPath[fileName]
		if file == nil {
			resp.Error = proto.String(fmt.Sprintf("file %s not found", fileName))
			return resp
		}
		gen.populateRegistry(file)
	}

	for _, e := range gen.msgByFqn {
		output, err := gen.genMessage(e)

		if err != nil {
			resp.Error = proto.String(err.Error())
			clear(resp.File)
			return resp
		}

		resp.File = append(resp.File, &pluginpb.CodeGeneratorResponse_File{
			Name:    proto.String(strings.ReplaceAll(string(e.phpFqn), "\\", "/") + ".php"),
			Content: proto.String(output),
		})
	}

	return resp
}
