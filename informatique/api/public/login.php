<?php
require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $foundUser = $userAPI->getUserByEmailPass($email, $password);
    if (!$foundUser) {
        redirect('/login?msg=invalid_credentials');
    } else {
        $token = $tokenAPI->createAuthToken($foundUser->user_id, "login");
        $_SESSION["session"] = $token;
        redirect('/?msg=logged_in');
    }
    exit();
}
?>

<div class="flex flex-col items-center justify-top pt-20">
    <div class="max-w-md mx-auto p-2">
        <img class="w-80" src="/resources/logo-event-it.webp">
        <form method="post">
            <div class="mb-4">
                <label for="email" class="block text-eventit-500">Email</label>
                <input name="email" type="email" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4 pb-5">
                <label for="password" class="block text-eventit-500"data-lang="Mot de passe|Password">Mot de passe</label>
                <input name="password" type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="text-center">
                <button type="submit" class="w-4/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500"data-lang="Se connecter|Login">Se connecter</button>
            </div>
        </form>
        <div class="text-center underline">
            <a href="create_account" class="mt-2 text-center text-eventit-500"data-lang="Créer un compte|Create account">Créer un compte</a>
        </div>
    </div>
</div>