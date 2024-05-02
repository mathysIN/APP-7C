<?php
require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";
require_once __DIR__ . "/../entities/contact_messages.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organization = ($_POST['organization']);
    $fullname = ($_POST['fullname']);
    $email = ($_POST['email']);
    $phone_number = ($_POST['phone_number']);
    $message = ($_POST['message']);

    $user_id = isset($_CURRENT_USER) ? $_CURRENT_USER->user_id : null;
    $content = "Organisation: $organization\nNom et Prénom: $fullname\nEmail: $email\nTéléphone: $phone_number\nMessage: $message";
    $contact_id = $contactAPI->createContact($organization, $email, $phone_number, $fullname, $message);

    if ($contact_id) {
        redirect("/merci_contact");
        exit();
    } else {
        redirect("/contact?msg=error_sending_contact");
        exit();
    }
}
?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl">CONTACT</p>
    <div class="max-w-md mx-auto p-6 text-center">
        <form method="post">
            <div class="mb-4">
                <label for="organization" class="block text-left pl-1 text-eventit-500" data-lang="Votre organisation|Your organization">Votre organisation</label>
                <input name="organization" type="text" id="organization" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="fullname" class="block text-left pl-1 text-eventit-500" data-lang="Nom et Prénom|First and Last name">Nom et Prénom</label>
                <input name="fullname" type="text" id="fullname" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-left pl-1 text-eventit-500">Email</label>
                <input name="email" type="email" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="phone_number" class="block text-left pl-1 text-eventit-500" data-lang="Numéro de téléphone|Phone number">Numéro de téléphone</label>
                <input name="phone_number" type="text" id="phone_number" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-left pl-1 text-eventit-500">Message</label>
                <textarea name="message" id="message" class="w-80 h-40 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500" placeholder="Un problème, une question, n'hésitez pas à nous contacter" rows="5"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500" data-lang="Envoyer ma demande !|Send my request!">Envoyer ma demande !</button>
            </div>
        </form>
    </div>
</div>