#!/bin/bash

FILE="./.cache/tailwindcss"

if [ ! -f "$FILE" ]; then
    echo "Tailwind n'est pas téléchargé, lancement du téléchargement..."
    mkdir "./.cache"

    cd "./.cache"
    curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.1/tailwindcss-linux-x64
    mv ./tailwindcss-linux-x64 ./tailwindcss
    chmod +x ./tailwindcss
    cd "../"
fi

(cd ./src/public/ && php -S 127.0.0.1:3000) &
./.cache/tailwindcss -i ./src/css/input.css -o ./src/public/style.css -c ./tailwind.config.js --watch 

wait
