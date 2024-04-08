<?php

class Sensor
{
    public $sensor_id;
    public $estimate_id;
    public $created_at;
    public $name;
    public $location;
    public $state;

    public function getCurrentValue()
    {
        return rand(20, 100);
    }
}

class SensorAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function toSensor($row)
    {
        $sensor = new Sensor();
        $sensor->sensor_id = $row['sensor_id'];
        $sensor->estimate_id = $row['estimate_id'];
        $sensor->created_at = $row['created_at'];
        $sensor->name = $row['name'];
        $sensor->location = $row['location'];
        $sensor->state = $row['state'];

        return $sensor;
    }

    public function getSensorById($sensor_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Sensor WHERE sensor_id = :sensor_id");
        $stmt->execute(['sensor_id' => $sensor_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toSensor($row);
    }

    public function createSensor($estimate_id, $name, $location, $state)
    {
        $sensor_id = uniqid();

        $stmt = $this->pdo->prepare("INSERT INTO Sensor (sensor_id, estimate_id, created_at, name, location, state) VALUES (:sensor_id, :estimate_id, NOW(), :name, :location, :state)");
        $stmt->execute([
            'sensor_id' => $sensor_id,
            'estimate_id' => $estimate_id,
            'name' => $name,
            'location' => $location,
            'state' => $state
        ]);

        return $sensor_id;
    }

    public function editSensor($sensor_id, $name, $location, $state)
    {
        $stmt = $this->pdo->prepare("UPDATE Sensor SET name = :name, location = :location, state = :state WHERE sensor_id = :sensor_id");
        $stmt->execute([
            'name' => $name,
            'location' => $location,
            'state' => $state,
            'sensor_id' => $sensor_id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function setName($sensor_id, $name)
    {
        $stmt = $this->pdo->prepare("UPDATE Sensor SET name = :name WHERE sensor_id = :sensor_id");
        $stmt->execute([
            'name' => $name,
            'sensor_id' => $sensor_id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function setLocation($sensor_id, $location)
    {
        $stmt = $this->pdo->prepare("UPDATE Sensor SET location = :location WHERE sensor_id = :sensor_id");
        $stmt->execute([
            'location' => $location,
            'sensor_id' => $sensor_id
        ]);

        return $stmt->rowCount() > 0;
    }

    public function deleteSensor($sensor_id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM Sensor WHERE sensor_id = :sensor_id");
        $stmt->execute(['sensor_id' => $sensor_id]);

        return $stmt->rowCount() > 0;
    }
}


const QUERY_CREATE_TABLE_SENSORS = "CREATE TABLE Sensor (
    sensor_id VARCHAR(255) NOT NULL,
    estimate_id VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    name VARCHAR(255),
    location VARCHAR(255),
    state VARCHAR(255),
    PRIMARY KEY (sensor_id)
);";
