<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $organisation = $_POST['organisation'] ?? 'Non spécifié'; // Utilisation de l'opérateur null coalescent pour les valeurs facultatives
    $fullName = $_POST['full_name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone_number'] ?? 'Non spécifié';
    $message = $_POST['message'];

    // Validez ici vos données comme nécessaire

    $to = 'teobernard2300@gmail.com'; // Remplacez par votre adresse email
    $subject = 'Nouvelle demande de contact';
    
    // Préparation de l'email
    $emailContent = "Vous avez reçu une nouvelle demande de contact :\n\n";
    $emailContent .= "Organisation: $organisation\n";
    $emailContent .= "Nom et Prénom: $fullName\n";
    $emailContent .= "Email: $email\n";
    $emailContent .= "Numéro de téléphone: $phoneNumber\n";
    $emailContent .= "Message: \n$message\n";

    // Pour envoyer un email au format HTML, le Content-type doit être défini
    $headers = "From: no-reply@votredomaine.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoi de l'email
    if(mail($to, $subject, $emailContent, $headers)) {
        echo "Votre demande a été envoyée avec succès.";
        // Redirection ou autre logique post-envoi
    } else {
        echo "Erreur lors de l'envoi de votre demande.";
        // Gérer l'erreur
    }
} else {
    // Accès non autorisé à ce script sans soumission de formulaire
    http_response_code(403);
    echo "Accès refusé.";
}
?>
