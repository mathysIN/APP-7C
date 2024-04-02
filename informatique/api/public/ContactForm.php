<?php
class ContactForm {
    private $to = 'teobernard2300@gmail.com';
    private $subject = 'Nouveau message du formulaire de contact';
    private $headers = [];

    public function __construct($fromEmail) {
        $this->headers = [
            "From: $fromEmail",
            "Reply-To: $fromEmail",
            "X-Mailer: PHP/" . phpversion()
        ];
    }

    public function validate($data) {
        // Vérifier si les champs essentiels sont présents et non vides
        $requiredFields = ['nom', 'email', 'message']; // Ajoutez ou enlevez des champs selon le formulaire
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                // Si un champ requis est vide, retournez false
                return false;
            }
        }
        // Valider le format de l'email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            // Si l'email n'est pas valide, retournez false
            return false;
        }
        // Toutes les validations sont passées
        return true;
    }

    public function send($data) {
        $body = "Vous avez reçu un nouveau message de votre site web :\n\n";
        foreach ($data as $key => $value) {
            $body .= ucfirst($key) . ": " . strip_tags($value) . "\n";
        }

        return mail($this->to, $this->subject, $body, implode("\r\n", $this->headers));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form = new ContactForm($_POST['email']);
    // Utilisez la nouvelle méthode validate avant d'envoyer
    if ($form->validate($_POST)) {
        if ($form->send($_POST)) {
            echo "Message envoyé avec succès.";
        } else {
            echo "Erreur lors de l'envoi du message.";
        }
    } else {
        echo "Erreur de validation. Assurez-vous que tous les champs sont correctement remplis.";
    }
}

?>
