<?php
// MAIN ROUTER

require_once __DIR__ . "/../utils/helpers.php";
require_once __DIR__ . "/../utils/global_types.php";

session_start();

if (!isset($_SESSION['old_logo']) || !isset($_SESSION['color'])) {
    require_once __DIR__ . "/../entities/all_entites.php";
    $website_data = $websiteDataAPI->getWebsiteData();
    $_SESSION['old_logo'] = $website_data->old_logo;
    $_SESSION['color'] = $website_data->primary_color;
}

$color = $_SESSION['color'] ?: "#38a2a7";
$old_logo = $_SESSION['old_logo'] ?: false;

function getFullPath($path)
{
    $currentDir = __DIR__;
    $fullPath = $currentDir . '/' . $path;
    return $fullPath;
}

/**
 * @param string $uri
 * @param WebsiteData $website_data
 */
function serveStaticResource($uri, $old_logo)
{
    if (file_exists($uri) && is_readable($uri)) {

        $filename = basename($uri);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));

        if ($old_logo && $uri === 'resources/logo-event-it.webp') {
            $uri = 'resources/logo-event-it-old.webp';
        }

        switch ($file_extension) {
            case "gif":
            case "png":
            case "jpeg":
            case "jpg":
            case "webp":
            case "svg":
                $ctype = "image/" . $file_extension;
                break;
            case "css":
                $ctype = "text/" . $file_extension;
            default:
        }

        header('Content-type: ' . $ctype);
        readfile($uri);
        return true;
    }
    return false;
}

$request_uri = $_SERVER['REQUEST_URI'];

$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');
$request_uri = '/' . ltrim($request_uri, '/');
$need_auth = false;
$need_admin = false;
error_log("Requesting at $request_uri");

if (strpos($request_uri, '/resources') === 0) {
    if (serveStaticResource(substr($request_uri, 1), $old_logo)) {
        exit();
    } else {
        http_response_code(404);
        $page_path = 'not_found.php';
    }
} else {
    switch ($request_uri) {
        case '/':
            $page_title = 'Accueil';
            $page_path = 'home.php';
            break;
        case '/login':
            $page_title = 'Connexion';
            break;
        case '/create_account':
            $page_title = 'Création de compte';
            break;
        case '/contact':
            $page_title = 'Contact';
            break;
        case '/capteur':
        case '/capteurs':
        case '/mes_capteurs':
            $need_auth = true;
            $page_title = 'Mes capteurs';
            break;
        case '/forum/create_post':
            $need_auth = true;
            break;
        case '/mes_devis':
            $need_auth = true;
            $page_title = 'Mes devis';
            break;
        default:
            break;
    }

    if (starts_with($request_uri, "/sensor/")) {
        $need_auth = true;
        $page_path = 'capteur.php';
    }
    if (starts_with($request_uri, "/admin/")) {
        $need_auth = true;
        $need_admin = true;
    }
}

if (!isset($page_path)) {
    for ($i = 0; $i < 4; $i++) {
        switch ($i) {
            case 0:
                $potential_page_page = substr($request_uri, 1);
                break;
            case 1:
                $potential_page_page = substr($request_uri, 1) . ".php";
                break;
            case 2:
                $potential_page_page = substr($request_uri, 1) . "/index.php";
                break;
            case 3:
                $parts = explode("/", $request_uri);
                // Get the directory part of the URI (everything except the last part)
                $directory = implode("/", array_slice($parts, 0, -1));
                $directory = substr($directory, 1);
                $query = end($parts);
                $potential_page_page =  $directory . "/[query]" . ".php";
                break;
        }
        error_log("Trying $potential_page_page");

        $temp_full_path = getFullPath($potential_page_page);
        if (file_exists($temp_full_path) && is_file($temp_full_path)) {
            error_log("Found page at $potential_page_page");
            $page_path = $potential_page_page;
            break;
        }
    }
}

if (!isset($page_path)) {
    http_response_code(404);
    $page_path = 'not_found.php';
}

if (!isset($page_title)) {
    $page_title = "EVENT-IT";
} else {
    $page_title = $page_title . " - EVENT-IT";
}

$session_token = $_SESSION['session'] ?? null;

if ($session_token) {
    require_once __DIR__ . "/../entities/all_entites.php";

    $_CURRENT_USER = $userAPI->getUserByToken($session_token);
}

$header_path = getFullPath('../components/header.php');
$footer_path = getFullPath('../components/footer.php');

if ($need_auth && !$_CURRENT_USER) {
    if ($need_admin) {
        redirect('/login?msg=need_admin');
    } else {
        redirect('/login');
    }
    exit();
}
?>

<!DOCTYPE html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $page_title ?>
    </title>
    <link href="/resources/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/resources/favicon.png">
    <?php if (isset($color)) { ?>
        <style>
            <?php
            for ($i = 300; $i <= 900; $i += 100) {
                echo ".text-eventit-$i { color: $color }";
                echo ".bg-eventit-$i { background-color: $color }";
                echo ".hover\\:text-eventit-$i:hover { color: $color }";
                echo ".hover\\:bg-eventit-$i:hover { background-color: $color }";
            }

            for ($i = 1; $i <= 6; $i++) {
                echo "h$i { color: $color }";
            }
            ?>
        </style>
    <?php } ?>
</head>

<body class="flex flex-col min-h-screen font-[Montserrat]">
    <?php
    if (!$need_admin) { ?>
        <?php include $header_path; ?>
        <div class="content w-full">
            <?php include $page_path; ?>
        </div>
        <?php include $footer_path; ?>
    <?php } else { ?>
        <div class="content w-full">
            <div class="p-2">
                <div class="grid min-h-screen w-full lg:grid-cols-[280px_1fr]">
                    <div class="border- lg:block ">
                        <div class="flex h-full max-h-screen flex-col gap-2">
                            <div class="flex h-[60px] items-center border-b px-6"><a class="flex items-center gap-2 font-semibold" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                                        <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                                        <path d="M12 3v6"></path>
                                    </svg><span class="">Back-office</span></a></div>
                            <div class="flex-1 overflow-auto py-2">
                                <nav class="grid items-start px-4 text-sm font-medium">
                                    <a href="/admin/general" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                        </svg>
                                        Général
                                    </a>
                                    <a href="/admin/users" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                        Utilisateurs
                                    </a>
                                    <a href="/admin/faq" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <line x1="10" x2="8" y1="9" y2="9"></line>
                                        </svg>
                                        FAQ
                                    </a>
                                    <a href="/admin/cgu" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <line x1="10" x2="8" y1="9" y2="9"></line>
                                        </svg>
                                        CGU
                                    </a>
                                    <a href="/admin/devis" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <line x1="10" x2="8" y1="9" y2="9"></line>
                                        </svg>
                                        Devis
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <?php include $page_path; ?>
                </div>
            </div>
        </div>
    <?php }
    ?>
    <div id="toast-container" class="fixed top-5 left-5 z-10">
    </div>

    <script>
        const messages = new Map();

        messages.set("user_created", "Compte créé avec succès !");
        messages.set("logged_in", "Connecté avec succès !");
        messages.set("invalid_credentials", "Identifiants invalides.");
        messages.set("cannot_create_user", "Impossible de créer le compte.");
        messages.set("error_sending_estimate", "Erreur lors de l'envoi du devis.");
        messages.set("post_missing_fields", "Veuillez remplir tous les champs.");
        messages.set("logged_out", "Déconnexion réussie.");
        messages.set("post_deleted", "Post supprimé.");
        messages.set("invalid_editing", "Impossible de modifier ce post.");

        function getUrlParams(url) {
            const params = {};
            const urlSearchParams = new URLSearchParams(url);
            for (const [key, value] of urlSearchParams) {
                params[key] = value;
            }
            return params;
        }

        function createToast(message) {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.id = 'toast-default';
            toast.className = 'z-50 flex items-center w-full max-w-xs p-4 text-gray-800 bg-gray-200 rounded-lg shadow toast-fade-in';
            toast.role = 'alert';
            toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg">
                <img class="w-4 h-4" src="/resources/logo-event-it-clean.png"/>
                <span class="sr-only">Fire icon</span>
            </div>
            <div class="ms-3 text-sm font-normal mr-4">${message}</div>
            <button type="button" class="ms-auto ml-4 mx-2 -my-1.5 bg-gray-300 text-gray-600 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-300 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-default" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        `;
            toastContainer.appendChild(toast);

            const closeButton = toast.querySelector('button');
            closeButton.addEventListener('click', function() {
                toast.classList.remove('toast-fade-in');
                toast.classList.add('toast-fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            });

            // Automatically remove toast after 5 seconds
            setTimeout(() => {
                toast.classList.remove('toast-fade-in');
                toast.classList.add('toast-fade-out');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = getUrlParams(window.location.search);
            if (urlParams.hasOwnProperty('msg')) {
                const messageTag = urlParams['msg'];
                const message = messages.get(messageTag);
                if (message) createToast(message);
            }
        });
    </script>


</body>

</html>