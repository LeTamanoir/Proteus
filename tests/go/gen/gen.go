package gen

import (
	"math"
	"strconv"

	"github.com/LeTamanoir/Proteus/tests/generator/pb"
	"github.com/LeTamanoir/Proteus/tests/generator/pb/benchmark"

	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/proto"
)

var Generators = []struct {
	Name      string
	Gen       func() proto.Message
	WriteJson bool
}{
	{"Address", Address, true},
	{"Coordinates", Coordinates, true},
	{"Money", Money, true},
	{"Timestamp", Timestamp, true},
	{"User", User, true},
	{"Organization", Organization, true},
	{"Scalars", Scalars, true},
	{"Map", Map, true},
	{"Benchmark", Benchmark, false},
	{"Nested", Nested, true},
	{"ScalarsMin", ScalarsMin, true},
}

func Address() proto.Message {
	return &pb.Address{
		Street:  gofakeit.Street(),
		City:    gofakeit.City(),
		State:   gofakeit.StateAbr(),
		ZipCode: gofakeit.Zip(),
		Country: gofakeit.CountryAbr(),
	}
}

func Money() proto.Message {
	return &pb.Money{
		CurrencyCode: gofakeit.CurrencyLong(),
		Units:        gofakeit.Int64(),
		Nanos:        gofakeit.Int32(),
	}
}

func Timestamp() proto.Message {
	return &pb.Timestamp{
		Seconds: gofakeit.Date().Unix(),
		Nanos:   gofakeit.Int32(),
	}
}

func Coordinates() proto.Message {
	return &pb.Coordinates{
		Latitude:  gofakeit.Latitude(),
		Longitude: gofakeit.Longitude(),
	}
}

func User() proto.Message {
	return &pb.User{
		Address:     Address().(*pb.Address),
		CreatedAt:   Timestamp().(*pb.Timestamp),
		Balance:     Money().(*pb.Money),
		Coordinates: Coordinates().(*pb.Coordinates),
	}
}

func Organization() proto.Message {
	return &pb.Organization{
		Users: []*pb.User{
			User().(*pb.User),
			User().(*pb.User),
			User().(*pb.User),
			User().(*pb.User),
		},
		Emails: []string{
			gofakeit.Email(),
			gofakeit.Email(),
		},
		Ages: []int32{
			gofakeit.Int32(),
			gofakeit.Int32(),
			gofakeit.Int32(),
		},
		IsAdmin: []bool{
			gofakeit.Bool(),
			gofakeit.Bool(),
			gofakeit.Bool(),
			gofakeit.Bool(),
		},
	}
}

func Scalars() proto.Message {
	return &pb.Scalars{
		Double:   math.MaxFloat64,
		Int32:    math.MaxInt32,
		Int64:    math.MaxInt64,
		Uint32:   math.MaxUint32,
		Uint64:   math.MaxUint64,
		Sint32:   math.MaxInt32,
		Sint64:   math.MaxInt64,
		Fixed32:  math.MaxUint32,
		Fixed64:  math.MaxUint64,
		Sfixed32: math.MaxInt32,
		Sfixed64: math.MaxInt64,
		Bool:     true,
		String_:  gofakeit.Sentence(10),
		Bytes:    []byte(gofakeit.Sentence(10)),
	}
}

// don't use `0` because fields are using omitempty
func ScalarsMin() proto.Message {
	return &pb.Scalars{
		Double:   -math.MaxFloat64,
		Int32:    -math.MaxInt32,
		Int64:    -math.MaxInt64,
		Uint32:   math.MaxUint32,
		Uint64:   math.MaxUint64,
		Sint32:   -math.MaxInt32,
		Sint64:   -math.MaxInt64,
		Fixed32:  math.MaxInt32,
		Fixed64:  math.MaxUint64,
		Sfixed32: -math.MaxInt32,
		Sfixed64: -math.MaxInt64,
		Bool:     true,
		String_:  gofakeit.Sentence(10),
		Bytes:    []byte(gofakeit.Sentence(10)),
	}
}

// NOTE: we only use 1 element per field because map JSON is not ordered
func Map() proto.Message {
	return &pb.Map{
		Int32Bool: map[int32]bool{
			math.MaxInt32: gofakeit.Bool(),
		},
		Int64Bool: map[int64]bool{
			math.MaxInt64: gofakeit.Bool(),
		},
		Uint32Bool: map[uint32]bool{
			math.MaxUint32: gofakeit.Bool(),
		},
		Uint64Bool: map[uint64]bool{
			math.MaxUint64: gofakeit.Bool(),
		},
		Sint32Bool: map[int32]bool{
			math.MaxInt32: gofakeit.Bool(),
		},
		Sint64Bool: map[int64]bool{
			math.MaxInt64: gofakeit.Bool(),
		},
		Fixed32Bool: map[uint32]bool{
			math.MaxUint32: gofakeit.Bool(),
		},
		Fixed64Bool: map[uint64]bool{
			math.MaxUint64: gofakeit.Bool(),
		},
		Sfixed32Bool: map[int32]bool{
			math.MaxInt32: gofakeit.Bool(),
		},
		Sfixed64Bool: map[int64]bool{
			math.MaxInt64: gofakeit.Bool(),
		},
		StringBool: map[string]bool{
			gofakeit.Sentence(10): gofakeit.Bool(),
		},
		StringAddress: map[string]*pb.Address{
			gofakeit.Sentence(10): Address().(*pb.Address),
		},
		StringRepeated: map[string]*pb.Repeated{
			gofakeit.Sentence(10): {
				Addresses: []*pb.Address{
					Address().(*pb.Address),
					Address().(*pb.Address),
					Address().(*pb.Address),
				},
			},
		},
		StringNestedMap: map[string]*pb.NestedMap{
			gofakeit.Sentence(10): {
				StringAddress: map[string]*pb.Address{
					gofakeit.Sentence(10): Address().(*pb.Address),
				},
			},
		},
	}
}

func Benchmark() proto.Message {
	benchAddress := func() *benchmark.Address {
		return &benchmark.Address{
			Street:  gofakeit.Street(),
			City:    gofakeit.City(),
			State:   gofakeit.StateAbr(),
			ZipCode: gofakeit.Zip(),
			Country: gofakeit.CountryAbr(),
		}
	}

	mapAddresses := make(map[string]*benchmark.Address)
	for i := range 10_000 {
		mapAddresses[gofakeit.Word()+"_"+strconv.Itoa(i)] = benchAddress()
	}

	repeatedAddresses := make([]*benchmark.Address, 10_000)

	for i := range 10_000 {
		repeatedAddresses[i] = benchAddress()
	}

	return &benchmark.Bench{
		MapAddresses:      mapAddresses,
		RepeatedAddresses: repeatedAddresses,
	}
}

func Nested() proto.Message {
	return &pb.Nested{
		Data: &pb.Nested_Data{
			Value: gofakeit.Sentence(10),
			NestedData: &pb.Nested_Data_NestedData{
				Value: gofakeit.Sentence(10),
			},
		},
		MapData: map[string]*pb.Nested_Data{
			gofakeit.Sentence(10): {
				Value: gofakeit.Sentence(10),
				NestedData: &pb.Nested_Data_NestedData{
					Value: gofakeit.Sentence(10),
				},
			},
		},
		RepeatedData: []*pb.Nested_Data{
			{
				Value:      gofakeit.Sentence(10),
				NestedData: &pb.Nested_Data_NestedData{Value: gofakeit.Sentence(10)},
			},
			{
				Value:      gofakeit.Sentence(10),
				NestedData: &pb.Nested_Data_NestedData{Value: gofakeit.Sentence(10)},
			},
			{
				Value:      gofakeit.Sentence(10),
				NestedData: &pb.Nested_Data_NestedData{Value: gofakeit.Sentence(10)},
			},
		},
	}
}
