<?php
require_once __DIR__ . "/db.php";
require_once __DIR__ . "/../entities/users.php";

$queries = [
    'Create Table Query for User' => QUERY_CREATE_TABLE_USER,
];

foreach ($queries as $queryDescription => $query) {
    try {
        $mysql->exec($query);
        throw new PDOException('');
    } catch (PDOException $e) {
        error_log("Error creating table ($queryDescription): " . $conn->error . PHP_EOL);
    }
}
