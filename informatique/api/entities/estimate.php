<?php

class Estimate
{
    public $estimate_id;
    public $user_id;
    public $created_at;
    public $name;
    public $price_amount;
    public $is_payed;
    public $content;

    /**
     * @param UserModel $user
     */
    public function hasReadAccess($user)
    {
        return $this->user_id === $user->user_id || $user->role === 'admin';
    }
}

class EstimateAPI
{
    private $pdo;

    /**
     * @var SensorAPI
     */
    private $sensorAPI;

    public function __construct($pdo, $sensorAPI)
    {
        $this->pdo = $pdo;
        $this->sensorAPI = $sensorAPI;
    }

    public function toEstimate($row)
    {
        $estimate = new Estimate();
        $estimate->estimate_id = $row['estimate_id'];
        $estimate->user_id = $row['user_id'];
        $estimate->created_at = $row['created_at'];
        $estimate->name = $row['name'];
        $estimate->price_amount = $row['price_amount'];
        $estimate->is_payed = (bool) $row['is_payed'];
        $estimate->content = $row['content'];

        return $estimate;
    }

    public function getEstimateById($estimate_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Estimate WHERE estimate_id = :estimate_id");
        $stmt->execute(['estimate_id' => $estimate_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toEstimate($row);
    }

    public function getEstimatesByUser($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Estimate WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $estimates = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estimates[] = $this->toEstimate($row);
        }

        return $estimates;
    }

    public function createEstimate($user_id, $name, $price_amount, $is_payed, $content)
    {
        $estimate_id = uniqid();
        $created_at = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO Estimate (estimate_id, user_id, created_at, name, price_amount, is_payed, content) VALUES (:estimate_id, :user_id, :created_at, :name, :price_amount, :is_payed, :content)");
        $stmt->execute([
            'estimate_id' => $estimate_id,
            'user_id' => $user_id,
            'created_at' => $created_at,
            'name' => $name,
            'price_amount' => $price_amount,
            'is_payed' => $is_payed ? 1 : 0,
            'content' => $content
        ]);

        return $estimate_id;
    }

    public function updateEstimate($estimate_id, $price_amount, $is_payed)
    {
        $stmt = $this->pdo->prepare("UPDATE Estimate SET price_amount = :price_amount, is_payed = :is_payed WHERE estimate_id = :estimate_id");
        $stmt->execute([
            'estimate_id' => $estimate_id,
            'price_amount' => $price_amount,
            'is_payed' => $is_payed ? 1 : 0
        ]);

        return $stmt->rowCount() > 0;
    }

    public function getAllEstimates()
    {
        $stmt = $this->pdo->query("SELECT * FROM Estimate");
        $estimates = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $estimates[] = $this->toEstimate($row);
        }

        return $estimates;
    }

    public function getSensorsByEstimate($estimate_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Sensor WHERE estimate_id = :estimate_id");
        $stmt->execute(['estimate_id' => $estimate_id]);
        $sensors = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sensors[] = $this->sensorAPI->toSensor($row);
        }

        return $sensors;
    }

    public function deleteEstimate($estimate_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Estimate WHERE estimate_id = :estimate_id");
        $stmt->execute(['estimate_id' => $estimate_id]);

        return $stmt->rowCount() > 0;
    }

    public function getCountSensor($estimate_id)
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM Sensor WHERE estimate_id = :estimate_id");
        $stmt->execute(['estimate_id' => $estimate_id]);

        return $stmt->fetchColumn();
    }
}

const QUERY_CREATE_TABLE_ESTIMATE = "CREATE TABLE Estimate (
    estimate_id VARCHAR(255) PRIMARY KEY,
    user_id VARCHAR(255),
    created_at TIMESTAMP,
    name VARCHAR(255),
    price_amount DECIMAL(10, 2),
    is_payed BOOLEAN,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);";
