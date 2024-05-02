<?php
require_once __DIR__ . "/../utils/helpers.php";
$id = getSearchQuery('id');
if (!$id) {
    redirect("/404");
    exit();
}
$id = htmlentities($id, ENT_QUOTES);
?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl" data-lang="Merci pour votre demande de devis|Thank you for your quote request">Merci pour votre demande de devis</p>
    <div class="max-w-md mx-auto p-6 text-center">
        <p class="text-eventit-500 text-2xl" data-lang="Votre demande de devis a bien été prise en compte|Your quote request has been processed.">Votre demande de devis a bien été prise en compte.</p>
        <p class="text-eventit-500 text-2xl" data-lang="Votre numéro de devis est le <?php echo $id ?>|Your quotation number is <?php echo $id ?>"></p>
    </div>
</div>