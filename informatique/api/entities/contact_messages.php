<?php

require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

class ContactModel
{
    public $contact_id;
    public $created_at;
    public $organization;
    public $email;
    public $phone_number;
    public $fullname;
    public $message;
}

class ContactAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function toContact($row)
    {
        $contact = new ContactModel();
        $contact->contact_id = $row['contact_id'];
        $contact->created_at = $row['created_at'];
        $contact->organization = htmlentities($row['organization'], ENT_QUOTES);
        $contact->email = htmlentities($row['email'], ENT_QUOTES);
        $contact->phone_number = htmlentities($row['phone_number'], ENT_QUOTES);
        $contact->fullname = htmlentities($row['fullname'], ENT_QUOTES);
        $contact->message = htmlentities($row['message'], ENT_QUOTES);
        return $contact;
    }

    public function createContact($organization, $email, $phone_number, $fullname, $message)
    {
        $contact_id = uniqid();
        $stmt = $this->pdo->prepare("INSERT INTO ContactMessages (contact_id, created_at, organization, email, phone_number, fullname, message) VALUES (:contact_id, NOW(), :organization, :email, :phone_number, :fullname, :message)");
        $stmt->execute([
            'contact_id' => $contact_id,
            'organization' => $organization,
            'email' => $email,
            'phone_number' => $phone_number,
            'fullname' => $fullname,
            'message' => $message
        ]);
        return $contact_id;
    }

    public function getAllContacts()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM ContactMessages");
        $stmt->execute();
        $contacts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = $this->toContact($row);
        }
        return $contacts;
    }

    public function deleteContact($contact_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM ContactMessages WHERE contact_id = :contact_id");
        $stmt->execute(['contact_id' => $contact_id]);
        return $stmt->rowCount() > 0;
    }
}

const QUERY_CREATE_TABLE_CONTACT = "CREATE TABLE IF NOT EXISTS ContactMessages (
        contact_id VARCHAR(255) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        organization VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone_number VARCHAR(20),
        fullname VARCHAR(255) NOT NULL,
        message TEXT NOT NULL
    )";

?>
