<?php
$hostname = getenv('MYSQL_HOST');
$dbName = getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

if (getenv('VERCEL')) {
    $path = __DIR__ . "/../../cacert.pem";
} else {
    $path = __DIR__ . "/../../.cache/cacert.pem";
}

if (!file_exists($path)) {
    error_log("File does not exist: $path");
    exit(1);
}

// planetscale compatibilty (temporary)
$options = array(
    PDO::MYSQL_ATTR_SSL_CA => $path,
);

try {
    $mysql = new PDO("mysql:host=$hostname;dbname=$dbName", $username, $password, $options);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log("Connected to mysql");
} catch (PDOException $e) {
    error_log("Cannot init mysql: " . $e->getMessage());
}
