<?php
require_once __DIR__ . "/../utils/global_types.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../entities/all_entites.php";

if ($_CURRENT_USER) {
    redirect('/');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    $isValid = true;

    if (empty($first_name)) {
        $isValid = false;
    }

    if (empty($last_name)) {
        $isValid = false;
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isValid = false;
    }

    if (empty($password)) {
        $isValid = false;
    }

    if (empty($phone_number) || !preg_match('/^[0-9]{10}$/', $phone_number)) {
        $isValid = false;
    }

    if ($isValid) {
        $createdUser = $userAPI->createUser($email, $phone_number, $first_name, $last_name, "", $password, "user");
        $createdUser = $userAPI->getUserById($createdUser);
    }

    if ($isValid && $createdUser) {
        redirect('/login?msg=user_created');
    } else {
        redirect('/create_account?msg=cannot_create_user');
    }
    exit();
}
?>

<div class="flex flex-col items-center justify-top">
    <div class="max-w-md mx-auto p-6">
        <img class="w-80" src="/resources/logo-event-it.webp">
        <form method="post">
            <div class="mb-4">
                <label for="text" class="block text-eventit-500" data-lang="Nom|Name">Nom</label>
                <input name="first_name" type="text" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500" data-lang="Prénom|First name">Prénom</label>
                <input name="last_name" type="text" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Email</label>
                <input name="email" type="email" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="tel" class="block text-eventit-500" data-lang="Téléphone|Phone">Téléphone</label>
                <input name="phone_number" type="tel" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500" data-lang="Mot de passe|Password">Mot de
                    passe</label>
                <input type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500" data-lang="Confirmation du mot de passe|Password confirmation">Confirmation du mot de passe</label>
                <input name="password" type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="text-center">
                <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500 button" data-lang="Créer le compte|Create account">Créer le compte</button>
            </div>
        </form>
        <div class="text-center underline">
            <a href="login" class="mt-2 text-center text-eventit-500" data-lang="Se connecter|Login">Se
                connecter</a>
        </div>
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