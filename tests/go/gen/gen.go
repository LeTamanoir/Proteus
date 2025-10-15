package gen

import (
	"math"
	"proteus/tester/pb"

	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/proto"
)

var Generators = []struct {
	Name string
	Gen  func() proto.Message
}{
	{"Address", Address},
	{"Coordinates", Coordinates},
	{"Money", Money},
	{"Timestamp", Timestamp},
	{"User", User},
	{"Organization", Organization},
	{"Scalars", Scalars},
}

func Address() proto.Message {
	return &pb.Address{
		Street:  gofakeit.Street(),
		City:    gofakeit.City(),
		State:   gofakeit.StateAbr(),
		ZipCode: gofakeit.Zip(),
		Country: "USA",
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
