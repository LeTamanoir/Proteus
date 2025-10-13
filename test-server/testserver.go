package main

import (
	"flag"
	"fmt"
	"log"
	"net"
	"strconv"

	"test-server/proto"

	"google.golang.org/grpc"
	_ "google.golang.org/grpc/encoding/gzip"
	"google.golang.org/grpc/reflection"
	encoding "google.golang.org/protobuf/proto"
)

func main() {

	test := proto.DataTypes{
		StrTest:     "test",
		IntTest:     112312315,
		BoolTest:    true,
		FloatTest:   1.012313,
		DoubleTest:  12312311.012313,
		BytesTest:   []byte("_test_bytes"),
		MapTest:     map[string]string{"test": "test", "hello": "world"},
		IntTestList: []int32{10, 20, 30},
		Uint64Test:  12345,
		// TestNewField: "test_new_field",
	}

	bin, err := encoding.Marshal(&test)
	fmt.Printf("%+v\n", bin)

	test2 := proto.DataTypes{}
	err = encoding.Unmarshal([]byte{10, 4, 116, 101, 115, 116, 16, 251, 255, 198, 53, 24, 1, 37, 121, 147, 129, 63, 41, 60, 222, 100, 224, 222, 123, 103, 65, 50, 11, 95, 116, 101, 115, 116, 95, 98, 121, 116, 101, 115, 58, 12, 10, 4, 116, 101, 115, 116, 18, 4, 116, 101, 115, 116, 58, 14, 10, 5, 104, 101, 108, 108, 111, 18, 5, 119, 111, 114, 108, 100, 66, 3, 10, 20, 30, 72, 185, 96, 82, 14, 116, 101, 115, 116, 95, 110, 101, 119, 95, 102, 105, 101, 108, 100}, &test2)
	fmt.Printf("%+v\n", test2)

	var port string
	flag.StringVar(&port, "port", "8080", "address to listen on")
	flag.Parse()

	if p, err := strconv.Atoi(port); err != nil || p == 0 {
		log.Fatalf("Invalid port: %s", port)
	}

	server := grpc.NewServer()

	proto.RegisterTestServiceServer(server, proto.NewTestService())
	reflection.Register(server)

	listener, err := net.Listen("tcp", fmt.Sprintf(":%s", port))
	if err != nil {
		log.Fatalf("Failed to listen: %v", err)
	}

	proto.Log("Listening on http://localhost:%s", port)

	if err := server.Serve(listener); err != nil {
		log.Fatalf("Failed to serve: %v", err)
	}
}
