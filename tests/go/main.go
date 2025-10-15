package main

import (
	"proteus/tester/gen"

	"github.com/brianvoe/gofakeit/v7"

	log "github.com/sirupsen/logrus"
)

func main() {
	// hardcoded seed for consistent test data
	if err := gofakeit.Seed(12345); err != nil {
		log.Fatalf("Failed to seed gofakeit: %v", err)
	}

	fixturesDir := "../fixtures"

	for _, g := range gen.Generators {
		msg := g.Gen()
		if err := gen.WriteMessage(fixturesDir, g.Name, msg, g.WriteJson); err != nil {
			log.Fatalf("Failed to write message: %v", err)
		}
	}

	log.Info("Successfully generated all test fixtures!")
	log.Infof("Fixtures written to: %s\n", fixturesDir)
}
