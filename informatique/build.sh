#!/bin/bash
display_error_message() { echo "Error: An error occurred while building the app."; }
trap 'display_error_message' ERR
set -e

cd "$(dirname "$0")"

echo "Checking..."

for file in "api"/**/*.php; do
    # Check if the file exists and is readable
    if [ -f "$file" ] && [ -r "$file" ]; then
        # Check if the file contains a require_once statement without __DIR__
        if grep -q "require_once\s*['\"][^'\"]\+['\"];" "$file"; then
            if grep -q "require_once\s*['\"][^'\"]*['\"];" "$file"; then
                echo "Incorrect import statement found in file: $file"
                echo "Please correct it to: require_once __DIR__ . '/<file>' to make the script work on *Vercel*;"
                exit 1  # Cancel the script
            fi
        fi
    else
        echo "Error: $file is not a readable file."
    fi
done

echo "Building..."

rm -rf ./.build/*
mkdir -p .build/resources

cp api/public/resources/* .build/resources/ -r

cd .build

sh ../cert.sh

cd ..

echo "Build completed successfully."
