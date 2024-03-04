<?php

class AuthTokenModel
{
    public $token;
    public $user_id;
    public $name;
    public $created_at;
}

class AuthTokenAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function toAuthToken($row)
    {
        $authToken = new AuthTokenModel();
        $authToken->token = $row['token'];
        $authToken->user_id = $row['user_id'];
        $authToken->name = $row['name'];
        $authToken->created_at = $row['created_at'];

        return $authToken;
    }

    public function createAuthToken($user_id, $name)
    {
        $token = bin2hex(random_bytes(32));
        $created_at = date("Y-m-d H:i:s");

        $stmt = $this->pdo->prepare("INSERT INTO AuthTokens (token, user_id, name, created_at) VALUES (:token, :user_id, :name, :created_at)");
        $stmt->execute([
            'token' => $token,
            'user_id' => $user_id,
            'name' => $name,
            'created_at' => $created_at
        ]);

        return $token;
    }

    public function getAuthTokenByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM AuthTokens WHERE token = :token");
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toAuthToken($row);
    }

    public function deleteAuthToken($token)
    {
        $stmt = $this->pdo->prepare("DELETE FROM AuthTokens WHERE token = :token");
        $stmt->execute(['token' => $token]);
    }

    public function deleteAuthTokensForUser($user_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM AuthTokens WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
    }
}

const QUERY_CREATE_TABLE_AUTH_TOKEN = "CREATE TABLE IF NOT EXISTS AuthTokens (
    token VARCHAR(64) PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
