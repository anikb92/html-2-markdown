<!-- converter.php -->
<?php

// To store output
session_start();

function startsAndEndsWithAnchor($str)
{
    $start = substr($str, 0, 3);
    $end = substr($str, -4);
    return $start === "<a " && $end === "</a>";
}

function convertMarkdownToHTML($markdown) {
    // Convert headers
    $markdown = preg_replace('/^###### (.+)$/m', "<h6>$1</h6>", $markdown);
    $markdown = preg_replace('/^## (.+)$/m', "<h2>$1</h2>", $markdown);
    $markdown = preg_replace('/^# (.+)$/m', "<h1>$1</h1>", $markdown);

    // Handle ellipsis
    // $markdown = preg_replace('/\.{3}/', "...", $markdown);

    // Convert links
    $markdown = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', "<a href='$2'>$1</a>", $markdown);

    // Convert paragraphs
    $lines = explode("\r\n", $markdown);
    var_dump($lines);
    $to_convert = [];
    $concatenatedString = "";
    foreach ($lines as $line) {
        if (preg_match('/^\.+$/', $line) === 1 || startsAndEndsWithAnchor($line)) {
            $to_convert[] = $line;
        } else if ($line !== "") {
            $concatenatedString .= $line;
        } else if ($concatenatedString !== "") {
            $to_convert[] = $concatenatedString;
            $concatenatedString = "";
        }
    }
    if ($concatenatedString !== "") {
        $to_convert[] = $concatenatedString;
    }
    $markdown = "";
    foreach ($to_convert as $line) {
        if (preg_match('/^\.+$/', $line) === 1 || startsAndEndsWithAnchor($line)) {
            $markdown .= $line;
            continue;
        }
        $line = preg_replace('/^(?!(<h[1-6]>)).+$/m', "<p>$0</p>", $line);
        $markdown .= preg_replace('/<\/p>\n<p>/', " ", $line);
    }

    return $markdown;
}

$input = "";
$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST["input"];
    $output = convertMarkdownToHTML($input);

    $_SESSION["input"] = $input;
    $_SESSION["output"] = $output;

    // Redirect to index.php
    header("Location: index.php");
    exit();
}
?>
