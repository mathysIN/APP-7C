<?php
require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

$faqQuestions = $faqQuestionAPI->getAllFAQQuestions();
?>

<div class="flex flex-col">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6">
        <!-- Your header content -->
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&amp;_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground">Section</th>
                            <th
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground min-w-[150px]">
                                Question</th>
                            <th
                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">
                                Answer</th>
                            <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&amp;_tr:last-child]:border-0">
                        <?php foreach ($faqQuestions as $faqQuestion): ?>
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle font-medium">
                                    <?php echo $faqQuestion->section; ?>
                                </td>
                                <td class="p-4 align-middle">
                                    <?php echo $faqQuestion->question; ?>
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell">
                                    <?php echo $faqQuestion->answer; ?>
                                </td>
                                <td class="p-4 align-middle text-right flex">
                                    <button onclick="openEditPopup(<?php echo $faqQuestion->section; ?>)"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="w-4 h-4">
                                            <path d="M4 13.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2h-5.5"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z">
                                            </path>
                                        </svg><span class="sr-only">Edit</span></button><button
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="w-4 h-4">
                                            <path d="M3 6h18"></path>
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                        </svg><span class="sr-only">Delete</span></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="editPopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
            <div class="bg-white p-6 rounded-lg max-w-lg">
                <h2 class="text-lg font-bold mb-4">Modifier la FAQ</h2>
                <input type="text" id="editSection" class="w-full mb-2" placeholder="Section">
                <input type="text" id="editQuestion" class="w-full mb-2" placeholder="Question">
                <textarea id="editAnswer" class="w-full mb-4" rows="4" placeholder="Réponse"></textarea>
                <div class="flex justify-end">
                    <button onclick="saveEdit()"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Enregistrer</button>
                    <button onclick="closeEditPopup()" class="bg-gray-300 px-4 py-2 rounded-md">Annuler</button>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    function openEditPopup(faqId) {
        // Vous devez remplir les champs avec les détails de la FAQ
        var section = document.getElementById('section_' + faqId).innerText;
        var question = document.getElementById('question_' + faqId).innerText;
        var answer = document.getElementById('answer_' + faqId).innerText;

        document.getElementById('editSection').value = section;
        document.getElementById('editQuestion').value = question;
        document.getElementById('editAnswer').value = answer;

        document.getElementById('editPopup').classList.remove('hidden');
    }

    function closeEditPopup() {
        document.getElementById('editPopup').classList.add('hidden');
    }

    function saveEdit() {
        // Vous pouvez implémenter ici la logique pour sauvegarder les modifications
        // par exemple, en envoyant les données via AJAX à un script PHP pour les mettre à jour dans la base de données.
        closeEditPopup();
    }
</script>