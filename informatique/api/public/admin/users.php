<?php

require __DIR__ . "/../../entities/all_entites.php";
require_once __DIR__ . "/../../utils/helpers.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST["user_id"];
    $action = $_POST["action"];
    if ($action === "delete") {
        $userAPI->deleteUser($id);
        redirect('/admin/users?msg=user_deleted');
        exit();
    }
}
$users = $userAPI->getAllUsers();
?>

<div class="flex flex-col w-full">
    <header class="flex h-14 lg:h-[60px] items-center gap-4 border-b px-6"><a class="lg:hidden" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                <path d="M12 3v6"></path>
            </svg><span class="sr-only">Home</span></a>
        <div class="flex-1">
            <h1 class="font-semibold text-lg">User Management</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Manage your users
            </p>
        </div>
    </header>
    <main class="flex flex-1 flex-col gap-4 p-4 md:gap-8 md:p-6">
        <div class="border shadow-sm rounded-lg">
            <div class="relative w-full overflow-auto">
                <table class="w-full caption-bottom text-sm">
                    <thead class="[&amp;_tr]:border-b">
                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground w-[100px]">ID</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground min-w-[150px]">Name</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Email</th>
                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground hidden md:table-cell">Role</th>
                            <th class="h-12 px-4 align-middle font-medium text-muted-foreground text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="[&_tr:last-child]:border-0">
                        <?php foreach ($users as $key => $user) : ?>
                            <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                <td class="p-4 align-middle font-medium"><?php echo $user->user_id ?></td>
                                <td class="p-4 align-middle [&:has([role=checkbox])]:pr-0">
                                    <?php echo "$user->first_name $user->last_name"; ?>
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell">
                                    <?php echo $user->email; ?>
                                </td>
                                <td class="p-4 align-middle hidden md:table-cell"><?php echo $user->role; ?></td>
                                <td class="p-4 align-middle text-right">
                                    <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                            <path d="M4 13.5V4a2 2 0 0 1 2-2h8.5L20 7.5V20a2 2 0 0 1-2 2h-5.5"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <path d="M10.42 12.61a2.1 2.1 0 1 1 2.97 2.97L7.95 21 4 22l.99-3.95 5.43-5.44Z"></path>
                                        </svg>
                                        <span class="sr-only">Edit</span>
                                    </button>
                                    <form action="users" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $user->user_id; ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 hover:bg-accent hover:text-accent-foreground w-8 h-8"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path>
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path>
                                            </svg>
                                            <span class="sr-only">Delete</span>
                                        </button>
                                    </form>
                                </td>
                                </form>
                            </tr>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>