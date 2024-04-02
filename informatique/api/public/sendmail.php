<?php
require_once __DIR__ . "/../public/contactform.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organisation = $_POST['organisation'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $message = $_POST['message'];

    // Crée une instance de votre classe ContactForm
    $form = new ContactForm($email);

    // Prépare les données à envoyer
    $data = [
        'organisation' => $organisation,
        'nom' => $nom,
        'email' => $email,
        'telephone' => $telephone,
        'message' => $message
    ];

    // Vérifiez les données avant l'envoi
    if ($form->validate($data)) {
        // Si les données sont valides, tentez d'envoyer l'email
        if ($form->send($data)) {
            echo "Message formaté avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } else {
        // Les données ne sont pas valides
        echo "Erreur de validation. Assurez-vous que tous les champs sont correctement remplis et que l'email est valide.";
    }
}
?>

