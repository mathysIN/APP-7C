<?php

class WebsiteData
{
    public $created_at;
    public $cgu_content;
    public $legal_content;
    public $primary_color;
}

class WebsiteDataAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getWebsiteData()
    {
        $stmt = $this->pdo->query("SELECT * FROM WebsiteData LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        $websiteData = new WebsiteData();
        $websiteData->created_at = $row['created_at'];
        $websiteData->cgu_content = $row['cgu_content'];
        $websiteData->legal_content = $row['legal_content'];
        $websiteData->primary_color = $row['primary_color'];

        return $websiteData;
    }

    public function updateWebsiteData($cgu_content, $legal_content, $primary_color)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET cgu_content = :cgu_content, legal_content = :legal_content, primary_color = :primary_color");
        $stmt->execute([
            'cgu_content' => $cgu_content,
            'legal_content' => $legal_content,
            'primary_color' => $primary_color
        ]);

        return $stmt->rowCount() > 0;
    }

    public function updatePrimaryColor($primary_color)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET primary_color = :primary_color");
        $stmt->execute([
            'primary_color' => $primary_color
        ]);

        return $stmt->rowCount() > 0;
    }
}

const QUERY_CREATE_TABLE_WEBSITE_DATA = "CREATE TABLE WebsiteData (
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cgu_content TEXT,
    legal_content TEXT,
    primary_color VARCHAR(50),
    PRIMARY KEY (created_at)
);";
