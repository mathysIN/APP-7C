<?php
require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization = ($_POST['organization']);
    $fullname = ($_POST['fullname']);
    $email = ($_POST['email']);
    $phone_number = ($_POST['phone_number']);
    $num_rooms = ($_POST['rooms']);
    $area_size = ($_POST['squareMeters']);
    $message = ($_POST['message']);

    $user_id = isset($_CURRENT_USER) ? $_CURRENT_USER->user_id : null;
    $content = "Organisation: $organization\n fullname: $fullname\nEmail: $email\nTéléphone: $phone_number\nNombre de salle/endroit: $num_rooms\nNombre de m2: $area_size\nMessage: $message";
    $estimate_id = $estimateAPI->createEstimate($user_id, "", 0, false, $content);

    if ($estimate_id) {
        redirect("/merci?id=$estimate_id");
        exit();
    } else {
        redirect("/devis?msg=error_sending_estimate");
        exit();
    }
}
?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl" data-lang="Faire un devis|Get a quote">Faire un devis</p>
    <div class="max-w-md mx-auto p-6 text-center">
        <form method="post">
            <div class="mb-4">
                <label for="organization" class="block text-left pl-1 text-eventit-500" data-lang="Votre organisation|Your organization">Votre organisation</label>
                <input name="organization" type="text" id="organization" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="fullname" class="block text-left pl-1 text-eventit-500" data-lang="Nom et Prénom|First and last name">Nom et Prénom</label>
                <input name="fullname" type="text" id="fullname" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-left pl-1 text-eventit-500">Email</label>
                <input name="email" type="email" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-left pl-1 text-eventit-500" data-lang="Numéro de téléphone|Phone number">Numéro de téléphone</label>
                <input name="phone_number" type="text" id="phone" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="rooms" class="block text-left pl-1 text-eventit-500" data-lang="Nombre de salle/endroit|Number of rooms/locations">Nombre de salle/endroit</label>
                <input class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500" type="number" id="rooms" name="rooms" min="1" max="100">
            </div>
            <div class="mb-4">
                <label for="squareMeters" class="block text-left pl-1 text-eventit-500" data-lang="Nombre de m2|Number of m2">Nombre de m2</label>
                <input class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500" type="number" id="squareMeters" name="squareMeters" min="1" max="100">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-left pl-1 text-eventit-500">Message</label>
                <textarea name="message" id="message" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="px-4 py-2 bg-eventit-500 text-white rounded-full focus:outline-none button" data-lang="Envoyer|Send">Envoyer</button>
            </div>
        </form>
    </div>
</div>


<style>
    .button {
        border: none;
        cursor: pointer;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .button::before {
        content: "";
        z-index: -2;
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background-color: #317577;
        transition: left 0.3s ease;
    }

    .button:hover::before {
        left: 0;
    }
</style>