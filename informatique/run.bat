:: I legit don't know how to make a bat script

@echo off
setlocal

:: Change to the directory of the script
cd /d "%~dp0"

:: Load the env var, and start the PHP server and TailwindCSS watcher
cd api\public\
start /b php -S 127.0.0.1:3000 index.php
cd ..\..

start /b tailwindcss.exe -i .\api\css\input.css -o .\api\public\resources\style.css -c .\tailwind.config.js --watch

:: Wait for the PHP server to finish
timeout /t 1 /nobreak >nul
exit