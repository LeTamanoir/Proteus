package main

import (
	"fmt"
	"os"
	"path/filepath"

	log "github.com/sirupsen/logrus"

	"google.golang.org/protobuf/encoding/protojson"
	"google.golang.org/protobuf/proto"
)

func writeMessageWithJSON(dir, basename string, msg proto.Message) error {
	// Marshal to binary protobuf
	binaryData, err := proto.Marshal(msg)
	if err != nil {
		return fmt.Errorf("failed to marshal to binary: %w", err)
	}

	binaryPath := filepath.Join(dir, basename+".bin")
	if err := os.WriteFile(binaryPath, binaryData, 0644); err != nil {
		return fmt.Errorf("failed to write binary file %s: %w", binaryPath, err)
	}

	jsonData, err := protojson.MarshalOptions{
		Multiline:       true,
		Indent:          "  ",
		EmitUnpopulated: true, // Include zero values
	}.Marshal(msg)

	if err != nil {
		return fmt.Errorf("failed to marshal to JSON: %w", err)
	}

	jsonPath := filepath.Join(dir, basename+".json")
	if err := os.WriteFile(jsonPath, jsonData, 0644); err != nil {
		return fmt.Errorf("failed to write JSON file %s: %w", jsonPath, err)
	}

	log.Infof("Generated %s.bin (%d bytes) and %s.json\n", basename, len(binaryData), basename)
	return nil
}
