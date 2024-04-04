<?php

class FAQQuestion
{
    public $section;
    public $question;
    public $answer;
    public $id;
}

class FAQAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    private function toFAQQuestion($row)
    {
        $faqQuestion = new FAQQuestion();
        $faqQuestion->section = $row['section'];
        $faqQuestion->question = $row['question'];
        $faqQuestion->answer = $row['answer'];
        $faqQuestion->id = $row['id'];

        return $faqQuestion;
    }

    public function getFAQQuestionById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM FAQ_Question WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return $this->toFAQQuestion($row);
    }

    public function getAllFAQQuestions()
    {
        $stmt = $this->pdo->query("SELECT * FROM FAQ_Question");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $faqQuestions = [];

        foreach ($rows as $row) {
            $faqQuestions[] = $this->toFAQQuestion($row);
        }

        return $faqQuestions;
    }

    public function updateFAQQuestion($id, $section, $question, $answer)
    {
        $stmt = $this->pdo->prepare("UPDATE FAQ_Question SET section = :section, question = :question, answer = :answer WHERE id = :id");
        $stmt->execute(['section' => $section, 'question' => $question, 'answer' => $answer, 'id' => $id]);
    }
}

const QUERY_CREATE_TABLE_FAQ = "CREATE TABLE FAQ_Question (
    section VARCHAR(255),
    question VARCHAR(255),
    answer VARCHAR(255),
    id INT AUTO_INCREMENT PRIMARY KEY
);";

const QUERY_DEFAULT_FAQ_VALUE = "INSERT INTO FAQ_Question (section, question, answer) 
VALUES ('General', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');";
