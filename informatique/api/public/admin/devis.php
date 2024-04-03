<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

$estimates = $estimateAPI->getAllEstimates();
?>

<div class="flex flex-col">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg><span class="sr-only">Maison</span></a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg"data-lang>Options générales</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gérer les options du site
            </p>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <div class="border shadow-sm rounded-lg p-4">

                    <div class="relative w-full overflow-auto">
                        <table class="w-full caption-bottom text-sm">
                            <thead class="[&amp;_tr]:border-b">
                                <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Date </th>
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Référence </th>
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Nombre de capteurs </th>
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Montant </th>
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du paiement </th>
                                    <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du devis </th>
                                </tr>
                            </thead>
                            <tbody class="[&amp;_tr:last-child]:border-0">
                                <?php foreach ($estimates as $estimate) : ?>
                                    <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                                        <td class="p-4"><?php echo "$estimate->created_at"; ?></td>
                                        <td class="p-4 font-medium text-eventit-500"><?php echo "$estimate->estimate_id"; ?></td>
                                        <td class="p-4"><?php echo "$estimate->name"; ?></td>
                                        <td class="p-4"><?php echo "$estimate->price_amount"; ?></td>
                                        <td class="p-4">
                                            <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"><?php echo $estimate->is_payed ? "Payé" : "Non payé"; ?></div>
                                        </td>
                                        <td class="[&amp;:has([role=checkbox])]:pr-0 p-4 align-middle">
                                            <div class="focus:ring-ring hover:bg-primary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-yellow-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"> En cours </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </mai