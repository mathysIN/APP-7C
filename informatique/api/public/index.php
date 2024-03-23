<?php
// MAIN ROUTER

require_once __DIR__ . "/../utils/helpers.php";

function getFullPath($path)
{
    $currentDir = __DIR__;
    $fullPath = $currentDir . '/' . $path;
    return $fullPath;
}

function serveStaticResource($uri)
{
    if (file_exists($uri) && is_readable($uri)) {

        $filename = basename($uri);
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));

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

session_start();
$request_uri = $_SERVER['REQUEST_URI'];

$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');
$request_uri = '/' . ltrim($request_uri, '/');
$need_auth = false;
error_log("Requesting at $request_uri");

if (strpos($request_uri, '/resources') === 0) {
    if (serveStaticResource(substr($request_uri, 1))) {
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
        case '/mes_devis':
            $need_auth = true;
            $page_title = 'Mes devis';
            break;
        default:
            break;
    }

    // starts with /sensor/
    if (strpos($request_uri, "/capteurs/") === 0 && strlen($request_uri) > strlen("/capteurs/")) {
        $need_auth = true;
        $page_path = 'capteur.php';
    }
}

if (!isset ($page_path)) {
    for ($i = 0; $i < 3; $i++) {
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
        }
        if (file_exists(getFullPath($potential_page_page))) {
            $page_path = $potential_page_page;
            break;
        }
    }
}

if (!isset ($page_path)) {
    http_response_code(404);
    $page_path = 'not_found.php';
}

if (!isset ($page_title)) {
    $page_title = "EVENT-IT";
} else {
    $page_title = $page_title . " - EVENT-IT";
}


require_once __DIR__ . "/../entities/all_entites.php";

$session_token = $_SESSION['session'] ?? null;

global $_CURRENT_USER;
$_CURRENT_USER = null;
if ($session_token) {
    $_CURRENT_USER = $userAPI->getUserByToken($session_token);
}

$header_path = getFullPath('../components/header.php');
$footer_path = getFullPath('../components/footer.php');

if ($need_auth && !$_CURRENT_USER) {
    redirect('/login');
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/resources/favicon.png">
</head>

<body class="flex flex-col min-h-screen font-[Montserrat]">
    <?php include $header_path; ?>
    <div class="content w-full">
        <?php include $page_path; ?>
    </div>
    <?php include $footer_path; ?>

    <div id="toast-container" class="fixed top-5 left-5 z-10">
    </div>

    <script>
        const messages = new Map();

        messages.set("user_created", "Compte créé avec succès !");
        messages.set("logged_in", "Connecté avec succès !");
        messages.set("invalid_credentials", "Identifiants invalides.");
        messages.set("cannot_create_user", "Impossible de créer le compte.");

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
            toast.className = 'z-50 flex items-center w-full max-w-xs p-4 text-gray-800 bg-gray-200 rounded-lg shadow toast-fade-in'; // lighter colors
            toast.role = 'alert';
            toast.innerHTML = `
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-blue-500 bg-blue-100 rounded-lg">
                <img class="w-4 h-4" src="resources/logo-event-it-clean.png"/>
                <span class="sr-only">Fire icon</span>
            </div>
            <div class="ms-3 text-sm font-normal">${message}</div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-gray-300 text-gray-600 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-300 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#toast-default" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
        `;
            toastContainer.appendChild(toast);

            const closeButton = toast.querySelector('button');
            closeButton.addEventListener('click', function () {
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

        document.addEventListener('DOMContentLoaded', function () {
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