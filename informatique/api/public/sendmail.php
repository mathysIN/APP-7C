<?php
require_once __DIR__ . "/../public/contactform.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organisation = $_POST['organisation'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $message = $_POST['message'];

    // Crée une instance de votre classe ContactForm
    $form = new contactform($email);

    // Prépare les données à envoyer
    $data = [
        'organisation' => $organisation,
        'nom' => $nom,
        'email' => $email,
        'telephone' => $telephone,
        'message' => $message
    ];

    // Appelle la méthode send
    if ($form->send($data)) {
        echo "Message envoyé avec succès. En attente ...";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>
