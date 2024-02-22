<?php

require_once __DIR__ . '/../utils/helpers.php';

$markdown = "## Hello, *world*!\n\nThis is a paragraph with a [link](https://example.com).";
$html = markdown_to_html($markdown);

?>

<div> <?php echo $html; ?> </div>