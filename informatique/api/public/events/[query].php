<?php

require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/global_types.php";

$eventId = getLastWordOfCurrentUrlPath();

$estimate = $estimateAPI->getEstimateById($eventId);


if (!$estimate || !$estimate->is_payed) {
    redirect("/404");
    exit();
}

$estimate = [
    'event_name' => $estimate->estimate_id,
    'date' => 'May 15, 2024',
    'location' => 'Central Park, New York',
    'description' => 'Join us for a day filled with music, food, and fun!',
    'banner_image' => '/resources/home.jpg',
    'gallery_images' => [
        '/resources/home.jpg',
        '/resources/home.jpg',
        '/resources/home.jpg',
    ]
];
?>

<div class="container mx-auto pb-12">
    <div class="p-8 mb-8">
        <h1 class="text-4xl font-bold"><?php echo $estimate['event_name']; ?></h1>
        <p class="text-lg mt-2"><?php echo $estimate['date']; ?> | <?php echo $estimate['location']; ?></p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="col-span-2">
            <img src="<?php echo $estimate['banner_image']; ?>" alt="<?php echo $estimate['event_name']; ?>" class="w-full mb-8">
            <p><?php echo $estimate['description']; ?></p>
            <button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex h-10 items-center justify-center whitespace-nowrap rounded-md bg-eventit-500 px-4 py-2 text-sm font-medium text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" data-lang="Nouveau devis|New quote">S'inscrire</button>
        </div>
        <div>
            <h2 class="text-xl font-bold mb-4">Gallery</h2>
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($estimate['gallery_images'] as $image) : ?>
                    <img src="<?php echo $image; ?>" alt="Gallery Image" class="w-full">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>