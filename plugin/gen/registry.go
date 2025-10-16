package gen

import (
	"fmt"
	"slices"

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

			protoFqn := message.GetName()
			if pkg := importedFile.GetPackage(); pkg != "" {
				protoFqn = "." + pkg + "." + protoFqn
			}

			registry[protoFqn] = phpFqn
		}
	}

	return registry, nil
}

// collectUsedImports collects all imported types that are actually used in the file
func collectUsedImports(file *descriptorpb.FileDescriptorProto, typeRegistry map[string]string) []string {
	usedImports := make(map[string]bool)

	for _, message := range file.GetMessageType() {
		for _, field := range message.GetField() {
			if isMessage(field) {
				typeName := field.GetTypeName()
				if phpFqn, ok := typeRegistry[typeName]; ok {
					usedImports[phpFqn] = true
				}
			}
		}
	}

	imports := make([]string, 0, len(usedImports))
	for phpFqn := range usedImports {
		imports = append(imports, phpFqn)
	}

	slices.Sort(imports)

	return imports
}
