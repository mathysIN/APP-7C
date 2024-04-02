<header class="flex p-4 flex-row items-center w-full bg-eventit-500 shadow-md text-white">
    <a href="/">
        <h1 class="text-3xl font-bold text-white">EVENT - IT</h1>
    </a>
    <!-- Hamburger Menu Button -->
    <button id="hamburger-menu" class="block ml-auto md:hidden focus:outline-none">
        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
    </button>
    <!-- Desktop Menu -->
    <div id="desktop-menu" class="hidden ml-auto md:flex md:flex-row md:gap-7 md:items-center font-bold text-sm md:space-x-5">
        <?php echo generateMenuItems(); ?>
    </div>
</header>

<!-- Mobile Menu Container -->
<div id="mobile-menu-container" class="hidden md:hidden bg-white w-full shadow-md">
    <div id="mobile-menu" class="flex flex-col items-center font-bold text-sm space-y-3 py-4">
        <?php echo generateMenuItems(); ?>
    </div>
</div>

<?php
function generateMenuItems()
{
    extract($GLOBALS);
    require_once __DIR__ . "/../utils/global_types.php";
    ob_start();

    $currentUser = $_CURRENT_USER;
     if ($currentUser->role == 'admin') {
?>
        <a href="/mes_devis">
            <p class="text-sm">Mes devis</p>
        </a>
        <a href="/admin">
            <p class="text-sm">Administration</p>
        </a>
        <a href="/mes_capteurs">
            <p class="text-sm">Mes capteurs</p>
        </a>
        <a href="/mon_profil">
            <p class="w-32 h-9 px-2 py-2 text-center border rounded-3xl bg-white text-eventit-500">Mon compte</p>
        </a>
    <?php
    }
    elseif ($currentUser) {
    ?>
        <a href="/mes_devis">
            <p class="text-sm">Mes devis</p>
        </a>
        <a href="/mes_capteurs">
            <p class="text-sm">Mes capteurs</p>
        </a>
        <a href="/mon_profil">
            <p class="w-32 h-9 px-2 py-2 text-center border rounded-3xl bg-white text-eventit-500">Mon compte</p>
        </a>
    <?php
    } else {
    ?>
        <a href="/devis">
            <p class="text-sm">Faire un devis</p>
        </a>
        <a href="/login">
            <p class="text-sm">Se connecter</p>
        </a>
        <a href="/create_account">
            <p class="w-32 h-9 px-2 py-2 text-center border rounded-3xl bg-white text-eventit-500">S'inscrire</p>
        </a>
<?php
    }
    return ob_get_clean();
}
?>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle mobile menu visibility
        document.getElementById('hamburger-menu').addEventListener('click', function() {
            document.getElementById('mobile-menu-container').classList.toggle('hidden');
        });
    });
</script>