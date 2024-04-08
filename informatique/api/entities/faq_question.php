<?php

class FAQQuestion
{
    public $section;
    public $question;
    public $question_en;
    public $answer;
    public $answer_en;
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
        $faqQuestion->question_en = $row['question_en'];
        $faqQuestion->answer = $row['answer'];
        $faqQuestion->answer_en = $row['answer_en'];
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

    public function updateFAQQuestion($id, $section, $question_en, $answer_en)
    {
        $stmt = $this->pdo->prepare("UPDATE FAQ_Question SET section = :section, question = :question_en, answer_en = :answer_en WHERE id = :id");
        $stmt->execute(['section' => $section, 'question_en' => $question_en, 'answer_en' => $answer_en, 'id' => $id]);
    }
}

const QUERY_CREATE_TABLE_FAQ = "CREATE TABLE FAQ_Question (
    section VARCHAR(255),
    question_en VARCHAR(255),
    answer_en VARCHAR(255),
    id INT AUTO_INCREMENT PRIMARY KEY
);";

const QUERY_DEFAULT_FAQ_VALUE = "INSERT INTO FAQ_Question (section_en, question_en, answer_en) 
VALUES ('General', 'What is Lorem Ipsum?', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.');";
