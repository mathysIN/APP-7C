#!/bin/bash
set -e

cd "$(dirname "$0")"

echo "Building..."

rm -rf ./.build/*
mkdir -p .build/resources

cp api/public/resources/* .build/resources/ -r

echo "Build completed successfully."
