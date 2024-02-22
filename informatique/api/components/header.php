<header class="flex p-4 flex-row items-center w-full bg-eventit-500 shadow-md text-white">
    <a href="/">
        <h1 class="text-3xl font-bold text-white">EVENT - IT</h1>
    </a>
    <div class="ml-auto flex flex-row items-center font-bold text-sm space-x-5">
        <?php
        if (isset($_SESSION['username'])) {
        ?>
            <a href="/login">
                <p class="text-sm">Mon compte</p>
            </a>
            <a href="/login">
                <p class="text-sm">Bruh</p>
            </a>
        <?php
        } else {
        ?>
            <a href="/login">
                <p class="text-sm">Se connecter</p>
            </a>
            <a href="/create_account">
                <p class="p-4 bg-white text-eventit-500 rounded-xl">S'inscrire</p>
            </a>
        <?php
        }
        ?>

    </div>
</header>