<!-- converter.php -->
<?php

// To store output
session_start();

// Removes leading and trailing white spaces and any new line, carriage return characters
function clean(string $str): string {
    $str = trim($str);
    $str = str_replace(array("\r", "\n"), '', $str);
    return $str;
}

function convertMarkdownToHTML(string $markdown): string {
    // Limit to 5000 characters
    $markdown = substr($markdown, 0, 5000);

    // -----------Sanitize input-----------
    $markdown = trim($markdown);
    $markdown = htmlspecialchars($markdown);

    // -----------Convert headers----------
    $markdown = preg_replace('/^###### (.+)$/m', "<h6>$1</h6>", $markdown);
    $markdown = preg_replace('/^## (.+)$/m', "<h2>$1</h2>", $markdown);
    $markdown = preg_replace('/^# (.+)$/m', "<h1>$1</h1>", $markdown);

    //------------Convert links------------
    $markdown = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', "<a href=\"$2\">$1</a>", $markdown);

    //-------- Convert paragraphs----------
    // Break into lines
    $lines = explode("\r\n", $markdown);

    // Group consecutive lines together
    $toConvert = [];
    $concatenatedString = [];
    foreach ($lines as $line) {
        $line = clean($line);
        if (preg_match('/^\.+$/', $line) === 1) {
            $toConvert[] = $line."\n";
        } else if ($line !== "") {
            $concatenatedString[] = $line."\n";
        } else if (!empty($concatenatedString)) {
            $toConvert[] = implode("", $concatenatedString)."\n";
            $concatenatedString = [];
        }
    }
    if (!empty($concatenatedString)) {
        $toConvert[] = implode("", $concatenatedString);
    }  
    $markdown = [];
    foreach ($toConvert as $line) {
        // Keep line as is if ellipsis
        if (preg_match('/^\.+$/', $line) === 1) {
            $markdown[] = $line;
            continue;
        }
        // If not header, wrap with p tag
        $line = preg_replace('/^(?!(<h[1-6]>)).+$/m', "<p>$0</p>", $line);
        // Wrap consecutive lines into single p tag
        $markdown[] = preg_replace('/<\/p>\n<p>/', " ", $line);
    }

    return implode("", $markdown);
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
