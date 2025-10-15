package main

import (
	"fmt"
	"math"
	"os"
	"path/filepath"

	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/encoding/protojson"
	"google.golang.org/protobuf/proto"

	pb "proteus/tester/pb"
)

func main() {
	// Set random seed for consistent test data
	gofakeit.Seed(12345)

	// Create fixtures directory
	fixturesDir := "../fixtures"
	if err := os.MkdirAll(fixturesDir, 0755); err != nil {
		panic(fmt.Sprintf("Failed to create fixtures directory: %v", err))
	}

	// Generate test data
	if err := generateScalarTypes(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate scalar types: %v", err))
	}

	if err := generateRepeatedFields(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate repeated fields: %v", err))
	}

	if err := generateMapFields(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate map fields: %v", err))
	}

	if err := generateNestedMessages(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate nested messages: %v", err))
	}

	if err := generateOptionalFields(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate optional fields: %v", err))
	}

	if err := generateEdgeCases(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate edge cases: %v", err))
	}

	if err := generatePerson(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate person: %v", err))
	}

	if err := generateOrder(fixturesDir); err != nil {
		panic(fmt.Sprintf("Failed to generate order: %v", err))
	}

	fmt.Println("✅ Successfully generated all test fixtures!")
	fmt.Printf("📁 Fixtures written to: %s\n", fixturesDir)
	fmt.Println("📋 Each fixture has a corresponding .json file for validation")
}

func generateScalarTypes(dir string) error {
	msg := &pb.AllScalarTypes{
		Int32Field:    gofakeit.Int32(),
		Int64Field:    gofakeit.Int64(),
		Uint32Field:   uint32(gofakeit.Uint32()),
		Uint64Field:   uint64(gofakeit.Uint64()),
		Sint32Field:   gofakeit.Int32(),
		Sint64Field:   gofakeit.Int64(),
		Fixed32Field:  uint32(gofakeit.Uint32()),
		Fixed64Field:  uint64(gofakeit.Uint64()),
		Sfixed32Field: gofakeit.Int32(),
		Sfixed64Field: gofakeit.Int64(),
		FloatField:    gofakeit.Float32(),
		DoubleField:   gofakeit.Float64(),
		BoolField:     gofakeit.Bool(),
		StringField:   gofakeit.Sentence(5),
		BytesField:    []byte(gofakeit.LetterN(20)),
	}

	return writeMessageWithJSON(dir, "scalar_types", msg)
}

func generateRepeatedFields(dir string) error {
	msg := &pb.AllRepeatedTypes{
		Int32List:    []int32{1, 2, 3, -1, -2},
		Int64List:    []int64{100, 200, 300, -100, -200},
		Uint32List:   []uint32{10, 20, 30, 40, 50},
		Uint64List:   []uint64{1000, 2000, 3000},
		Sint32List:   []int32{-1, -2, -3, 1, 2},
		Sint64List:   []int64{-100, -200, 100, 200},
		Fixed32List:  []uint32{100, 200, 300},
		Fixed64List:  []uint64{1000, 2000, 3000},
		Sfixed32List: []int32{-10, -20, 10, 20},
		Sfixed64List: []int64{-100, -200, 100, 200},
		FloatList:    []float32{1.1, 2.2, 3.3, -1.1, -2.2},
		DoubleList:   []float64{100.1, 200.2, 300.3},
		BoolList:     []bool{true, false, true, false},
		StringList:   []string{"alpha", "beta", "gamma", "delta"},
		BytesList:    [][]byte{[]byte("bytes1"), []byte("bytes2"), []byte("bytes3")},
		AddressList: []*pb.Address{
			{
				Street:  gofakeit.Street(),
				City:    gofakeit.City(),
				State:   gofakeit.StateAbr(),
				ZipCode: gofakeit.Zip(),
				Country: gofakeit.Country(),
			},
			{
				Street:  gofakeit.Street(),
				City:    gofakeit.City(),
				State:   gofakeit.StateAbr(),
				ZipCode: gofakeit.Zip(),
				Country: gofakeit.Country(),
			},
		},
	}

	return writeMessageWithJSON(dir, "repeated_fields", msg)
}

func generateMapFields(dir string) error {
	msg := &pb.MapInt32Keys{
		Int32ToString: map[int32]string{
			1: "one",
			2: "two",
			3: "three",
		},
		Int32ToInt32: map[int32]int32{
			10: 100,
			20: 200,
			30: 300,
		},
		Int32ToMessage: map[int32]*pb.Money{
			1: {CurrencyCode: "USD", Units: 100, Nanos: 500000000},
			2: {CurrencyCode: "EUR", Units: 200, Nanos: 750000000},
		},
	}

	return writeMessageWithJSON(dir, "map_fields", msg)
}

func generateNestedMessages(dir string) error {
	msg := &pb.NestedStructure{
		RootName: "root",
		Child: &pb.Level1{
			Name: "level1",
			Child: &pb.Level2{
				Name: "level2",
				Child: &pb.Level3{
					Value: "level3_value",
					Depth: 3,
				},
				Children: []*pb.Level3{
					{Value: "child1", Depth: 3},
					{Value: "child2", Depth: 3},
				},
			},
			ChildMap: map[string]*pb.Level2{
				"key1": {
					Name: "mapped_level2",
					Child: &pb.Level3{
						Value: "mapped_value",
						Depth: 3,
					},
				},
			},
		},
		Children: []*pb.Level1{
			{Name: "sibling1"},
			{Name: "sibling2"},
		},
	}

	return writeMessageWithJSON(dir, "nested_messages", msg)
}

func generateOptionalFields(dir string) error {
	optInt32 := int32(42)
	optString := "optional_value"
	optBool := true

	msg := &pb.OptionalFieldsTest{
		RegularInt32:   100,
		OptionalInt32:  &optInt32,
		OptionalString: &optString,
		OptionalBool:   &optBool,
		OptionalDouble: nil, // Not set
		OptionalMessage: &pb.Address{
			Street:  gofakeit.Street(),
			City:    gofakeit.City(),
			State:   gofakeit.StateAbr(),
			ZipCode: gofakeit.Zip(),
			Country: gofakeit.Country(),
		},
	}

	return writeMessageWithJSON(dir, "optional_fields", msg)
}

func generateEdgeCases(dir string) error {
	msg := &pb.EdgeCases{
		ZeroInt32:        0,
		EmptyString:      "",
		EmptyBytes:       []byte{},
		NegativeSint32:   -42,
		NegativeSint64:   -9223372036854775807,
		MaxInt32:         math.MaxInt32,
		MaxInt64:         math.MaxInt64,
		MaxUint32:        math.MaxUint32,
		MaxUint64:        math.MaxUint64,
		MinInt32:         math.MinInt32,
		MinInt64:         math.MinInt64,
		FloatZero:        0.0,
		FloatInfinity:    float32(math.Inf(1)),
		FloatNegInfinity: float32(math.Inf(-1)),
		DoubleMax:        math.MaxFloat64,
		DoubleMin:        math.SmallestNonzeroFloat64,
		UnicodeString:    "Hello 世界 🌍 🚀",
		MultilineString:  "Line 1\nLine 2\nLine 3",
		LargeBytes:       make([]byte, 1024), // 1KB
	}

	// Fill large bytes with pattern
	for i := range msg.LargeBytes {
		msg.LargeBytes[i] = byte(i % 256)
	}

	return writeMessageWithJSON(dir, "edge_cases", msg)
}

func generatePerson(dir string) error {
	msg := &pb.Person{
		Name: gofakeit.Name(),
		Age:  int32(gofakeit.IntRange(18, 80)),
		HomeAddress: &pb.Address{
			Street:  gofakeit.Street(),
			City:    gofakeit.City(),
			State:   gofakeit.StateAbr(),
			ZipCode: gofakeit.Zip(),
			Country: "USA",
		},
		WorkAddress: &pb.Address{
			Street:  gofakeit.Street(),
			City:    gofakeit.City(),
			State:   gofakeit.StateAbr(),
			ZipCode: gofakeit.Zip(),
			Country: "USA",
		},
		Accounts: []*pb.Money{
			{CurrencyCode: "USD", Units: 1000, Nanos: 500000000},
			{CurrencyCode: "EUR", Units: 500, Nanos: 250000000},
		},
		CreatedAt: &pb.Timestamp{
			Seconds: 1704067200, // 2024-01-01 00:00:00 UTC
			Nanos:   0,
		},
		Location: &pb.Coordinates{
			Latitude:  gofakeit.Latitude(),
			Longitude: gofakeit.Longitude(),
		},
	}

	return writeMessageWithJSON(dir, "person", msg)
}

func generateOrder(dir string) error {
	msg := &pb.Order{
		OrderId:    gofakeit.UUID(),
		CustomerId: gofakeit.UUID(),
		Status:     2, // 2 = confirmed status
		CreatedAt: &pb.Timestamp{
			Seconds: 1704067200,
			Nanos:   0,
		},
		Items: []*pb.OrderItem{
			{
				ProductId:   gofakeit.UUID(),
				ProductName: gofakeit.ProductName(),
				Quantity:    2,
				UnitPrice:   &pb.Money{CurrencyCode: "USD", Units: 29, Nanos: 990000000},
				TotalPrice:  &pb.Money{CurrencyCode: "USD", Units: 59, Nanos: 980000000},
				Attributes: map[string]string{
					"color": "blue",
					"size":  "M",
				},
			},
		},
		ShippingAddress: &pb.Address{
			Street:  gofakeit.Street(),
			City:    gofakeit.City(),
			State:   gofakeit.StateAbr(),
			ZipCode: gofakeit.Zip(),
			Country: "USA",
		},
		Subtotal:     &pb.Money{CurrencyCode: "USD", Units: 59, Nanos: 980000000},
		Tax:          &pb.Money{CurrencyCode: "USD", Units: 5, Nanos: 400000000},
		ShippingCost: &pb.Money{CurrencyCode: "USD", Units: 9, Nanos: 990000000},
		Total:        &pb.Money{CurrencyCode: "USD", Units: 75, Nanos: 370000000},
		Metadata: map[string]string{
			"source":  "web",
			"channel": "direct",
		},
		Notes: "Please leave at door",
	}

	return writeMessageWithJSON(dir, "order", msg)
}

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

	// Marshal to JSON for test validation
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

	fmt.Printf("✓ Generated %s.bin (%d bytes) and %s.json\n", basename, len(binaryData), basename)
	return nil
}
