<?php
class contactform {
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

    public function send($data) {
        $body = "Vous avez reçu un nouveau message de votre site web :\n\n";
        foreach ($data as $key => $value) {
            $body .= ucfirst($key) . ": " . strip_tags($value) . "\n";
        }

        return mail($this->to, $this->subject, $body, implode("\r\n", $this->headers));
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form = new contactform($_POST['email']);
    if ($form->send($_POST)) {
        echo "Message envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du message.";
    }
}
?>
