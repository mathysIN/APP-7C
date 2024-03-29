<?php

class FAQQuestion
{
    public $section;
    public $question;
    public $answer;
}

class FAQAPI
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getFAQQuestion()
    {
        $stmt = $this->pdo->query("SELECT * FROM FAQ_Question LIMIT 1");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null; // No FAQ question found
        }

        $faqQuestion = new FAQQuestion();
        $faqQuestion->section = $row['section'];
        $faqQuestion->question = $row['question'];
        $faqQuestion->answer = $row['answer'];

        return $faqQuestion;
    }

    public function getAllFAQQuestions()
    {
        $stmt = $this->pdo->query("SELECT * FROM FAQ_Question");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $faqQuestions = [];

        foreach ($rows as $row) {
            $faqQuestion = new FAQQuestion();
            $faqQuestion->section = $row['section'];
            $faqQuestion->question = $row['question'];
            $faqQuestion->answer = $row['answer'];

            $faqQuestions[] = $faqQuestion;
        }

        return $faqQuestions;
    }
}

const QUERY_CREATE_TABLE_FAQ = "CREATE TABLE FAQ_Question (
    section VARCHAR(255),
    question VARCHAR(255),
    answer VARCHAR(255)
);";

const QUERY_DEFAULT_FAQ_VALUE = "INSERT INTO FAQ_Question (section, question, answer) 
VALUES ('General', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');
";
