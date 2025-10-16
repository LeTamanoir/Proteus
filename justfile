_default:
    @just --list --unsorted

# Build the protoc plugin
build:
    cd plugin && go build -o ./bin/protoc-gen-php-proteus .

# Format the plugin code
fmt:
    cd plugin && go fmt ./... && goimports -w .
    cd tests/go && go fmt ./... && goimports -w .

# Static analysis and linting of the plugin
check:
    cd plugin && golangci-lint run
    cd tests/go && golangci-lint run

# Run the plugin tests
test:
    cd plugin && go test -v -race -cover ./...

# Build the plugin docker image
# TODO: see https://buf.build/docs/bsr/remote-plugins/custom-plugins/#creating-a-custom-plugin
# build-image:
# docker build -t proteus-plugin -f plugin/Dockerfile .

_cleanup-mocks:
    rm -rf ./tests/php/pb/*
    rm -rf ./tests/go/pb/*

_gen-go-mocks:
    mkdir -p ./tests/go/pb/
    protoc --go_out=. ./tests/protos/*.proto

_gen-benchmark-mocks:
    protoc --php_out=. ./tests/protos/benchmark/google.proto
    protoc --plugin=./plugin/bin/protoc-gen-php-proteus --php-proteus_out=. ./tests/protos/benchmark/proteus.proto
    protoc --go_out=. ./tests/protos/benchmark/proteus.proto

_gen-php-mocks:
    protoc --plugin=./plugin/bin/protoc-gen-php-proteus --php-proteus_out=. ./tests/protos/*.proto
    
_gen-fixtures:
    rm -rf ./tests/fixtures/*
    cd tests/go && go run .

# Generate PHP & Go classes from proto files for tests
gen-mocks: _cleanup-mocks _gen-go-mocks _gen-php-mocks _gen-benchmark-mocks _gen-fixtures fmt
