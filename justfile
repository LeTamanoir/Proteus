_default:
    @just --list --unsorted

# Build the CLI
build-cli:
    cd cli && go build -o ./bin/protoc-gen-php-proteus .

# Build the CLI docker image
# TODO: see https://buf.build/docs/bsr/remote-plugins/custom-plugins/#creating-a-custom-plugin
# build-cli-image:
# docker build -t proteus-cli -f cli/Dockerfile .

