<?php
require __DIR__ . "/../utils/db.php";
require_once __DIR__ . "/users.php";
require_once __DIR__ . "/tokens.php";

$tokenAPI = new AuthTokenAPI($mysql);
$userAPI = new UserAPI($mysql);
