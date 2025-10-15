package main

import (
	"proteus/tester/gen"

	"github.com/brianvoe/gofakeit/v7"

	log "github.com/sirupsen/logrus"
)

func main() {
	// hardcoded seed for consistent test data
	gofakeit.Seed(12345)

	fixturesDir := "../fixtures"

	for _, g := range gen.Generators {
		msg := g()
		if err := gen.WriteMessageWithJSON(fixturesDir, string(msg.ProtoReflect().Descriptor().Name()), msg); err != nil {
			log.Fatalf("Failed to write message: %v", err)
		}
	}

	log.Info("Successfully generated all test fixtures!")
	log.Infof("Fixtures written to: %s\n", fixturesDir)
}
