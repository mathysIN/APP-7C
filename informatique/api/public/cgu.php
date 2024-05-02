<?php
require_once __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

$cgu = markdown_to_html($websiteDataAPI->getWebsiteData()->cgu_content);
$cgu_en = markdown_to_html($websiteDataAPI->getWebsiteData()->cgu_content_en);
?>

<div class="h-full flex flex-col justify-top pt-20">
    <p class="text-eventit-500 text-center font-bold text-6xl" data-lang="Conditions générales d'utilisation|Terms of Use">Conditions générales d'utilisation</p>
    <div class="mx-auto px-8 space-y-4 py-16" id="cgu_content"></div>
</div>

<script>
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'fr';

    const content = {
        'fr': {
            'cguContent': <?php echo json_encode($cgu); ?>,
        },
        'en': {
            'cguContent': <?php echo json_encode($cgu_en); ?>,
        }
    };

    const cguContent = content[savedLanguage]['cguContent'];

    document.querySelector('#cgu_content').innerHTML = cguContent;
</script>