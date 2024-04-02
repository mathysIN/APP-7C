<div class="h-full py-20 flex flex-col justify-top">
    <p class="text-eventit-500 text-center font-bold text-6xl">CONTACT</p>
    <div class="max-w-md mx-auto p-6 text-center">
    <form method="post" action="sendmail.php">
    <div class="mb-4">
        <label for="organisation" class="block text-left pl-1 text-eventit-500">Votre organisation</label>
        <input type="text" name="organisation" id="organisation" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
    </div>
    <div class="mb-4">
        <label for="nom" class="block text-left pl-1 text-eventit-500">Nom et Prénom</label>
        <input type="text" name="nom" id="nom" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
    </div>
    <div class="mb-4">
        <label for="email" class="block text-left pl-1 text-eventit-500">Email</label>
        <input type="email" name="email" id="email" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
    </div>
    <div class="mb-4">
        <label for="telephone" class="block text-left pl-1 text-eventit-500">Numéro de téléphone</label>
        <input type="tel" name="telephone" id="telephone" class="w-80 h-9 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500">
    </div>
    <div class="mb-4">
        <label for="message" class="block text-left pl-1 text-eventit-500">Message</label>
        <textarea name="message" id="message" class="w-80 h-40 px-2 py-2 border rounded-3xl border-eventit-500 focus:outline-none focus:ring focus:border-eventit-500" placeholder="Un problème, une question, n'hésitez pas à nous contacter sur nos réseaux" rows="5"></textarea>
    </div>
    <div class="text-center">
        <button type="submit" class="w-3/5 bg-eventit-500 text-white py-2 px-4 rounded-3xl hover:bg-eventit-600 focus:outline-none focus:ring focus:border-eventit-500">Envoyer ma demande !</button>
    </div>
</form>
    </div>
</div>