#!/bin/bash

printf "\nStarting script...\n"
# Change to the directory of the script
cd "$(dirname "$0")"

# Determine the correct TailwindCSS binary to use
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

# Download Tailwind if not already downloaded
if [ ! -f "$FILE" ]; then
    echo "Tailwind is not downloaded, initiating download..."
    mkdir -p "./.cache"

    curl -sL "$URL" -o "$FILE"
    chmod +x "$FILE"
    echo "Download complete!"
fi


# Load the env var, and start the PHP server and TailwindCSS watcher
(if [ -s ".env" ]; then export $(cat .env | xargs); printf "Loaded .env file!\n"; else printf '\e[31m%s\e[0m' "WARNING: No valid .env file">&2; fi && cd ./api/public/ && php -S 127.0.0.1:3000 index.php) &
"$FILE" -i $(pwd)/api/css/input.css -o $(pwd)/api/public/resources/style.css -c tailwind.config.js --watch

# Wait for the PHP server to finish
wait
