<?php
if (isset($_SESSION["session"])) {
    // Supprimez le token de la session pour "déconnecter" l'utilisateur
    unset($_SESSION["session"]);
    
    // Vous pouvez également détruire complètement la session si vous le souhaitez
    // session_destroy();

    // Redirigez l'utilisateur vers la page de login avec un message indiquant la déconnexion réussie
    redirect('/login.php?msg=logged_out');
} else {
    // Si aucun utilisateur n'est connecté, redirigez simplement vers la page de login ou la page d'accueil
    redirect('/login.php');
}
exit();