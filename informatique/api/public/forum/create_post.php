<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../utils/global_types.php";

$responding = getSearchQuery("responding");
$editing = getSearchQuery("editing") ?? false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!$_CURRENT_USER) {
        redirect('/login');
        exit;
    }

    if ($WEBSITE_DATA->forum_state != ForumState::OPEN && $_CURRENT_USER->role != Role::ADMIN) {
        redirect('/forum?msg=forum_closed');
        exit();
    }

    $title = $_POST["title"];
    $content = $_POST["content"];
    $user_id = $_CURRENT_USER->user_id;
    $response_to = isset($_POST["responding"]) ? $_POST["responding"] : null;
    $editing_post = isset($_POST["editing"]) ? $_POST["editing"] : null;

    // Edit
    if (($editing_post)) {
        $post = $postsAPI->getPostById($editing_post);
        if (!$post || !$post->hasWriteAccess($_CURRENT_USER)) {
            error_log("bruh 1");
            redirect('/forum/create_post?msg=invalid_editing');
            exit();
        }
        $postsAPI->editPost($editing_post, $content);
        redirect("/forum/$editing_post");
        // Create & response
    } else {
        if ($response_to && $postsAPI->getPostById($response_to) === null) {
            redirect('/forum/create_post?msg=invalid_response_to');
            exit();
        }
        if ((!$response_to && !$title) || !$content) {
            redirect('/forum/create_post?msg=post_missing_fields');
            exit();
        }

        $post_id = $postsAPI->createPost($user_id, $title, $content, $response_to);
        redirect("/forum/$post_id");
        exit();
    }
}

if (($editing)) {
    $post = $postsAPI->getPostById($editing);
    if (!$post || !$post->hasWriteAccess($_CURRENT_USER)) {
        error_log($editing);
        error_log("bruh 2");
        redirect('/forum/create_post?msg=invalid_editing');
        exit();
    }
    $responding = null;
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
    <?php elseif ($editing) : ?>
        <h1 class="text-3xl font-semibold">Editing post <code><?php echo $editing ?></code></h1>
    <?php else : ?>
        <h1 class="text-3xl font-semibold">Create a post</h1>
    <?php endif; ?>
    <form method="post" class="bg-white p-6 rounded-lg shadow-md">
        <a href="/mon_profil" class="flex flex-row items-center gap-2 my-4 w-fit">
            <p>Poster en tant que</p>
            <img src="<?php echo $_CURRENT_USER->image_url ?>" width="32" height="32" class="rounded-full" alt="Avatar" style="aspect-ratio: 48 / 48; object-fit: cover;">
            <p class="text-gray-700 font-bold"><?php echo $_CURRENT_USER->getFullName(); ?></p>
        </a>
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input type="text" name="title" id="title" class="my-2 px-2 py-2 border rounded-xl border-gray-400 focus:outline-none focus:ring focus:border-eventit-500 w-full" <?php echo $editing ? "disabled" : "" ?> value="<?php echo $post->title ?? "" ?>">
        </div>
        <div class="mb-4">
            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
            <textarea name="content" id="content" rows="5" class="my-2 px-2 py-2 border rounded-xl border-gray-400 focus:outline-none focus:ring focus:border-eventit-500 w-full"><?php echo $post->content ?? "" ?></textarea>
        </div>
        <div class="flex justify-end">
            <?php if ($responding) : ?>
                <input class="hidden" value="<?php echo $responding ?>" name="responding" id="responding">7
            <?php elseif ($editing) : ?>
                <input class="hidden" value="<?php echo $editing ?>" name="editing" id="editing">
            <?php endif; ?>
        </div> <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-eventit-500 hover:bg-eventit-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-eventit-500">
            Post
        </button>
    </form>
</div>