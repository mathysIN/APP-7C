#!/bin/bash

cd "$(dirname "$0")"

echo "Building..."

rm -rf ./.build/*
mkdir -p .build/resources
mkdir -p .build/api/public
mkdir -p .build/api/components
mkdir -p .build/api/utils

cp src/components/* .build/api/components/
cp src/utils/* .build/api/utils/
cp src/public/* .build/api/public/
cp src/public/resources/* .build/resources/ -r
cp vercel.json .build/ -r

if [ -f ".vercel" ]; then
    cp .vercel .build/ -r
fi

echo "Build completed successfully."
