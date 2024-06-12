<?php

require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

$estimates = $estimateAPI->getEstimatesByUser($_CURRENT_USER->user_id);
$estimateMapSensors = [];
$volume = Trame::getTrames()[0]->sensorValue;

foreach ($estimates as $estimate) {
    $estimateMapSensors[$estimate->estimate_id] = $estimateAPI->getSensorsByEstimate($estimate->estimate_id);
}

?>

<div class="h-full flex flex-col justify-top pt-20 pb-56">
    <p class="text-eventit-500 text-center font-bold text-6xl py-4" data-lang="Mes capteurs|My sensors">Mes capteurs</p>
    <?php foreach ($estimates as $estimate) : ?>
        <hr class="my-4 mx-16 border-1 border-eventit-500">
        <div class="pb-16">
            <h4 class="text-event 500 pl-24" data-lang="Devis #<?= $estimate->estimate_id ?>|Quote #<?= $estimate->estimate_id ?>">Devis #<?= $estimate->estimate_id ?></h4>
            <div class="grid mt-8 gap-y-10 justify-items-center md:grid-cols-2 lg:grid-cols-4">
                <?php foreach ($estimateMapSensors[$estimate->estimate_id] as $sensor) : ?>
                    <a href="/capteurs/<?= $sensor->sensor_id ?>" class="flex justify-left w-7/12 h-80 bg-eventit-200 rounded-3xl hover:transform hover:-translate-y-2 hover:shadow-xl cursor-pointer transition duration-300">
                        <div class="mx-auto">
                            <h3 class="mt-4 text-center text-lg font-bold text-black"><?= $sensor->name ?></h3>
                            <h1 class="pr-20 items-center mt-4 text-lg flex font-medium text-black"> <img class="w-1/10 p-2" src="/resources/ici.webp" alt=""><?= $sensor->location ?></h1>
                            <div>
                                <p class="text-center font-bold text-green-700 text-3xl pt-40"> <?php echo $volume ?> dB</p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>