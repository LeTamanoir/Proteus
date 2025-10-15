package gen

import (
	"proteus/tester/pb"

	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/proto"
)

var Generators = []func() proto.Message{
	Address,
	Coordinates,
	Money,
	Timestamp,
	User,
	Organization,
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
