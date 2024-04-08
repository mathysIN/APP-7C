<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

$estimates = $estimateAPI->getAllEstimates();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["type"] === "update_estimate") {

        if (!isset($_POST['payment']) || !isset($_POST['estimate_id']) || !isset($_POST['add_sensor_count']) || !isset($_POST['price_amount'])) {
            echo "Veuillez remplir tous les champs";
            exit();
        }

        $payment = $_POST['payment'];
        $estimate_id = $_POST['estimate_id'];
        $add_sensor_count = $_POST['add_sensor_count'];
        $price_amount = $_POST['price_amount'];
        $estimateAPI->updateEstimate($estimate_id, $price_amount, $payment);

        if (isset($_POST['user_id'])) {
            $estimateAPI->updateEstimateUser($estimate_id, $_POST['user_id']);
        } else {
            $estimateAPI->updateEstimateUser($estimate_id, null);
        }

        if ($add_sensor_count > 0) {
            $estimate = $estimateAPI->getEstimateById($estimate_id);
            for ($i = 0; $i < $add_sensor_count; $i++) {
                $sensorAPI->createSensor($estimate->estimate_id, "Capteur de son", "Salle n°1", "");
            }
        }
        redirect('/admin/devis?msg=estimate_updated');
        exit();
    }

    if ($_POST["type"] === "delete_estimate") {
        if (!isset($_POST['estimate_id'])) {
            echo "Veuillez remplir tous les champs";
            exit();
        }

        $estimate_id = $_POST['estimate_id'];
        $estimateAPI->deleteEstimate($estimate_id);

        redirect('/admin/devis?msg=estimate_deleted');
        exit();
    }
}
?>

<div class="flex flex-col w-full">
    <header class=" flex h-14 lg:h-[60px] items-center gap-4 border-b px-6">
        <a class="lg:hidden" href="#" rel="ugc">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.79 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg>
            <span class="sr-only">Maison</span>
        </a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg" data-lang>Options générales</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Gérer les options du site
            </p>
        </div>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&amp;_tr]:border-b">
                        <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Date </th>
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Référence </th>
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Utilisateur </th>
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Montant </th>
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> État du paiement </th>
                            <th class="text-muted-foreground h-12 px-4 text-left align-middle font-medium"> Action </th>
                        </tr>
                    </thead>
                    <div id="backdrop" class="backdrop" onclick="closeAllPopups()"></div>

                    <tbody class="[&amp;_tr:last-child]:border-0">
                        <?php foreach ($estimates as $estimate) : ?>
                            <tr class="hover:bg-muted/50 data-[state=selected]:bg-muted border-b transition-colors">
                                <td class="p-4"><?php echo $estimate->created_at; ?></td>
                                <td class="p-4 font-medium text-eventit-500"><?php echo $estimate->estimate_id; ?></td>
                                <td class="p-4 font-medium text-eventit-500"><?php echo $estimate->user_id; ?></td>
                                <td class="p-4"><?php echo $estimate->price_amount; ?></td>
                                <td class="p-4">
                                    <?php if ($estimate->is_payed) : ?>
                                        <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-green-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Payé</div>
                                    <?php else : ?>
                                        <div class="focus:ring-ring hover:bg-secondary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-red-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2">Non payé</div>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4">
                                    <button onclick="openPopup('<?php echo $estimate->estimate_id ?>')" class="focus:ring-ring hover:bg-primary/80 inline-flex w-fit items-center whitespace-nowrap rounded-full border border-transparent bg-yellow-500 px-2.5 py-0.5 text-xs font-semibold text-white transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2"> Modifier </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="">
                                    <div id="<?php echo $estimate->estimate_id ?>" class="popup-content">

                                        <div class="popup-header">
                                            <div class="flex flex-row items-center gap-2">
                                                <h2>Modifier le capteur</h2>
                                                <button class=" text-2xl md:text-4xl font-bold" onclick="closeAllPopups()">&times;</button>
                                            </div>
                                        </div>
                                        <div class="popup-body
                                            ">
                                            <p>Description : <?php echo $estimate->content ?: "Pas de description"; ?></p>
                                            <form class="flex flex-col gap-2 w-fit mx-auto" action="" method="post">
                                                <label for="payment">Statut du paiement</label>
                                                <select name="payment" id="payment">
                                                    <option value="1">Payé</option>
                                                    <option value="2">Non payé</option>
                                                </select>
                                                <label for="user_id">Utilisateur (ID)</label>
                                                <input type="text" name="user_id" id="user_id" value="<?php echo $estimate->user_id; ?>">
                                                <label for="add_sensor_count">Nombre de capteurs à ajouter</label>
                                                <input type="number" name="add_sensor_count" id="add_sensor_count" value="0">
                                                <label for="price_amount">Montant</label>
                                                <input type="number" name="price_amount" id="price_amount" value="<?php echo $estimate->price_amount ?: 0; ?>">
                                                <input type="hidden" name="type" value="update_estimate">
                                                <input type="hidden" name="estimate_id" value="<?php echo $estimate->estimate_id ?>">
                                                <button class="inline-flex w-64 mt-8 px-8 py-2 capitalize font-medium text-white bg-eventit-500 rounded-3xl justify-center hover:bg-eventit-500 button" type="submit">Modifier</button>

                                            </form>

                                            <form method="post">
                                                <input type="hidden" name="type" value="delete_estimate">
                                                <input type="hidden" name="estimate_id" value="<?php echo $estimate->estimate_id ?>">
                                                <button class="inline-flex w-64 mt-8 px-8 py-2 capitalize font-medium text-white bg-red-500 rounded-3xl justify-center hover:bg-red-500 button" type="submit">Supprimer</button>
                                            </form>
                                            <p class="my-4>">Capteurs :</p>
                                            <?php
                                            $sensors = $estimateAPI->getSensorsByEstimate($estimate->estimate_id);
                                            foreach ($sensors as $sensor) : ?>
                                                <a href="/capteurs/<?= $sensor->sensor_id ?>">
                                                    <div class="flex flex-col gap-2 bg-eventit-400 p-2 rounded-lg">
                                                        <span class="text-white">Capteur : <?= $sensor->name ?> (<?= $sensor->location ?>)</span>
                                                    </div>
                                                </a>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>




<script>
    function openPopup(popupId) {
        closeAllPopups();
        document.getElementById(popupId).style.display = 'block';

        document.getElementById(popupId).classList.add("fade-in");

        document.getElementById('backdrop').style.display = 'block';
    }

    function closePopup(popupId) {
        document.getElementById(popupId).style.display = 'none';
        document.getElementById('backdrop').style.display = 'none';
    }

    function closeAllPopups() {
        var popups = document.querySelectorAll('.popup-content');
        for (var i = 0; i < popups.length; i++) {
            popups[i].style.display = 'none';
        }
        document.getElementById('backdrop').style.display = 'none';
    }


    function toggleVisibility(row) {
        var nextRow = row.nextElementSibling;
        nextRow.classList.toggle("hidden");
    }

    function openStatusModal(estimateId) {
        // Open the modal and pass estimateId if needed
        document.getElementById('statusModal').style.display = "block";
    }

    function closeStatusModal() {
        // Close the modal
        document.getElementById('statusModal').style.display = "none";
    }
</script>