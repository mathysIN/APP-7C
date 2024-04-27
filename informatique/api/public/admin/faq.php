<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $section = $_POST['section'];
        $question = $_POST['question'];
        $question_en = $_POST['question_en'];
        $answer = $_POST['answer'];
        $anwser_en = $_POST["answer_en"];
        $faqQuestionAPI->addFAQQuestionMultiLang($section, $question, $question_en, $answer, $anwser_en);
    } else if ($action === 'modify') {
        foreach ($_POST['questions'] as $questionData) {
            $id = $questionData['id'];
            $section = $questionData['section'];
            $question = $questionData['question'];
            $question_en = $questionData['question_en'];
            $answer = $questionData['answer'];
            $answer_en = $questionData['answer_en'];
            $faqQuestionAPI->updateFAQQuestionMultiLang($id, $section, $question, $question_en, $answer, $answer_en);
        }
    } else if ($action === 'delete') {
        $id = $_POST['id'];
        $faqQuestionAPI->deleteFAQQuestion($id);
    }
}
$questions = $faqQuestionAPI->getAllFAQQuestions();
?>


<div class="flex flex-col w-full">
    <header class=" flex h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg><span class="sr-only">Maison</span></a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg">Gestion de la FAQ</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gérer les questions de la FAQ
            </p>
    </header>
    <div class="pt-6 px-4">
        <button onclick="openPopup()" class="bg-eventit-500 p-2 text-white rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500 button">Ajouter
            une question</button>
    </div>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <div class="border shadow-sm rounded-lg p-4">
                    <div>
                        <form method="post">
                            <input name="action" value="modify" hidden />
                            <?php foreach ($questions as $question) : ?>
                                <div class="border-b mb-4 pb-4">

                                    <input type="hidden" name="questions[<?php echo $question->id; ?>][id]" value="<?php echo $question->id; ?>" />
                                    <label for="questions[<?php echo $question->id; ?>][section]" class="block mb-1">Section</label>

                                    <select class="w-full border border-gray-300 rounded-md p-2" name="questions[<?php echo $question->id; ?>][section]" required>
                                        <option <?php if ($question->section == "event-it") echo "selected"; ?> value="event-it">event-it</option>
                                        <option <?php if ($question->section == "compte") echo "selected"; ?> value="compte">compte</option>
                                        <option <?php if ($question->section == "capteurs") echo "selected"; ?> value="capteurs">capteurs</option>
                                        <option <?php if ($question->section == "devis") echo "selected"; ?> value="devis">devis</option>
                                    </select>
                                    <label for="questions[<?php echo $question->id; ?>][question]" class="block mb-1">Question FR</label>
                                    <input type="text" class="p-2 w-full mb-2 rounded-md border border-gray-300" name="questions[<?php echo $question->id; ?>][question]" value="<?php echo ($question->question); ?>" />
                                    <label for="questions[<?php echo $question->id; ?>][question_en]" class="block mb-1">Question EN</label>
                                    <input type="text" class="p-2 w-full mb-2 rounded-md border border-gray-300" name="questions[<?php echo $question->id; ?>][question_en]" value="<?php echo ($question->question_en); ?>" />
                                    <label for="questions[<?php echo $question->id; ?>][answer]" class="block mb-1">Response FR</label>
                                    <textarea class="p-2 w-full h-24 rounded-md border border-gray-300" name="questions[<?php echo $question->id; ?>][answer]"><?php echo ($question->answer); ?></textarea>
                                    <label for="questions[<?php echo $question->id; ?>][answer_en]" class="block mb-1">Response EN</label>
                                    <textarea class="p-2 w-full h-24 rounded-md border border-gray-300" name="questions[<?php echo $question->id; ?>][answer_en]"><?php echo ($question->answer_en); ?></textarea>
                                    <button type="button" onclick="deleteQuestion(<?php echo $question->id; ?>)" class="p-2 mt-6 text-red-600 border border-red-600 rounded-3xl  focus:outline-none focus:ring" class="p-2 mt-6 text-red-600 border border-red-600 rounded-3xl  focus:outline-none focus:ring">Supprimer
                                        la
                                        question</button>
                                </div>
                            <?php endforeach; ?>
                            <button onclick class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Mettre
                                à jour</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<div id="popup" class="hidden fixed inset-0 bg-black bg-opacity-50 justify-center items-center">
    <div class="bg-white p-8 rounded-lg w-3/6">
        <div class="flex">

            <h2 class="text-lg font-semibold mb-4">Ajouter une question</h2>
            <div class="ml-auto">
                <button onclick="closePopup()" class="mt-2 mr-2 bg-gray-200 p-2 rounded-full focus:outline-none">X</button>
            </div>
        </div>
        <form method="post">
            <div class="mb-4">
                <label for="section" class="block mb-1">Section</label>
                <select id="section" name="section" class="w-full border border-gray-300 rounded-md p-2" required>
                    <option value="event-it">event-it</option>
                    <option value="compte">compte</option>
                    <option value="capteurs">capteurs</option>
                    <option value="devis">devis</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="question" class="block mb-1">Question FR</label>
                <input name="action" value="add" hidden />
                <input type="text" id="question" name="question" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="question_en" class="block mb-1">Question EN</label>
                <input name="action" value="add" hidden />
                <input type="text" id="question_en" name="question_en" class="w-full border border-gray-300 rounded-md p-2" required>
            </div>
            <div class="mb-4">
                <label for="answer" class="block mb-1">Réponse FR</label>
                <textarea id="answer" name="answer" class="w-full border border-gray-300 rounded-md p-2" rows="4" required></textarea>
            </div>
            <div class="mb-4">
                <label for="answer_en" class="block mb-1">Réponse EN</label>
                <textarea id="answer_en" name="answer_en" class="w-full border border-gray-300 rounded-md p-2" rows="4" required></textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Ajouter</button>
        </form>
    </div>
</div>
<script>
    function openPopup() {
        document.getElementById('popup').classList.remove('hidden');
        document.getElementById('popup').classList.add('flex');
    }

    function closePopup() {
        document.getElementById('popup').classList.add('hidden');
        document.getElementById('popup').classList.add('flex');
    }

    function addQuestion() {
        var section = document.getElementById('section').value;
        var question = document.getElementById('question').value;
        var answer = document.getElementById('answer').value;
        fetch('ajouter_question.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    section: section,
                    question_en: question,
                    answer_en: answer
                })
            })
            .then(response => {
                if (response.ok) {
                    location.reload();
                } else {}
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function deleteQuestion(questionId) {
        if (confirm('Are you sure you want to delete this question?')) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';
            form.style.display = 'none';

            var inputId = document.createElement('input');
            inputId.type = 'hidden';
            inputId.name = 'id';
            inputId.value = questionId;

            var inputAction = document.createElement('input');
            inputAction.type = 'hidden';
            inputAction.name = 'action';
            inputAction.value = 'delete';

            form.appendChild(inputId);
            form.appendChild(inputAction);

            document.body.appendChild(form);

            form.submit();
        }
    }
</script>