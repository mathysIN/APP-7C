<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newPrimaryColor = $_POST["primary_color"];
    error_log("New primary color: $newPrimaryColor");
    $websiteDataAPI->updatePrimaryColor($newPrimaryColor);
}

$currentColor = $websiteDataAPI->getWebsiteData()->primary_color ?: "#336699";

?>


<div class="flex flex-col">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg><span class="sr-only">Home</span></a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg">User Management</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage your users
            </p>
        </div>
        <div class="flex flex-1 items-center gap-4 md:ml-auto md:gap-2 lg:gap-4">
            <form class="ml-auto flex-1 sm:flex-initial">
                <div class="relative"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-2.5 top-2.5 h-4 w-4 text-gray-500 dark:text-gray-400">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </svg><input type="search" class="flex h-10 w-full rounded-md border border-input px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-8 sm:w-[300px] md:w-[200px] lg:w-[300px] bg-white" placeholder="Search users..."></div>
            </form><button class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-9 rounded-md px-3">Add user</button>
        </div>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <div class="border shadow-sm rounded-lg p-4">
                    <h2 class="text-lg font-semibold mb-2">Change Primary Color</h2>
                    <form method="post">
                        <label for="primary_color" class="block mb-2">Primary Color:</label>
                        <input type="color" id="primary_color" name="primary_color" class="rounded-md border border-gray-300 focus:outline-none focus:ring focus:ring-blue-200" value="<?php echo $currentColor ?>">
                        <button type="submit" class="mt-2 bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md focus:outline-none focus:ring focus:ring-blue-200">Update Color</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>