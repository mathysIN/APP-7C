<?php
function markdown_to_html($markdown)
{
    // Convert headers
    $markdown = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $markdown);
    $markdown = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $markdown);
    $markdown = preg_replace('/^#### (.+)$/m', '<h4>$1</h4>', $markdown);
    $markdown = preg_replace('/^##### (.+)$/m', '<h5>$1</h5>', $markdown);
    $markdown = preg_replace('/^###### (.+)$/m', '<h6>$1</h6>', $markdown);

    // Convert bold and italic
    $markdown = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/__(.*?)__/s', '<strong>$1</strong>', $markdown);
    $markdown = preg_replace('/\*(.*?)\*/s', '<em>$1</em>', $markdown);
    $markdown = preg_replace('/_(.*?)_/s', '<em>$1</em>', $markdown);

    // Convert inline code
    $markdown = preg_replace('/`(.*?)`/s', '<code>$1</code>', $markdown);

    // Convert links
    $markdown = preg_replace('/\[(.*?)\]\((.*?)\)/s', '<a href="$2">$1</a>', $markdown);

    // Convert paragraphs
    $markdown = '<p>' . preg_replace('/\n\s*\n/', '</p><p>', $markdown) . '</p>';

    return $markdown;
}

function redirect($path)
{
    // Another Vercel fix ¯\_(ツ)_/¯ 
    echo "<script>window.location='$path';</script>";
}

function set_cookie($name, $value)
{
    // this can really be unsafe
    echo "<script>document.cookie = \"$name = $value;path=/\"</script>";
}
