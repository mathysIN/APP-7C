<?php
require_once __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

$legal_content = markdown_to_html($websiteDataAPI->getWebsiteData()->legal_content);
$legal_content_en = markdown_to_html($websiteDataAPI->getWebsiteData()->legal_content_en);
?>

<div class="h-full flex flex-col justify-top pt-20">
    <p class="text-eventit-500 text-center font-bold text-6xl" data-lang="Mentions légales|Legal mentions">Mentions légales</p>
    <div class="mx-auto px-8 space-y-4 py-16" id="mention_legal_content"></div>
</div>

<script>
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'fr';

    const content = {
        'fr': {
            'legalContent': <?php echo json_encode($legal_content); ?>,
        },
        'en': {
            'legalContent': <?php echo json_encode($legal_content_en); ?>,
        }
    };

    const legalContent = content[savedLanguage]['legalContent'];

    document.querySelector('#mention_legal_content').innerHTML = legalContent;
</script>