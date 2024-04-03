<?php

require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";

$questions = $faqQuestionAPI->getAllFAQQuestions();
$sections = array_unique(array_column($questions, 'section'));

?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 font-bold text-6xl self-center">Foire aux questions</p>
    <div class="pt-10 w-full flex justify-center">

        <div class="max-w-[650px] flex flex-col gap-5 items-center justify-center">
            <input
                class="w-full h-14 px-4 py-4 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500"
                type="text" placeholder="Rechercher une réponse" />
            <div class="flex justify-between w-full">
                <?php foreach ($sections as $section): ?>
                    <button
                        class="w-[23%] text-lg px-4 py-2 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500">
                        <?php echo $section; ?>
                    </button>
                <?php endforeach; ?>
            </div>
            <?php foreach ($questions as $question): ?>
                <div class=" w-full">
                    <div class="accordion border rounded-3xl border-eventit-500 transition duration-150 ease-in-out">
                        <button class="text-left flex w-full px-4 py-4">
                            <h3 class="text-lg font-bold">
                                <?php echo $question->question; ?>
                            </h3>
                            <svg class=" ml-auto arrow h-6 w-6 transform transition-transform duration-200"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a.75.75 0 01-.53-.22l-7-7A.75.75 0 013.22 9.47L10 16.25l6.78-6.78a.75.75 0 111.06 1.06l-7 7a.75.75 0 01-.53.22z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div class="accordion-content hidden px-4 py-4 text-left w-full">
                            <p class="">
                                <?php echo $question->answer; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    var accordions = document.querySelectorAll(".accordion-content");
    accordions.forEach(function (accordion) {
        var button = accordion.previousElementSibling;
        button.addEventListener("click", function () {
            accordion.classList.toggle("hidden");
            var arrow = button.querySelector('.arrow');
            arrow.classList.toggle('rotate-180');
        });
    });
</script>