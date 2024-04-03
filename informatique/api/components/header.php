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

?>

    <a href="#" class="text-sm invert md:invert-0" onclick="openLanguageModal()"><svg fill="#ffffff" height="24px" width="24px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 511.708 511.708" xml:space="preserve">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <g>
                    <g>
                        <g>
                            <path d="M416.326,64.933c-23.925,0-43.39,19.465-43.39,43.39s19.465,43.39,43.39,43.39c23.925,0,43.39-19.465,43.39-43.39 S440.251,64.933,416.326,64.933z"></path>
                            <path d="M439.235,247.171h63.497c-0.833-24.42-5.12-48.423-12.878-71.55l2.786-3.94c28.637-37.376,24.489-98.807-8.878-131.463 C450.603,7.763,398.943,4.335,361.767,29.77C332.01,15.2,300.396,6.756,267.472,4.708l-7.567,7.081 c0.043,0.364,0.217,0.694,0.217,1.076v121.223c20.888-0.59,41.602-3.298,61.787-8.071c0.746,5.78,1.953,11.455,3.627,16.965 c-21.374,5.033-43.303,7.871-65.414,8.461v95.727h133.294l12.279,17.356h-24.324c-0.981,36.786-8.157,72.53-20.957,106.019 c27.153,9.823,53.109,23.153,77.104,40.248l7.472,5.71c34.538-41.533,55.929-94.329,57.899-151.977h-75.932L439.235,247.171z M416.325,249.505l-1.649-2.334l-60.885-86.051c-7.263-9.476-11.915-21.044-14.067-33.271c-0.85-4.894-1.31-9.893-1.371-14.909 c-0.269-22.563,7.48-45.438,22.684-60.312c1.484-1.458,3.055-2.786,4.625-4.096c0.738-0.607,1.449-1.215,2.265-1.848 c0.009,0,0.009-0.009,0.017-0.009c14.136-10.926,31.241-16.436,48.38-16.436c20.02,0,40.049,7.463,55.296,22.389 c27.023,26.45,30.477,78.162,7.047,108.761l-5.458,7.706l-49.1,69.406L416.325,249.505z"></path>
                            <path d="M242.767,27.109c-31.11,27.24-55.938,59.8-73.511,95.805c23.778,6.665,48.414,10.414,73.511,11.116V27.109z"></path>
                            <path d="M242.767,151.389c-27.587-0.738-54.671-4.912-80.766-12.47c-14.171,33.948-22.059,70.535-23.127,108.249h103.893V151.389 z"></path>
                            <path d="M152.429,117.644c20.324-42.591,50.124-80.696,88.003-111.382l1.979-1.848C177.066,6.74,117.995,34.041,74.493,77.101 l6.04,4.608C102.887,96.999,127.098,108.914,152.429,117.644z"></path>
                            <path d="M242.767,264.526H138.874c0.981,34.877,7.854,68.764,20.072,100.5c27.032-8.149,55.14-12.626,83.82-13.39V264.526z"></path>
                            <path d="M121.518,264.526H0c1.97,57.691,23.396,110.514,57.978,152.073l7.064-5.554c24.168-17.226,50.219-30.625,77.451-40.483 C129.684,337.066,122.498,301.312,121.518,264.526z"></path>
                            <path d="M145.379,133.532c-26.355-9.233-51.591-21.738-75.012-37.766l-7.81-5.944C25.319,132.135,2.053,186.997,0.005,247.17 h121.509C122.573,207.598,130.695,169.181,145.379,133.532z"></path>
                            <path d="M242.767,484.585V368.994c-26.364,0.746-52.207,4.825-77.078,12.149C183.427,420.273,209.496,455.557,242.767,484.585z"></path>
                            <path d="M149.127,386.584c-25.964,9.312-50.766,22.016-73.685,38.348l-5.849,4.599c43.997,46.054,105.229,75.464,173.256,77.763 l-2.239-1.718C200.448,473.042,169.485,432.195,149.127,386.584z"></path>
                            <path d="M353.78,386.572c-19.803,44.405-49.707,84.211-88.272,116.241l5.059,3.896c63.844-4.825,121.075-33.54,162.807-77.251 l-6.161-4.703C404.416,408.519,379.692,395.867,353.78,386.572z"></path>
                            <path d="M260.123,484.573c33.271-29.028,59.366-64.304,77.095-103.441c-24.862-7.316-50.714-11.394-77.095-12.14V484.573z"></path>
                            <path d="M364.019,264.526H260.126v87.109c28.698,0.764,56.815,5.242,83.829,13.381 C356.174,333.291,363.038,299.395,364.019,264.526z"></path>
                        </g>
                    </g>
                </g>
            </g>
        </svg>
    </a>
    <a href="/forum">
        <p class="text-sm">Forum</p>
    </a>
    <?php
    if ($currentUser) {
    ?>
        <a href="/mes_devis">
            <p class="text-sm" data-lang="Mes devis|My quotes">Mes devis</p>
        </a>
        <?php
        if ($currentUser->role == 'admin') {
        ?>
            <a href="/admin">
                <p class="text-sm" data-lang="Administration|Administration">Administration</p>
            </a>
        <?php
        }
        ?>
        <a href="/mes_capteurs">
            <p class="text-sm" data-lang="Mes capteurs|My sensors">Mes capteurs</p>
        </a>
        <a href="/mon_profil">
            <p class="w-32 h-9 px-2 py-2 text-center border rounded-3xl bg-white text-eventit-500">Mon compte</p>
        </a>
    <?php
    } else {
    ?>
        <a href="/devis">
            <p class="text-sm" data-lang="Faire un devis|Get a quote">Faire un devis</p>
        </a>
        <a href="/login">
            <p class="text-sm" data-lang="Se connecter|Login">Se connecter</p>
        </a>
        <a href="/create_account">
            <p class="w-32 h-9 px-2 py-2 text-center border rounded-3xl bg-white text-eventit-500" data-lang="S'inscrire|Sign up">S'inscrire</p>
        </a>
<?php
    }
    return ob_get_clean();
}
?>

<!-- La popup de sélection de langue -->
<div id="languageModal" class="language-modal" style="display:none;">
    <div class="language-modal-content">
        <span class="close" onclick="closeLanguageModal()">&times;</span>
        <p class="text-lg font-bold mb-4">Choisissez votre langue :</p>
        <a href="javascript:void(0);" onclick="translatePage('fr')" class="language-link">Français</a>
        <a href="javascript:void(0);" onclick="translatePage('en')" class="language-link">Anglais</a>
    </div>
</div>

<div id="languageMessage" class="language-message hidden">Langue choisie</div>

<script>
    function translatePage(language) {
        const elementsToTranslate = document.querySelectorAll('[data-lang]');
        elementsToTranslate.forEach(element => {
            const translations = element.getAttribute('data-lang').split('|');
            if (element.tagName.toLowerCase() === 'textarea') {
                element.placeholder = language === 'fr' ? translations[0] : translations[1];
            } else {
                element.textContent = language === 'fr' ? translations[0] : translations[1];
            }
        });
        localStorage.setItem('selectedLanguage', language);
        const previousLanguage = localStorage.getItem('selectedLanguage');
        if (language !== previousLanguage) {
            displayLanguageMessage(language);
        }
        closeLanguageModal();
    }



    function displayLanguageMessage(language) {
        const message = language === 'fr' ? "Langue choisie : Français." : "Language chosen: English.";
        const messageElement = document.getElementById("languageMessage");
        messageElement.textContent = message;
        messageElement.style.display = "block";
        setTimeout(() => {
            messageElement.style.display = "none";
        }, 3000);
    }


    function closeLanguageModal() {
        document.getElementById("languageModal").style.display = "none";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("languageModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function loadSelectedLanguage() {
        const savedLanguage = localStorage.getItem('selectedLanguage') || 'fr';
        translatePage(savedLanguage);
    }

    document.addEventListener('DOMContentLoaded', function() {
        loadSelectedLanguage();

        document.getElementById('hamburger-menu').addEventListener('click', function() {
            document.getElementById('mobile-menu-container').classList.toggle('hidden');
        });
    });
</script>

<script>
    function openLanguageModal() {
        document.getElementById("languageModal").style.display = "block";
    }

    window.onclick = function(event) {
        var modal = document.getElementById("languageModal");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>