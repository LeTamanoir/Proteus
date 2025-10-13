#!/usr/bin/env bash

for file in $(ls tests/proto-suite); do
    echo "Generating $file"
    if ! php ./bin/proteus -p tests/proto-suite/$file -o tests/Proto/ --update-composer ; then
        echo "[✗] Failed to generate $file"
        exit 1
    fi
    echo "[✓] Successfully generated $file"
    echo ""
done
