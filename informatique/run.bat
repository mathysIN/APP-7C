@echo off

set "FILE=./.cache/tailwindcss"

if not exist "%FILE%" (
    echo Tailwind is not downloaded, initiating download...
    mkdir ".\.cache"

    pushd ".\.cache"
    curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.1/tailwindcss-win-x64.exe
    popd
    echo Download complete!
)

(cd .\api\public\ && php -S 127.0.0.1:3000) ^
start "" /B .\.cache\tailwindcss-win-x64.exe -i .\api\css\input.css -o .\api\public\style.css -c .\tailwind.config.js --watch 

timeout /t -1 >nul
