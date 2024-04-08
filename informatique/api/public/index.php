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
                <div class="flex sm:flex-row flex-col min-h-screen w-full">
                    <div class="border- lg:block ">
                        <div class="flex min-w-64 h-full max-h-screen flex-col gap-2">
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
                                    <a href="/admin/legal" class="flex items-center gap-3 rounded-lg px-3 py-2 text-gray-500 transition-all" href="#" rel="ugc"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-4 w-4">
                                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z"></path>
                                            <polyline points="14 2 14 8 20 8"></polyline>
                                            <line x1="16" x2="8" y1="13" y2="13"></line>
                                            <line x1="16" x2="8" y1="17" y2="17"></line>
                                            <line x1="10" x2="8" y1="9" y2="9"></line>
                                        </svg>
                                        Legal
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
                                    <a href="/" class="flex items-center gap-3 rounded-lg px-3 py-2 text-red-500 transition-all" href="#">
                                        <svg fill="#f04b4b" class="h-4 w-4" version="1.2" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="-1077 923 256 256" xml:space="preserve">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <g>
                                                    <path d="M-934.7,1039.4c-0.2,0-0.3,0-0.5,0.1c-0.1,0-0.1,0-0.2-0.1l-23.4,3.5l-13.3-29.3c-1.8-3.6-4-6.6-6.7-8.9 c-1.1-1.1-2.5-2.1-3.9-3c-1.5-0.8-3-1.4-4.7-1.7c-4.3-1-8.2-0.4-11.8,1.7l-29.3,13.7c-2,1.3-3.9,1.8-4.4,2.1 c-3,2.1-3.5,3.2-3.9,3.9l-14.8,28.3c-0.1,0.3-0.2,0.6-0.3,0.8c-0.5,1.1-0.9,2.3-0.9,3.6c0,1.3,0.4,2.6,0.9,3.7c0.7,1.8,2,3,3.7,3.5 c1,0.5,2.2,0.8,3.4,0.8c3.2,0,5.9-1.9,7.2-4.5c0.1-0.2,0.2-0.3,0.3-0.5c9.2-17.2,13.8-25.9,13.8-26.1l15.7-3.7l-18.8,79.1 l-35.9-0.3c-0.1,0-0.1,0-0.2,0c-0.1,0-0.1,0-0.2,0c-4.7,0-8.6,3.8-8.6,8.6c0,4.4,3.3,7.9,7.5,8.5v0.1l10,0 c7.8,0.4,30.7,1.4,37.7,0.6c0.2,0,0.4,0.1,0.7,0.1c3.9,0,7.1-2.8,7.8-6.4l5.4-15.8l0,0c3.6-10.3,6-20.4,6-20.4 c9.4,9.9,16.4,16.3,22.8,23l11,36.1l2.3,8.7l0.1,0c1.2,3.8,4.7,6.6,8.9,6.6c5.2,0,9.4-4.2,9.4-9.4c0-0.7-0.1-1.5-0.3-2.2l-0.7-2.7 c0,0,0-0.1,0-0.1l-2-7.5l-2-7.4l0,0l-8.1-30c-1.1-2.8-2.1-5.5-4.4-8.1c0,0-22.5-25-23.1-25.3l5.1-24.2l7.1,15.1 c0.1,0.1,0.2,0.3,0.3,0.4c0.5,0.7,0.9,1.3,1.3,1.7c1.4,1.4,3.3,2.2,5.3,2.2c0.1,0,0.1,0,0.2,0c0.6,0,1.2-0.1,1.8-0.2l26.3-2.9 c0.1,0,0.2,0,0.2,0c0.7,0,1.3-0.1,1.9-0.3l0.4,0c0.1,0,0.1-0.1,0.2-0.1c3.1-1.1,5.4-4,5.4-7.4 C-926.8,1043-930.3,1039.4-934.7,1039.4z"></path>
                                                    <path d="M-984.2,995.1c4.4,0,8.2-1.6,11.3-4.7c3.1-3.1,4.7-6.8,4.7-11.1c0-4.4-1.6-8.2-4.7-11.3c-3.1-3.1-6.9-4.7-11.3-4.7 c-4.3,0-8,1.6-11.1,4.7c-3.1,3.1-4.7,6.9-4.7,11.3c0,4.3,1.6,8,4.7,11.1C-992.2,993.6-988.5,995.1-984.2,995.1z"></path>
                                                    <path d="M-897.2,948.6V1145l72.6,31.8V925.2L-897.2,948.6z M-886.1,1055.8c-1.4,0-2.6-4.4-2.6-9.8s1.2-9.8,2.6-9.8 c1.4,0,2.6,4.4,2.6,9.8S-884.6,1055.8-886.1,1055.8z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Retourner au site
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
        messages.set("forum_closed", "Le forum est fermé.");
        messages.set("need_admin", "Vous devez être administrateur pour accéder à cette page.");
        messages.set("sensor_deleted", "Capteur supprimé.");
        messages.set("estimate_deleted", "Devis supprimé.");
        messages.set("estimate_updated", "Devis mis à jour.");

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