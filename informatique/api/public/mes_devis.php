<?php

require __DIR__ . "/../entities/all_entites.php";
require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

$estimates = $estimateAPI->getEstimatesByUser($_CURRENT_USER->user_id);

?>

<div class="mx-auto my-8 max-w-4xl px-4 md:px-0">
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-semibold"data-lang="Mes devis|My quotes">Mes devis</h1>
        <a href="/devis"><button class="ring-offset-background focus-visible:ring-ring hover:bg-primary/90 inline-flex h-10 items-center justify-center whitespace-nowrap rounded-md bg-eventit-500 px-4 py-2 text-sm font-medium text-white transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50"data-lang="Nouveau devis|New quote"> Nouveau devis </button>
        </a>
    </div>
    <div class="relative w-full overflow-auto">
        <table class="w-full caption-bottom text-sm">
            <thead class="[&amp;_tr]:border-b">
                <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Date </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Référence </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Nombre de capteurs </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Montant </th>
                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du paiement </th>
                </tr>
            </thead>
            <tbody class="[&amp;_tr:last-child]:border-0">
                <?php foreach ($estimates as $estimate) : ?>

                    <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                        <td class="p-4"><?php echo $estimate->created_at; ?></td>
                        <td class="p-4 font-medium text-eventit-500"><?php echo $estimate->estimate_id; ?></td>
                        <td class="p-4 font-medium"><?php echo 0; ?></td>
                        <td class="p-4"><?php echo $estimate->price_amount; ?></td>
                        <td class="p-4">
                            <?php if ($estimate->is_payed) : ?>
                                <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Payé</div>
                            <?php else : ?>
                                <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Non payé</div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>