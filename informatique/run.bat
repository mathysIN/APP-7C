@echo off

set "FILE=./.cache/tailwindcss"

if not exist "%FILE%" (
    echo Tailwind is not downloaded, initiating download...
    mkdir ".\.cache"

    pushd ".\.cache"
    curl -sLO https://github.com/tailwindlabs/tailwindcss/releases/download/v3.4.1/tailwindcss-win-x64.exe
    ren tailwindcss-win-x64.exe tailwindcss.exe
    popd
    echo Download complete!
)

(cd .\src\public\ && php -S 127.0.0.1:3000) ^
start "" /B .\.cache\tailwindcss.exe -i .\src\css\input.css -o .\src\public\style.css -c .\tailwind.config.js --watch 

timeout /t -1 >nul
