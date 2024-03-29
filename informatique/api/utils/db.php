<?php
$hostname = getenv('MYSQL_HOST');
$dbName = getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

try {
    $mysql = new PDO("mysql:host=$hostname;dbname=$dbName", $username, $password);
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_log("Connected to mysql");
} catch (PDOException $e) {
    error_log("Cannot init mysql: " . $e->getMessage());
}
