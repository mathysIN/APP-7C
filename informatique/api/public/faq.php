<?php

require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

$questions = $faqQuestionAPI->getAllFAQQuestions();

?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl">Foire aux questions</p>
    <div class="pt-10 w-full text-center">
        <input class="w-2/4 h-14 px-4 py-4 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500" type="text" placeholder="Rechercher une réponse">

        <?php foreach ($questions as $question) : ?>
            <div class="my-8">
                <button class="text-left w-full px-4 py-2 bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 transition duration-150 ease-in-out">
                    <h3 class="text-lg font-bold"><?php echo $question->question; ?></h3>
                </button>
                <div class="accordion-content hidden">
                    <p class="mt-2"><?php echo $question->answer; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    var accordions = document.querySelectorAll(".accordion-content");
    accordions.forEach(function(accordion) {
        var button = accordion.previousElementSibling;
        button.addEventListener("click", function() {
            accordion.classList.toggle("hidden");
        });
    });
</script>