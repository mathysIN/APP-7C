<?php

require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

$estimates = $estimateAPI->getEstimatesByUser($_CURRENT_USER->user_id);

?>

<div class="mx-auto my-8 max-w-4xl px-4 md:px-0">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold" data-lang="Mes devis|My quotes">Mes devis</h1>
        <a href="/devis"><button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex h-10 items-center justify-center whitespace-nowrap rounded-md bg-eventit-500 px-4 py-2 text-sm font-medium text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50" data-lang="Nouveau devis|New quote"> Nouveau devis </button>
        </a>
    </div>
    <div class="relative w-full overflow-auto">
        <table class="w-full caption-bottom text-sm">
            <thead class="[&amp;_tr]:border-b">
                <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">Date</th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">Référence</th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">Nombre de capteurs</th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">Montant</th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">État du paiement</th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium">Voir</th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                <?php foreach ($estimates as $estimate) : ?>
                    <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                        <td class="p-4"><?php echo $estimate->created_at; ?></td>
                        <td class="p-4 font-medium text-eventit-500"><?php echo $estimate->estimate_id; ?></td>
                        <td class="p-4 font-medium"><?php echo $estimateAPI->getCountSensor($estimate->estimate_id); ?></td>
                        <td class="p-4"><?php echo $estimate->price_amount; ?></td>
                        <td class="p-4">
                            <?php if ($estimate->is_payed) : ?>
                                <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Payé</div>
                            <?php else : ?>
                                <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Non payé</div>
                            <?php endif; ?>
                        </td>
                        <td class="p-4">
                            <a href="/events/<?php echo $estimate->estimate_id ?>" target="_blank">
                                <svg class="text-black h-4 w-4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 488.85 488.85" xml:space="preserve">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <g>
                                            <path d="M244.425,98.725c-93.4,0-178.1,51.1-240.6,134.1c-5.1,6.8-5.1,16.3,0,23.1c62.5,83.1,147.2,134.2,240.6,134.2 s178.1-51.1,240.6-134.1c5.1-6.8,5.1-16.3,0-23.1C422.525,149.825,337.825,98.725,244.425,98.725z M251.125,347.025 c-62,3.9-113.2-47.2-109.3-109.3c3.2-51.2,44.7-92.7,95.9-95.9c62-3.9,113.2,47.2,109.3,109.3 C343.725,302.225,302.225,343.725,251.125,347.025z M248.025,299.625c-33.4,2.1-61-25.4-58.8-58.8c1.7-27.6,24.1-49.9,51.7-51.7 c33.4-2.1,61,25.4,58.8,58.8C297.925,275.625,275.525,297.925,248.025,299.625z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>