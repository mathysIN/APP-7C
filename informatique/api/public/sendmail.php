<?php
require_once 'ContactForm.php'; 

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

    // Appelle la méthode send
    if ($form->send($data)) {
        // Si l'envoi réussit, vous pouvez rediriger l'utilisateur ou afficher un message de succès
        echo "Message envoyé avec succès.";
    } else {
        // Gérer l'erreur d'envoi
        echo "Erreur lors de l'envoi du message.";
    }
}
?>
