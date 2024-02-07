#!/bin/bash

cd "$(dirname "$0")"

rm -rf ./.build/*
mkdir -p .build/resources
mkdir -p .build/api/public
mkdir -p .build/api/components

cp src/components/* .build/api/components/
cp src/public/* .build/api/public/
cp src/public/resources/* .build/resources/ -r
cp vercel.json .build/ -r
cp .vercel .build/ -r

echo "Build completed successfully."
