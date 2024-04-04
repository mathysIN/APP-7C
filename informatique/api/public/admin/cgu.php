<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

$websiteData = $websiteDataAPI->getWebsiteData();

$cguContent = $websiteData->cgu_content;
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
                    <div>
                        <h2 class="text-lg font-semibold mb-2">Contenue des CGU</h2>
                        <form method="post">
                            <div class="flex flex-col items-center gap-4">
                                <textarea type="color" id="primary_color" name="primary_color" class="p-2 w-full min-h-72 rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200"><?php echo $cguContent; ?></textarea>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Mettre à jour</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>