<?php
require __DIR__ . "/../utils/db.php";
require_once __DIR__ . "/users.php";
require_once __DIR__ . "/tokens.php";
require_once __DIR__ . "/estimate.php";
require_once __DIR__ . "/website_data.php";
require_once __DIR__ . "/faq_question.php";
require_once __DIR__ . "/posts.php";
require_once __DIR__ . "/sensors.php";

$sensorAPI = new SensorAPI($mysql);
$tokenAPI = new AuthTokenAPI($mysql);
$userAPI = new UserAPI($mysql);
$estimateAPI = new EstimateAPI($mysql, $sensorAPI);
$websiteDataAPI = new WebsiteDataAPI($mysql);
$faqQuestionAPI = new FAQAPI($mysql);
$postsAPI = new PostAPI($mysql, $userAPI);
