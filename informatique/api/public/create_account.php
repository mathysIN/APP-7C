<?php
require_once __DIR__ . "/../utils/global_types.php";
require_once __DIR__ . "/../utils/helpers.php";

if ($_CURRENT_USER) {
    redirect('/');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once __DIR__ . "/../entities/users.php";

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];

    $createdUser = $userAPI->createUser($email, $phone_number, $first_name, $last_name, "", $password, "user");

    $createdUser = $userAPI->getUserById($createdUser);

    if ($createdUser) {
        redirect('/login?msg="user_created"');
    } else {
        redirect('/create_account?msg="cannot_create_user"');
    }
    exit();
}
?>

<div class="flex flex-col items-center justify-top">
    <div class="max-w-md mx-auto p-6">
        <img class="w-80" src="/resources/logo-event-it.webp">
        <form method="post">
            <div class="mb-4">
                <label for="email" class="block text-eventit-500">First Name</label>
                <input name="first_name" type="text" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Last Name</label>
                <input name="last_name" type="text" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Email</label>
                <input name="email" type="email" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Fontel</label>
                <input name="phone_number" type="tel" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Password</label>
                <input type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-eventit-500">Password</label>
                <input name="password" type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="text-center">
                <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500">Create account</button>
            </div>
        </form>
    </div>
</div>