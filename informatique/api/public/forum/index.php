<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";
$posts = $postsAPI->getAllPostsNotResponding();
?>

<div class="flex flex-col gap-4 min-h-screen md:mx-20 mx-4 my-20">
    <header class="flex flex-col gap-2">
        <div class="flex items-center gap-4"><a class="lg:hidden" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                </svg><span class="sr-only">Home</span></a>
            <h1 class="font-semibold text-xl">Forum</h1>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400" data-lang="Bienvenue sur le forum! N'hésitez pas à poser des questions, partager vos pensées et aider les autres.|Welcome to the forum! Feel free to ask questions, share your thoughts, and help others.">
        </p>

        <a href="/forum/create_post">
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