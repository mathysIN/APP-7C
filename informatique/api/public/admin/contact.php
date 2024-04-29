<?php

require __DIR__ . "/../../entities/all_entites.php";  
require_once __DIR__ . "/../../utils/helpers.php";
require_once __DIR__ . "/../../entities/contact_messages.php";  

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contact_id = $_POST["contact_id"];
    $action = $_POST["action"];

    if ($action === "delete") {
        $contactAPI->deleteContact($contact_id);
        redirect('/admin/contact?msg=contact_deleted');
        exit();
    }

    if ($action === "modify") {
        $new_email = $_POST["new_email"];
        $new_phone_number = $_POST["new_phone_number"];
        error_log("Contact $contact_id modified: new email - $new_email, new phone - $new_phone_number");

        $contactAPI->updateContact($contact_id, $new_email, $new_phone_number);
        redirect('/admin/contact?msg=contact_modified');
        exit();
    }
}

$contacts = $contactAPI->getAllContacts();
?>

<div class="flex flex-col w-full">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6">
        <div class="flex-1">
            <h1 class="font-semibold text-lg">Contact Management</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage your contacts
            </p>
        </div>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Created At</th>
                            <th class="px-4 py-2 text-left">Full Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Phone</th>
                            <th class="px-4 py-2 text-left">Organization</th>
                            <th class="px-4 py-2 text-left">Message</th>
                            <th class="px-4 py-2 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contacts as $contact) : ?>
                            <tr class="border-b">
                                <td class="px-4 py-2"><?php echo $contact->contact_id ?></td>
                                <td class="px-4 py-2"><?php echo $contact->created_at ?></td>
                                <td class="px-4 py-2"><?php echo $contact->fullname ?></td>
                                <td class="px-4 py-2"><?php echo $contact->email ?></td>
                                <td class="px-4 py-2"><?php echo $contact->phone_number ?></td>
                                <td class="px-4 py-2"><?php echo $contact->organization ?></td>
                                <td class="px-4 py-2"><?php echo $contact->message ?></td>
                                <td class="px-4 py-2 text-right">
                                    <form action="contact" method="POST">
                                        <input type="hidden" name="contact_id" value="<?php echo $contact->contact_id; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>