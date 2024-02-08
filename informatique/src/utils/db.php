<?php
$hostname = getenv('MYSQL_HOST');
$dbName = getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

$mysqli = mysqli_init();
$mysqli->real_connect($hostname, $username, $password, $dbName);
