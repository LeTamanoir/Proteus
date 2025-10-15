_default:
    @just --list --unsorted

# Build the protoc plugin
build:
    cd plugin && go build -o ./bin/protoc-gen-php-proteus .

# Format the plugin code
fmt:
    cd plugin && go fmt ./... && goimports -w .

# Static analysis and linting of the plugin
check:
    cd plugin && golangci-lint run

# Run the plugin tests
test:
    cd plugin && go test -v -race -cover ./...

# Build the plugin docker image
# TODO: see https://buf.build/docs/bsr/remote-plugins/custom-plugins/#creating-a-custom-plugin
# build-image:
# docker build -t proteus-plugin -f plugin/Dockerfile .

# Generate PHP & Go classes from proto files for tests
gen-mocks:
    rm -rf ./tests/php/pb/*
    rm -rf ./tests/go/pb/*
    protoc --plugin=./plugin/bin/protoc-gen-php-proteus --php-proteus_out=./tests/php/pb --proto_path=./tests/protos ./tests/protos/*
    protoc --go_out=./tests/go/pb --go_opt=paths=source_relative --proto_path=./tests/protos ./tests/protos/*
    composer dump-autoload
    rm -rf ./tests/fixtures/*
    cd tests/go && go run .
