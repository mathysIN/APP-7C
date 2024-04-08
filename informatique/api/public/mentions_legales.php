<?php
require_once __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

$legal_content = $websiteDataAPI->getWebsiteData()->legal_content;

?>


<div class="h-full flex flex-col justify-top pt-20">
    <p class="text-eventit-500 text-center font-bold text-6xl" data-lang="Mentions légales|Legal mentions">Mentions légales</p>
    <div class="mx-auto px-8 space-y-4 py-16"><?php echo markdown_to_html($legal_content); ?></div>
</div>