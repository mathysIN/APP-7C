URL="https://curl.se/ca/cacert.pem"

echo
echo "Getting certificate file"
FILE_NAME="cacert.pem"

# Check if the file already exists
if [ -f "$FILE_NAME" ]; then
    echo "$FILE_NAME already exists. Skipping download."
else
    # Download the file
    echo "Starting download of $FILE_NAME from $URL"
    curl -o "$FILE_NAME" "$URL"
    if [ $? -eq 0 ]; then
        echo "Download completed successfully."
    else
        echo "Download failed."
    fi
fi

echo