package main

import (
	"proteus/tester/pb"

	"github.com/brianvoe/gofakeit/v7"
	"google.golang.org/protobuf/proto"
)

func generateAddress(dir string) proto.Message {
	return &pb.Address{
		Street:  gofakeit.Street(),
		City:    gofakeit.City(),
		State:   gofakeit.StateAbr(),
		ZipCode: gofakeit.Zip(),
		Country: "USA",
	}
}
