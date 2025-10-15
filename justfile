_default:
    @just --list --unsorted

# Build the CLI
build:
    cd cli && go build -o ./bin/protoc-gen-php-proteus .

# Format the CLI code
fmt:
    cd cli && go fmt ./... && goimports -w .

# Static analysis and linting of the CLI
check:
    cd cli && golangci-lint run

# Run the CLI tests
test:
    cd cli && go test -v -race -cover ./...

# Build the CLI docker image
# TODO: see https://buf.build/docs/bsr/remote-plugins/custom-plugins/#creating-a-custom-plugin
# build-cli-image:
# docker build -t proteus-cli -f cli/Dockerfile .

# Generate PHP & Go classes from proto files for tests
proto-gen:
    mkdir -p ./tests/generated
    protoc --plugin=./cli/bin/protoc-gen-php-proteus --php-proteus_out=./tests/php/pb --proto_path=./tests/protos ./tests/protos/*
    protoc --go_out=./tests/go/pb --go_opt=paths=source_relative --proto_path=./tests/protos ./tests/protos/*

gen-go-mocks:
    cd tests/go && go run main.go
