<!-- here, we thanks the user for sumbiting a estimate request and we show the id that we have in the url params-->

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl">Merci pour votre demande de devis</p>
    <div class="max-w-md mx-auto p-6 text-center">
        <p class="text-eventit-500 text-2xl">Votre demande de devis a bien été prise en compte.</p>
        <p class="text-eventit-500 text-2xl">Votre numéro de devis est le <?= $_GET['id'] ?></p>
    </div>
</div>