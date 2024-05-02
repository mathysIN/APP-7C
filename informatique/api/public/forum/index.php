<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

$user_filter = getSearchQuery("user");
$word_filter = getSearchQuery("word");

$posts = null;

if (isset($user_filter) || isset($word_filter)) {
    $posts = $postsAPI->getAllPostsNotRespondingFilter($word_filter, $user_filter);
} else {
    $posts = $postsAPI->getAllPostsNotResponding();
}

?>
²
<div class="flex flex-col gap-4 min-h-screen md:mx-20 mx-4 my-20">
    <header class="flex flex-col gap-2">
        <div class="flex md:flex-row flex-col justify-center">
            <div class="flex items-center gap-4"><a class="lg:hidden" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg><span class="sr-only">Home</span></a>
                <h1 class="font-semibold text-xl">Forum</h1>
            </div>
            <div class="flex md:justify-center items-center gap-4 py-4 md:ml-auto">
                <svg fill="#000000" height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 451 451" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <g>
                            <path d="M447.05,428l-109.6-109.6c29.4-33.8,47.2-77.9,47.2-126.1C384.65,86.2,298.35,0,192.35,0C86.25,0,0.05,86.3,0.05,192.3 s86.3,192.3,192.3,192.3c48.2,0,92.3-17.8,126.1-47.2L428.05,447c2.6,2.6,6.1,4,9.5,4s6.9-1.3,9.5-4 C452.25,441.8,452.25,433.2,447.05,428z M26.95,192.3c0-91.2,74.2-165.3,165.3-165.3c91.2,0,165.3,74.2,165.3,165.3 s-74.1,165.4-165.3,165.4C101.15,357.7,26.95,283.5,26.95,192.3z"></path>
                        </g>
                    </g>
                </svg>
                <form action="/forum" method="GET" class="flex md:flex-row flex-col gap-2 m-0">
                <input type="text" name="word" placeholder="Search by word" class="h-14 px-4 py-4 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500" data-lang="Rechercher par mot|Search by word">
    <input type="text" name="user" placeholder="Search by user" class="h-14 px-4 py-4 border rounded-3xl border-gray-200 focus:outline-none focus:ring focus:border-eventit-500" data-lang="Recherche par utilisateur|Search by user">
                    <button type="submit" class="px-4 py-2 bg-eventit-500 text-white rounded-xl">
                        <p data-lang="Chercher|Search">Search</p>
                    </button>
                </form>
            </div>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400" data-lang="Bienvenue sur le forum! N'hésitez pas à poser des questions, partager vos pensées et aider les autres.|Welcome to the forum! Feel free to ask questions, share your thoughts, and help others.">
        </p>
        <a href="/forum/create_post" class="w-fit">
            <button class="px-4 py-2 bg-eventit-500 text-white rounded-xl">
                <p data-lang="Créer un post|Create a post">Créer un post</p>
            </button>
        </a>
    </header>

    <main class="flex-1 flex flex-col gap-4 p-4 lg:gap-8 lg:p-6">
        <div class="grid gap-4">
            <?php
            if (count($posts) == 0) {
            ?>
                <p data-lang="Aucun post trouvé.|No post found.">
                </p>
            <?php
            }
            foreach ($posts as $post) {
            ?>
                <a href="/forum/<?php echo $post->post_id ?>">
                    <div class="border rounded-lg p-4">
                        <div class="flex items-start gap-4">
                            <img src="<?php echo $post->user->image_url ?>" width="48" height="48" class="rounded-full" alt="Avatar" style="aspect-ratio: 48 / 48; object-fit: cover;">
                            <div class="grid gap-1.5">
                                <div class="flex items-center gap-2">
                                    <h2 class="font-semibold text-base"><?php echo $post->title . " - " . $post->user->first_name . " " . $post->user->last_name; ?></h2>
                                    <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo date('F j, Y, g:i a', strtotime($post->created_at)); ?></span>
                                </div>
                                <p>
                                    <?php echo $post->content; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </main>
</div>