<?php
require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
$questions = $faqQuestionAPI->getAllFAQQuestions();
$sections = array_unique(array_column($questions, 'section'));
?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 font-bold text-6xl self-center">Foire aux questions</p>
    <div class="pt-10 w-full flex justify-center">
        <div class="w-[650px] flex flex-col gap-5 items-center justify-center">
            <input id="searchInput"
                class="w-full h-14 px-4 py-4 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500"
                type="text" placeholder="Rechercher une réponse" />
            <div class="flex gap-3 justify-between w-full">
                <?php foreach ($sections as $section): ?>
                    <button
                        class="w-[20%] text-lg px-4 py-2 border rounded-3xl bg-eventit-500 text-white focus:outline-none focus:ring focus:border-eventit-500 section-button"
                        data-section="<?php echo $section; ?>">
                        <?php echo ($section === 'event-it') ? 'Event-it' : (($section === 'devis') ? 'Devis' : (($section === 'compte') ? 'Compte' : (($section === 'capteurs') ? 'Capteurs' : $section))); ?>
                    </button>
                <?php endforeach; ?>
                <button
                    class="w-[20%] text-lg px-2 py-2 border rounded-3xl bg-eventit-500 text-white focus:outline-none focus:ring focus:border-eventit-500 section-button"
                    id="showAllButton">Voir tout</button>
            </div>
            <div class="w-full flex flex-col gap-5 accordion-container">
                <?php foreach ($questions as $question): ?>
                    <div class="accordion border rounded-3xl border-eventit-500"
                        data-section="<?php echo $question->section; ?>">
                        <button class="text-left w-full flex px-4 py-4">
                            <h3 class="text-lg font-bold">
                                <?php echo $question->question; ?>
                            </h3>
                            <svg class="ml-auto arrow h-6 w-6 transform text-eventit-500 transition-transform duration-200"
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Votre code JavaScript ici
        var sectionButtons = document.querySelectorAll(".section-button");
        sectionButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                var sectionName = this.getAttribute("data-section");
                var accordions = document.querySelectorAll(".accordion");
                accordions.forEach(function (accordion) {
                    if (accordion.getAttribute("data-section") === sectionName) {
                        accordion.classList.remove("hidden");
                    } else {
                        accordion.classList.add("hidden");
                    }
                });
            });
        });

        var showAllButton = document.getElementById("showAllButton");
        if (showAllButton) { // Vérifiez si l'élément existe
            showAllButton.addEventListener("click", function () {
                var accordions = document.querySelectorAll(".accordion");
                accordions.forEach(function (accordion) {
                    accordion.classList.remove("hidden");
                });
            });
        }

        var accordions = document.querySelectorAll(".accordion-content");
        accordions.forEach(function (accordion) {
            var button = accordion.previousElementSibling;
            button.addEventListener("click", function () {
                accordion.classList.toggle("hidden");
                var arrow = button.querySelector('.arrow');
                arrow.classList.toggle('rotate-180');
            });
        });

        var searchInput = document.getElementById("searchInput");
        searchInput.addEventListener("input", function () {
            var searchTerm = this.value.trim().toLowerCase();
            var accordions = document.querySelectorAll(".accordion");
            accordions.forEach(function (accordion) {
                var questionText = accordion.querySelector("h3").textContent.trim().toLowerCase();
                var answerText = accordion.querySelector(".accordion-content p").textContent.trim().toLowerCase();
                if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
                    accordion.classList.remove("hidden");
                } else {
                    accordion.classList.add("hidden");
                }
            });
        });
    });
</script>