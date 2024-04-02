<?php

class UserModel
{
    /**
     * @var string
     */
    public $user_id;


    public $created_at;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $phone_number;

    /**
     * @var string
     */
    public $first_name;

    /**
     * @var string
     */
    public $last_name;

    /**
     * @var string
     */
    public $image_url;

    /**
     * @var string
     */
    public $password_hash;

    /**
     * @var 'admin' | 'user'
     */
    public $role;
}

class UserAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }



    private function toUser($row)
    {
        $user = new UserModel();
        $user->user_id = $row['user_id'];
        $user->created_at = $row['created_at'];
        $user->email = $row['email'];
        $user->phone_number = $row['phone_number'];
        $user->first_name = $row['first_name'];
        $user->last_name = $row['last_name'];
        $user->image_url = $row['image_url'];
        $user->password_hash = $row['password_hash'];
        $user->role = $row['role'];

        return $user;
    }

    public function getUserById($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toUser($row);
    }

    public function getUserByEmailPass($email, $password)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        if (!password_verify($password, $row['password_hash'])) {
            return null;
        }

        return $this->toUser($row);
    }

    public function getUserByToken($token)
    {
        $stmt = $this->pdo->prepare("SELECT u.* FROM Users u INNER JOIN AuthTokens a ON u.user_id = a.user_id WHERE a.token = :token");
        $stmt->execute(['token' => $token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toUser($row);
    }

    public function verifyPassword($user_id, $password)
    {
        $user = $this->getUserById($user_id);

        if (!$user) {
            return false;
        }

        return password_verify($password, $user->password_hash);
    }

    public function getUserWithCookies($cookies)
    {
        $session_token = $cookies['session'] ?? null;
        $currentUser = null;
        if ($session_token) {
            $currentUser = $this->getUserByToken($session_token);
        }
        return $currentUser;
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Users");
        $stmt->execute();
        $users = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $this->toUser($row);
        }

        return $users;
    }

    public function createUser($email, $phone_number, $first_name, $last_name, $image_url, $password, $role)
    {
        $user_id = uniqid();

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare("INSERT INTO Users (user_id, created_at, email, phone_number, first_name, last_name, image_url, password_hash, role) VALUES (:user_id, NOW(), :email, :phone_number, :first_name, :last_name, :image_url, :password_hash, :role)");
        $stmt->execute([
            'user_id' => $user_id,
            'email' => $email,
            'phone_number' => $phone_number,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'image_url' => $image_url,
            'password_hash' => $password_hash,
            'role' => $role
        ]);

        return $user_id;
    }

    public function updateUser($user)
    {
        $stmt = $this->pdo->prepare("UPDATE Users SET first_name = :first_name, last_name = :last_name, email = :email, phone_number = :phone_number, image_url = :image_url, role = :role WHERE user_id = :user_id");
        $stmt->execute([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'image_url' => $user->image_url,
            'role' => $user->role,
            'user_id' => $user->user_id
        ]);
    }
    
}

const QUERY_CREATE_TABLE_USER = "CREATE TABLE IF NOT EXISTS Users (
        user_id VARCHAR(255) PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        email VARCHAR(255) UNIQUE NOT NULL,
        phone_number VARCHAR(20),
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        image_url VARCHAR(255),
        password_hash VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user')
    )";
