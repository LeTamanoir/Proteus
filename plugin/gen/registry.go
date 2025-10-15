package gen

import (
	"fmt"

	"github.com/LeTamanoir/Proteus/plugin/php"

	"google.golang.org/protobuf/types/descriptorpb"
)

// buildTypeRegistry builds a map from proto type names to PHP FQNs from imported files
func buildTypeRegistry(file *descriptorpb.FileDescriptorProto, fileByName map[string]*descriptorpb.FileDescriptorProto) (map[string]string, error) {
	registry := make(map[string]string)

	for _, importPath := range file.GetDependency() {
		importedFile, ok := fileByName[importPath]
		if !ok {
			continue
		}

		importedNamespace, ok := php.GetNamespace(importedFile)
		if !ok {
			return nil, fmt.Errorf("imported file %s is missing php_namespace option", importedFile.GetName())
		}

		// Register all messages from the imported file
		for _, message := range importedFile.GetMessageType() {
			phpClassName := php.GetClassName(message.GetName())
			phpFqn := importedNamespace + "\\" + phpClassName

			// Store both the simple name and the fully qualified proto name
			registry[message.GetName()] = phpFqn
			if importedFile.GetPackage() != "" {
				protoFqn := "." + importedFile.GetPackage() + "." + message.GetName()
				registry[protoFqn] = phpFqn
			}
		}
	}

	return registry, nil
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
