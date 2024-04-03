<?php
require_once __DIR__ . "/../utils/global_types.php";
require_once __DIR__ . "/../entities/all_entites.php";

if (!$_CURRENT_USER) {
    redirect('/login');
    exit();
}

// Traitement de la modification des informations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier s'il y a une photo envoyée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_name = $_FILES['photo']['name'];
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
        // Choisir un nom unique pour la photo
        $new_photo_name = uniqid() . "." . $photo_extension;
        // Déplacer la photo vers le répertoire de destination
        move_uploaded_file($photo_tmp_name, __DIR__ . "/../path/to/photo_folder/" . $new_photo_name);
        // Mettre à jour le chemin de la photo dans la base de données pour l'utilisateur courant
        $_CURRENT_USER->image_url = "/path/to/photo_folder/" . $new_photo_name;
    }

    // Mettre à jour les autres informations du profil si elles sont modifiées
    if (isset($_POST['first_name'])) {
        $_CURRENT_USER->first_name = $_POST['first_name'];
    }
    if (isset($_POST['last_name'])) {
        $_CURRENT_USER->last_name = $_POST['last_name'];
    }
    if (isset($_POST['email'])) {
        $_CURRENT_USER->email = $_POST['email'];
    }
    if (isset($_POST['phone_number'])) {
        $_CURRENT_USER->phone_number = $_POST['phone_number'];
    }

    //Mise a jour dans la base de donnée mon ami !
    $userAPI->updateUser($_CURRENT_USER);
}

?>

<div class="h-full flex flex-col justify-top pt-20 pb-96">
    <h3 class="pl-24 text-left font-bold text-eventit-500 text-6xl"data-lang="Mon profil|My profile">Mon profil</h3>
    <div class="flex flex-row gap-16 items-start pt-10 pl-16">
        <div class="flex flex-col items-center">
            <img src="/resources/pdp.webp" alt="">
            <button onclick="showLogoutPopup()" class="mt-5 px-4 py-2 bg-eventit-500 text-white font-bold rounded-lg"data-lang="Déconnexion|Disconnect">Déconnexion</button>
        </div>

        <div>
            <div class="pb-3 flex flex-row space-x-2 items-center">
                <p class="text-3xl font-bold">
                    <?php echo $_CURRENT_USER->first_name . " " . $_CURRENT_USER->last_name ?>
                </p>
                <?php
                if ($_CURRENT_USER->role == "admin") {
                ?>
                    <span class='py-[1px] px-2 w-fit bg-red-500 text-white rounded-xl text-center'data-lang="Administrateur|Director">Administrateur</span>
                <?php
                } else {
                ?>
                    <span class='py-[1px] px-2 w-fit bg-eventit-500 text-white rounded-xl text-center'data-lang="Utilisateur|User">Utilisateur</span>
                <?php
                }
                ?>
            </div>
            <p class="pb-3">Mail : <?php echo $_CURRENT_USER->email ?></p>
            <p class="pb-3">Numéro : <?php echo $_CURRENT_USER->phone_number ?></p>

            
            <!-- Le bouton et le formulaire de modification restent ici -->
            <a>
                <button id="modifyButton" class="flex w-40 h-9 px-4 py-2 items-center text-center font-bold rounded-3xl bg-eventit-200 text-eventit-500">
                    <img class="w-1/6" src="/resources/modifier.webp" alt="">
                    <p class="pl-4"data-lang="Modifier|Edit">Modifier</p>
                </button>
            </a>
            <!-- Formulaire de modification -->
            <form id="modifyForm" method="post" enctype="multipart/form-data" class="hidden">
                    <div class="mb-4">
                        <label for="first_name" class="block text-eventit-500"data-lang="Prénom|Last name">Prénom</label>
                        <input name="first_name" type="text" id="first_name" value="<?php echo $_CURRENT_USER->first_name ?>" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                    </div>
                    <div class="mb-4">
                        <label for="last_name" class="block text-eventit-500"data-lang="Nom|Name">Nom</label>
                        <input name="last_name" type="text" id="last_name" value="<?php echo $_CURRENT_USER->last_name ?>" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-eventit-500">Email</label>
                        <input name="email" type="email" id="email" value="<?php echo $_CURRENT_USER->email ?>" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                    </div>
                    <div class="mb-4">
                        <label for="phone_number" class="block text-eventit-500"data-lang="Téléphone|Phone">Téléphone</label>
                        <input name="phone_number" type="tel" id="phone_number" value="<?php echo $_CURRENT_USER->phone_number ?>" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                    </div>
                    <div class="mb-4">
                        <label for="photo" class="block text-eventit-500"data-lang="Photo de profil|Profile picture">Photo de profil</label>
                        <input name="photo" type="file" id="photo" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
                    </div>
                    <div class="text-center">
                    <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500"data-lang="Modifier|Edit">Modifier</button>
                </div>
            </form>
        </div>
    </div>

  <!-- Popup de déconnexion -->
<div id="logoutPopup" class="logout-popup">
    <div class="logout-popup-content">
        <p data-lang="Êtes-vous sûr de vouloir vous déconnecter ?|Are you sure you want to log out?">Êtes-vous sûr de vouloir vous déconnecter ?</p>
        <button onclick="window.location.href='/disconnect'" class="logout-confirm" data-lang="Oui|Yes">Oui</button>
        <button onclick="hideLogoutPopup()" class="logout-cancel" data-lang="Non|No">Non</button>
    </div>
</div>


<script>
    function showLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "block";
    }

    function hideLogoutPopup() {
        document.getElementById("logoutPopup").style.display = "none";
    }

    document.getElementById("modifyButton").addEventListener("click", function() {
        document.getElementById("modifyForm").classList.toggle("hidden");
    });
</script>