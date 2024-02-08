<?php
// MAIN ROUTER

// Cette fonction permet la compatibilité avec Vercel
function getFullPath($path)
{
    $currentDir = __DIR__;
    $fullPath = $currentDir . '/' . $path;
    return $fullPath;
}

$request_uri = $_SERVER['REQUEST_URI'];

$request_uri = strtok($request_uri, '?');

$header_path = getFullPath('../components/header.php');
$footer_path = getFullPath('../components/footer.php');

$page_title = "EVENT - IT";

switch ($request_uri) {
    case '/':
        $page_path = 'home.php';
        break;
    case '/login':
        $page_path = 'login.php';
        $page_title = 'Connexion';
        break;
    case '/create_account':
        $page_path = 'create_account.php';
        $page_title = 'Création de compte';
        break;
    case '/contact':
        $page_path = 'contact.php';
        break;
    default:
        http_response_code(404);
        $page_path = 'not_found.php';
}
?>

<!DOCTYPE html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?></title>
    <link href="resources/style.css" rel="stylesheet">
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