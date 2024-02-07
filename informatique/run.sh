#!/bin/bash

cd "$(dirname "$0")"

OS=$(uname)

case "$OS" in
    Linux*)
        FILE="./.cache/tailwindcss-linux-x64"
        URL="https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.1/tailwindcss-linux-x64"
        ;;
    Darwin*)
        FILE="./.cache/tailwindcss-macos-x64"
        URL="https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.1/tailwindcss-macos-x64"
        ;;
    *)
        echo "Unsupported operating system: $OS"
        exit 1
        ;;
esac

if [ ! -f "$FILE" ]; then
    echo "Tailwind is not downloaded, initiating download..."
    mkdir -p "./.cache"

    curl -sL "$URL" -o "$FILE"
    chmod +x "$FILE"
    echo "Download complete!"
fi

(cd ./src/public/ && php -S 127.0.0.1:3000) &
"$FILE" -i ./src/css/input.css -o ./src/resources/style.css -c ./tailwind.config.js --watch

wait
