<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["primary_color"])) {
        $websiteDataAPI->updatePrimaryColor($_POST["primary_color"]);
    }

    $websiteDataAPI->updateOldLogo(isset($_POST["use_old_logo"]));
}

$currentColor = $websiteDataAPI->getWebsiteData()->primary_color ?: "#336699";
$useOldLogo = $websiteDataAPI->getWebsiteData()->old_logo ?: false;

?>


<div class="flex flex-col">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg><span class="sr-only">Maison</span></a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg">Options générales</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gérer les options du site
            </p>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <div class="border shadow-sm rounded-lg p-4">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md mb-4">
                        <div class="flex items center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 3c-4.97 0-9 4.03-9 9s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9Zm0 16c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7Zm0-2c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2Zm-1-5h2v-2h-2v2Zm0-4h2v-2h-2v2Z"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">Les changements effectués ici sont appliqués directement sur le site. Ces derniers peuvent prendre du temps avant d'être visibles pour les utilisateurs déjà connectés.</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Changer la couleur primaire</h2>
                        <form method="post">
                            <label for="primary_color" class="block mb-2">Couleur primaire :</label>
                            <div class="flex flex-row items-center gap-4">
                                <input type="color" id="primary_color" name="primary_color" class="rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200" value="<?php echo $currentColor ?>">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Utiliser l'ancien logo</h2>
                        <form method="post">
                            <label for="primary_color" class="block mb-2">Ancien logo :</label>
                            <div class="flex flex-row items-center gap-4">
                                <input type="checkbox" id="use_old_logo" name="use_old_logo" class="rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200" <?php echo $useOldLogo ? "checked" : "" ?>>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</div>