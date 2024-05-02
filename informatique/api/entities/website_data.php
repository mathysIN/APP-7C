<?php

class WebsiteData
{
    public $created_at;
    public $cgu_content;
    public $legal_content;
    public $cgu_content_en;
    public $legal_content_en;
    public $primary_color;

    /**
     * @var boolean
     */
    public $old_logo;

    /**
     * @var number
     */
    public $forum_state;
}


class ForumState
{
    const OPEN = 0;
    const CLOSED = 1;
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
        $websiteData->cgu_content_en = $row['cgu_content_en'];
        $websiteData->legal_content_en = $row['legal_content_en'];
        $websiteData->primary_color = $row['primary_color'];
        $websiteData->old_logo = $row['old_logo'] == 1 ? true : false;
        $websiteData->forum_state = $row['forum_state'];

        return $websiteData;
    }

    public function updateWebsiteData($cgu_content, $legal_content, $primary_color, $old_logo)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET cgu_content = :cgu_content, legal_content = :legal_content, primary_color = :primary_color, old_logo = :old_logo");
        $stmt->execute([
            'cgu_content' => $cgu_content,
            'legal_content' => $legal_content,
            'primary_color' => $primary_color,
            'old_logo' => $old_logo ? 1 : 0,
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

    public function updateOldLogo($old_logo)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET old_logo = :old_logo");
        $stmt->execute([
            'old_logo' => $old_logo ? 1 : 0
        ]);

        return $stmt->rowCount() > 0;
    }

    /**
     * @param ForumState $forum_state
     */
    public function updateForumState($forum_state)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET forum_state = :forum_state");
        $stmt->execute([
            'forum_state' => $forum_state
        ]);

        return $stmt->rowCount() > 0;
    }

    public function updateCGUContent($cgu_content, $cgu_content_en)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET cgu_content = :cgu_content, cgu_content_en = :cgu_content_en");
        $stmt->execute([
            'cgu_content' => $cgu_content,
            'cgu_content_en' => $cgu_content_en
        ]);

        return $stmt->rowCount() > 0;
    }

    public function updateLegalContent($legal_content, $legal_content_en)
    {
        $stmt = $this->pdo->prepare("UPDATE WebsiteData SET legal_content = :legal_content, legal_content_en = :legal_content_en");
        $stmt->execute([
            'legal_content' => $legal_content,
            'legal_content_en' => $legal_content_en
        ]);

        return $stmt->rowCount() > 0;
    }
}



const QUERY_CREATE_TABLE_WEBSITE_DATA = "CREATE TABLE WebsiteData (
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    cgu_content TEXT,
    legal_content TEXT,
    cgu_content_en TEXT,
    legal_content_en TEXT,
    primary_color VARCHAR(50),
    old_logo BOOLEAN DEFAULT FALSE,
    forum_state INT,
    PRIMARY KEY (created_at)
);";

const QUERY_ALTER_TABLE_WEBSITE_DATA_1 = "ALTER TABLE WebsiteData 
ADD COLUMN cgu_content_en TEXT,
ADD COLUMN legal_content_en TEXT;
";

const QUERY_DEFAULT_WEBSITEDATA_VALUE = "INSERT INTO WebsiteData (cgu_content, legal_content, primary_color) 
VALUES ('Terms and conditions content', 'Legal content', '#336699');";

const QUERY_ALTER_TABLE_1 = "ALTER TABLE WebsiteData ADD COLUMN old_logo BOOLEAN DEFAULT FALSE;";
