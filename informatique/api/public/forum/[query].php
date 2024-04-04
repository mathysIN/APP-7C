<?php
require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/global_types.php";

$postId = getLastWordOfCurrentUrlPath();
$post = $postsAPI->getPostById($postId);

if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    if ($_CURRENT_USER && $post->hasWriteAccess($_CURRENT_USER)) {
        $postsAPI->deleteCommentsThenPost($postId);
        redirect('/forum?msg=post_deleted');
        exit();
    }
}

if ($post->responding_to_id) {
    redirect("/forum/{$post->responding_to_id}");
    exit();
}

if (!$post) {
    redirect('/forum');
    exit();
}

$responses = $postsAPI->getResponseOfPost($postId);

?>
<div class="flex flex-col gap-4  md:mx-20 mx-4 my-20">
    <a href="/forum">
        <button class="inline-flex my-2 justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-eventit-500 hover:bg-eventit-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-eventit-500">
            Back to forum
        </button>
    </a>
    <main class="flex-1 flex flex-col gap-4 p-4 lg:gap-8 lg:p-6">
        <div>
            <header class="flex flex-row bg-white shadow-md py-4 px-8">
                <div>
                    <h1 class="text-3xl font-semibold"><?php echo $post->title; ?></h1>
                    <div class="flex flex-row items-center gap-2 ">
                        <p>Posté par</p>
                        <img src="<?php echo $post->user->image_url ?>" width="32" height="32" class="rounded-full" alt="Avatar" style="aspect-ratio: 48 / 48; object-fit: cover;">
                        <p class="text-gray-700 font-bold"><?php echo $post->user->getFullName(); ?></p>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400"><?php echo date('F j, Y, g:i a', strtotime($post->created_at)); ?></span>
                    <p class="text-gray-700 mt-2"><?php echo markdown_to_html($post->content); ?></p>
                </div>
                <div class="ml-auto">
                    <?php if ($_CURRENT_USER && $post->hasWriteAccess($_CURRENT_USER)) : ?>
                        <a href="/forum/create_post.php?editing=<?php echo $postId; ?>">
                            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M4 13.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2h-5.5"></path>
                                    <polyline points="14 2 14 8 20 8"></polyline>
                                    <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z"></path>
                                </svg>
                            </button>
                        </a>
                        <a href="<?php getCurrentPath() ?>?action=delete">
                            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                    <path d="M3 6h18"></path>
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                </svg>
                            </button>
                        </a>
                    <?php endif ?>
                </div>
            </header>

            <main class="max-w-3xl mx-auto mt-8">
                <section>
                    <div class="flex flex-row justify-center items-center">
                        <h2 class="text-xl font-semibold mb-4">Responses</h2>
                        <div class="ml-auto"><a href="/forum/create_post.php?responding=<?php echo $postId; ?>">
                                <div class="bg-eventit-500 text-white rounded-lg shadow-md p-4 mb-4 w-fit">
                                    <p class="font-bold">Respond to this post</p>
                                </div>

                            </a>
                        </div>
                    </div>
                    <?php

                    if (count($responses) == 0) {
                    ?>
                        <p class="text-gray-700">No responses found.</p>
                    <?php
                    }

                    foreach ($responses as $response) : ?>
                        <div class="bg-white rounded-lg shadow-md p-4 mb-4">
                            <div class="flex flex-row items-center gap-2 my-2">

                                <img src="<?php echo $response->user->image_url ?>" width="48" height="48" class="rounded-full" alt="Avatar" style="aspect-ratio: 48 / 48; object-fit: cover;">

                                <p class="text-gray-700 font-bold"><?php echo $response->user->getFullName(); ?></p>
                            </div>
                            <p class="text-gray-700"><?php echo markdown_to_html($response->content); ?></p>
                        </div>
                    <?php endforeach; ?>
                </section>
            </main>


        </div>
    </main>
</div>