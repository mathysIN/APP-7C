<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . "/../entities/users.php";
    $email = $_POST['email'];
    $password = $_POST['password'];

    $foundUser = $user->getUserByEmailPass($email, $password);
    if (!$foundUser) {
        echo "<script>window.location='/login?msg=invalid_credentials';</script>";
        exit();
    } else {
        echo "<script>window.location='/?msg=logged_in';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>

    <div class="h-[100vh] flex flex-col items-center justify-top pt-20">
        <div class="max-w-md mx-auto p-2">
            <img class="w-80" src="/resources/logo-event-it.webp">
            <form method="post">
                <div class="mb-4">
                    <label for="email" class="block text-eventit-500">Email</label>
                    <input name="email" type="email" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                </div>
                <div class="mb-4 pb-5">
                    <label for="password" class="block text-eventit-500">Password</label>
                    <input name="password" type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                </div>
                <div class="text-center">
                    <button type="submit" class="w-2/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500">Login</button>
                </div>
            </form>
            <div class="text-center underline">
                <a href="create_account" class="mt-4 text-center text-eventit-500">Create an account</a>
            </div>
        </div>
    </div>

</body>

</html>