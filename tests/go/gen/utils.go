package gen

import (
	"encoding/json"
	"fmt"
	"os"
	"path/filepath"

	log "github.com/sirupsen/logrus"

	"google.golang.org/protobuf/proto"
)

func WriteMessage(dir, basename string, msg proto.Message, writeJson bool) error {
	// Marshal to binary protobuf
	binaryData, err := proto.Marshal(msg)
	if err != nil {
		return fmt.Errorf("failed to marshal to binary: %w", err)
	}

	binaryPath := filepath.Join(dir, basename+".bin")
	if err := os.WriteFile(binaryPath, binaryData, 0600); err != nil {
		return fmt.Errorf("failed to write binary file %s: %w", binaryPath, err)
	}

	if writeJson {
		jsonData, err := json.MarshalIndent(msg, "", "   ")
		if err != nil {
			return fmt.Errorf("failed to marshal to JSON: %w", err)
		}
		jsonPath := filepath.Join(dir, basename+".json")
		if err := os.WriteFile(jsonPath, jsonData, 0600); err != nil {
			return fmt.Errorf("failed to write JSON file %s: %w", jsonPath, err)
		}
		log.Infof("Generated %s.bin (%d bytes) and %s.json\n", basename, len(binaryData), basename)
	} else {
		log.Infof("Generated %s.bin (%d bytes)\n", basename, len(binaryData))
	}

	return nil
}
