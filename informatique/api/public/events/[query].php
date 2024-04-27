<?php

require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/global_types.php";

$eventId = getLastWordOfCurrentUrlPath();

$estimate = $estimateAPI->getEstimateById($eventId);


if (!$estimate || !$estimate->is_payed || !$estimate->event_name) {
    redirect("/404");
    exit();
}
?>

<div class="container mx-auto py-12">
    <div class="relative p-8 mb-8 py-20 bg-cover bg-opacity-25" style="background-image: url(<?php echo $estimate->banner_image; ?>)">
        <div class="absolute inset-0 bg-black opacity-25"></div>
        <h1 class="text-4xl text-white font-bold drop-shadow-xl"><?php echo $estimate->event_name; ?></h1>
        <p class="text-lg mt-2 text-white drop-shadow-xl"><?php echo $estimate->date; ?> | <?php echo $estimate->location; ?></p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="col-span-2">
            <h2 class="text-xl font-bold mb-4">Description</h2>

            <p><?php echo $estimate->event_description; ?></p>
            <div class="h-8"></div>
            <a href=""><button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex items-center justify-center whitespace-nowrap rounded-md bg-eventit-500 px-8 py-4  text-xl uppercase font-bold text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" data-lang="Nouveau devis|New quote">S'inscrire</button></a>
        </div>
        <div>
            <h2 class="text-xl font-bold mb-4">Gallery</h2>
            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($estimate->gallery_images as $image) : ?>
                    <img src="<?php echo $image; ?>" alt="Gallery Image" class="w-full rounded-xl hover:shadow-xl hover:-translate-y-2 transition-all cursor-pointer">
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>