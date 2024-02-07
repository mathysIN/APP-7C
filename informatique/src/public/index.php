<?php
// MAIN ROUTER
$request_uri = $_SERVER['REQUEST_URI'];

$request_uri = strtok($request_uri, '?');

$header_path = '../components/header.php';
$footer_path = '../components/footer.php';

$page_title = "EVENT - IT";

switch ($request_uri) {
    case '/':
        $page_path = 'home.php';
        break;
    case '/login':
        $page_path = 'login.php';
        $page_title = 'Connexion';
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
    <link href="style.css" rel="stylesheet">
</head>

<body class="flex flex-col items-center h-screen font-[Montserrat]">
    <?php include $header_path; ?>
    <?php include $page_path; ?>
    <?php include $footer_path; ?>
</body>

</html>