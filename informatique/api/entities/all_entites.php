<?php
require __DIR__ . "/../utils/db.php";
require_once __DIR__ . "/users.php";
require_once __DIR__ . "/tokens.php";
require_once __DIR__ . "/estimate.php";
require_once __DIR__ . "/website_data.php";
require_once __DIR__ . "/faq_question.php";
require_once __DIR__ . "/posts.php";

$tokenAPI = new AuthTokenAPI($mysql);
$userAPI = new UserAPI($mysql);
$estimateAPI = new EstimateAPI($mysql);
$websiteDataAPI = new WebsiteDataAPI($mysql);
$faqQuestionAPI = new FAQAPI($mysql);
$postsAPI = new PostAPI($mysql, $userAPI);
