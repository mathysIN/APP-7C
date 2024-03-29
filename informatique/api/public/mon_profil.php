
s<div class="h-full flex flex-col justify-top pt-20 pb-96">
    <h3 class="pl-24 text-left font-bold text-eventit-500 text-6xl">Mon profil</h3>
    <div class="flex flex-row gap-16 items-center pt-10 pl-16">
        <img src="/resources/pdp.webp" alt="">
        <div class="">
            <div class="pb-3 flex flex-row space-x-2 items-center">
                <p class="text-3xl font-bold flex flex-row">
                    <?php echo htmlspecialchars($_CURRENT_USER->first_name) . " " . htmlspecialchars($_CURRENT_USER->last_name); ?>
                </p>
                <?php
                if ($_CURRENT_USER->role == "admin") {
                ?>
                    <span class='py-[1px] px-2 w-fit bg-red-500 text-white rounded-xl text-center'>Administrateur</span>
                <?php
                } else {
                ?>
                    <span class='py-[1px] px-2 w-fit bg-eventit-500 text-white rounded-xl text-center'>Utilisateur</span>
                <?php
                }
                ?>
            </div>
            <p class="pb-3">Mail : <?php echo htmlspecialchars($_CURRENT_USER->email); ?></p>
            <p class="pb-3">Téléphone : <?php echo htmlspecialchars($_CURRENT_USER->phone_number); ?></p>
            <a href="/modifier-profile.php">
                <section class="flex w-40 h-9 px-4 py-2 items-center text-center font-bold rounded-3xl bg-eventit-200 text-eventit-500">
                    <img class="w-1/6" src="/resources/modifier.webp" alt="">
                    <p class="pl-4">Modifier</p>
                </section>
            </a>
        </div>
    </div>
    <div class="pl-16 pt-5">
    <button onclick="showLogoutPopup()" class="inline-block px-4 py-2 bg-eventit-500 text-white font-bold rounded-lg">Déconnexion</button>
</div>

<!-- Popup de déconnexion -->
<div id="logoutPopup" class="logout-popup">
    <div class="logout-popup-content">
        <p>Êtes-vous sûr de vouloir vous déconnecter ?</p>
        <button onclick="window.location.href='/disconnect'" class="logout-confirm">Oui</button>
        <button onclick="hideLogoutPopup()" class="logout-cancel">Non</button>
    </div>
</div>

<script>
        function showLogoutPopup() {
            document.getElementById("logoutPopup").style.display = "block";
        }

        function hideLogoutPopup() {
            document.getElementById("logoutPopup").style.display = "none";
        }
    </script>
</body>
</html>


