<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../utils/global_types.php";

$responding = getSearchQuery("responding");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!$_CURRENT_USER) {
        redirect('/login');
        exit;
    }

    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_CURRENT_USER->user_id;
    $response_to = $_POST["responding"] ?: null;

    if (!$title || !$content) {
        redirect('/forum/create_post?msg=post_missing_fields');
    }

    $post_id = $postsAPI->createPost($user_id, $title, $content, $response_to);
    redirect("/forum/$post_id");
}

?>


<div class=" md:mx-20 mx-4 my-20 ">
    <a href="/forum">
        <button class="inline-flex my-2 justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-eventit-500 hover:bg-eventit-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-eventit-500">
            Back to forum
        </button>
    </a>
    <?php if ($responding) : ?>
        <h1 class="text-3xl font-semibold">Responding to post <code><?php echo $responding ?></code></h1>
    <?php else : ?>
        <h1 class="text-3xl font-semibold">Create a post</h1>
    <?php endif; ?>
    <form method="post" class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex flex-row items-center gap-2 my-4">
            <p>Poster en tant que</p>
            <img src="<?php echo $_CURRENT_USER->image_url ?>" width="32" height="32" class="rounded-full" alt="Avatar" style="aspect-ratio: 48 / 48; object-fit: cover;">
            <p class="text-gray-700 font-bold"><?php echo $_CURRENT_USER->getFullName(); ?></p>
        </div>
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" id="content" rows="5" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
        </div>
        <div class="flex justify-end">
            <?php if ($responding) : ?>
                <input class="hidden" value="<?php echo $responding ?>" name="responding" id="responding">
            <?php endif; ?>
        </div> <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-eventit-500 hover:bg-eventit-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-eventit-500">
            Post
        </button>
    </form>
</div>