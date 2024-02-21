<?php
// MAIN ROUTER

// Cette fonction permet la compatibilité avec Vercel
function getFullPath($path)
{
    $currentDir = __DIR__;
    $fullPath = $currentDir . '/' . $path;
    return $fullPath;
}

function serveStaticResource($uri)
{
    if (file_exists($uri) && is_readable($uri)) {
        $mime = mime_content_type($uri);
        header("Content-Type: $mime");
        readfile($uri);
        return true;
    }
    return false;
}

session_start();
$logged = isset($_SESSION['username']);

$request_uri = $_SERVER['REQUEST_URI'];

$request_uri = strtok($request_uri, '?');
$request_uri = rtrim($request_uri, '/');
$request_uri = '/' . ltrim($request_uri, '/');
error_log("Requesting at $request_uri");

if (strpos($request_uri, '/resources') === 0) {
    if (serveStaticResource(substr($request_uri, 1))) {
        exit;
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
        default:
            break;
    }
}

if (!isset($page_path)) {
    $max = 3;
    for ($i = 0; $i < $max; $i++) {
        switch ($i) {
            case 0:
                $potential_page_page = substr($request_uri, 1);
            case 2:
                $potential_page_page = substr($request_uri, 1) . ".php";
                break;
            case 1:
                $potential_page_page = substr($request_uri, 1) . "/index.php";
                break;
        }
        if (file_exists(getFullPath($potential_page_page))) {
            $page_path = $potential_page_page;
            break;
        };
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

$header_path = getFullPath('../components/header.php');
$footer_path = getFullPath('../components/footer.php');
?>

<!DOCTYPE html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?></title>
    <link href="/resources/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body class="flex flex-col items-center h-screen font-[Montserrat]">
    <?php include $header_path; ?>
    <?php include $page_path; ?>
    <?php include $footer_path; ?>
</body>

</html>