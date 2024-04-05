<footer class="w-full py-6 bg-zinc-900 md:py-12 dark:bg-gray-950/90">
    <div class="grid gap-6 px-4 ml-7 text-center md:px-6 md:grid-cols-3 md:justify-center lg:gap-10">
        <div class="flex flex-col items-left text-left space-y-3">
            <p class=" text-2xl text-white font-bold">EVENT-IT</p>
            <a href="/home" class="text-sm text-white" data-lang="À propos de nous|About Us">À propos de nous</a>
    <a href="/mentions_legales" class="text-sm text-white" data-lang="Mentions légales|Legal Notice">Mentions légales</a>
    <a href="/faq" class="text-sm text-white" data-lang="FAQ|FAQ">FAQ</a>
    <a href="/cgu" class="text-sm text-white" data-lang="CGU|CGU">CGU</a>
        </div>
        <div class="grid gap-2 pt-11 text-sm text-left leading-none md:justify-self-start md:gap-1">
            <a href="/contact"><p class="text-sm text-white font-semibold">Contact</p></a>
            <p class="text-sm text-white">123 Street, City, Country</p>
            <p class="text-sm text-white">support@example.com</p>
            <p class="text-sm text-white">123-456-7890</p>
        </div>
        <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Popup QR Code sur Instagram</title>
    <style>
    .qr-popup {
        display: none;
        position: fixed;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .qr-popup-content {
        background-color: #fefefe;
        margin: 10% auto; /* Ajustement pour centrer verticalement */
        padding: 20px;
        border: 1px solid #888;
        width: 35%; /* Agrandit la popup */
        max-width: 600px; /* Augmente la taille maximale de la popup */
    }

    .qr-popup-content img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 100%;
        max-width: 100%; /* pour S'assure que l'image n'est pas plus grande que sa largeur naturelle */
    }

    /* Style pour le lien Instagram */
    .instagram-link {
        display: block; /* Assure que le lien prend sa propre ligne */
        text-align: center; /* Centre le lien */
        margin-top: 20px; /* Espace au-dessus du lien */
        padding: 10px; /* Espace intérieur pour rendre le lien plus grand */
        background-color: #E1306C; /* Couleur de fond d'Instagram */
        color: white; /* Couleur du texte */
        border-radius: 5px; /* Bords arrondis pour l'esthétique */
        text-decoration: none; /* Pas de soulignement */
        font-weight: bold; /* Texte en gras */
    }

    .instagram-link:hover {
        background-color: #C13584; /* Changement de couleur au survol pour un effet interactif */
    }
</style>

</head>
<body>

<div class="pt-11 text-sm text-left leading-none md:justify-self-start md:gap-1">
    <p class="text-sm text-white font-semibold pb-5" data-lang="Suivez-nous|Follow Us">Suivez-nous</p>
    <div class="flex gap-x-3.5">
        <img id="instagramImg" class="w-10 cursor-pointer" src="/resources/instagram.webp" alt="Instagram">
        <img class="w-10" src="/resources/twitter.webp" alt="Twitter">
        <img class="w-10" src="/resources/youtube.webp" alt="Youtube">
    </div>
</div>

<div id="qrPopup" class="qr-popup">
    <div class="qr-popup-content">
        <img src="/resources/insta2.png" alt="QR Code">
        <!-- Lien sous l'image -->
        <a href="https://www.instagram.com/event_it_group/?igshid=Z201MWExYm1mdnFi&utm_source=qr" target="_blank" class="instagram-link">Suivez-nous sur Instagram</a>
    </div>
</div>


<script>
    // ouverture et la fermeture de la popup ptnnnn
    document.getElementById('instagramImg').addEventListener('click', function() {
        document.getElementById('qrPopup').style.display = 'block';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('qrPopup')) {
            document.getElementById('qrPopup').style.display = 'none';
        }
    }
</script>

</body>
</html>

        



    </div>
</footer>