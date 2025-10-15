package main

import (
	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/proto"

	log "github.com/sirupsen/logrus"
)

func main() {
	// hardcoded seed for consistent test data
	gofakeit.Seed(12345)

	fixturesDir := "../fixtures"

	var generators = []func(dir string) proto.Message{
		generateAddress,
	}

	for _, gen := range generators {
		msg := gen(fixturesDir)
		if err := writeMessageWithJSON(fixturesDir, string(msg.ProtoReflect().Descriptor().Name()), msg); err != nil {
			log.Fatalf("Failed to write message: %v", err)
		}
	}

	log.Info("Successfully generated all test fixtures!")
	log.Infof("Fixtures written to: %s\n", fixturesDir)
}
