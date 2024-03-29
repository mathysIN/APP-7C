<?php
require __DIR__ . "/../entities/all_entities.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organization = $_POST['organization'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $num_rooms = $_POST['num_rooms'];
    $area_size = $_POST['area_size'];
    $message = $_POST['message'];

    $estimate_id = $estimateAPI->createEstimate($organization, $name, $email, $phone_number, $num_rooms, $area_size, $message);

    if ($estimate_id) {
        echo "<p>Estimate submitted successfully! Estimate ID: $estimate_id</p>";
    } else {
        echo "<p>Error submitting estimate.</p>";
    }
}
?>

<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl">Faire un devis</p>
    <div class="max-w-md mx-auto p-6 text-center">
        <form>
            <div class="mb-4">
                <label for="email" class="block text-left pl-1 text-eventit-500">Votre organisation</label>
                <input type="text" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Nom et Prénom</label>
                <input type="text" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Email</label>
                <input type="email" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Numéro de téléphone</label>
                <input type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Nombre de salle/endroit</label>
                <input class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500" type="number" id="tentacles" name="tentacles" min="1" max="100" />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Nombre de m2</label>
                <input class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500" type="number" id="tentacles" name="tentacles" min="1" max="100" />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-left pl-1 text-eventit-500">Message</label>
                <input type="password" id="password" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
            </div>
            <div class="text-center">
                <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500">Envoyer mon devis</button>
            </div>
        </form>
    </div>
</div>