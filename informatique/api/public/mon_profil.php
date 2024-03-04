<?php
require_once __DIR__ . "/../entities/all_entites.php";
$currentUser = $userAPI->getUserWithCookies($_COOKIE);
if (!$currentUser) {
    redirect('/login');
    exit();
}
?>

<div class="h-full flex flex-col justify-top pt-20 pb-96">
    <h3 class="pl-24 text-left font-bold text-eventit-500 text-6xl"> Mon profil</h3>
    <div class="flex flex-row gap-16 items-center pt-10 pl-16">
        <img src="/resources/pdp.webp" alt="">
        <div class="">
            <p class="pb-5 text-3xl font-bold"><?php echo $currentUser->first_name . " " . $currentUser->last_name ?></p>
            <p class="pb-3"><?php echo $currentUser->email ?></p>
            <p class="pb-3"><?php echo $currentUser->phone_number ?></p>
            <a>
                <section class="flex w-40 h-9 px-4 py-2 items-center text-center font-bold rounded-3xl bg-eventit-200 text-eventit-500">
                    <img class="w-1/6" src="/resources/modifier.webp" alt="">
                    <p class="pl-4">Modifier</p>
                </section>
            </a>
        </div>
    </div>
</div>