<!-- index.php -->
ini_set('display_errors', 1);
error_reporting(E_ALL);

<?php
function convertMarkdownToHTML($markdown) {
    // Convert headers
    $markdown = preg_replace('/^###### (.+)$/m', '<h6>$1</h6>', $markdown);
    $markdown = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $markdown);
    $markdown = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $markdown);

    // Convert paragraphs
    $lines = explode("\r", $markdown);
    $to_convert = [];
    $concatenatedString = '';
    foreach ($lines as $line) {
        if ($line !== "\n") {
            $concatenatedString .= $line;
        } else {
            if ($concatenatedString !== '') {
                $to_convert[] = $concatenatedString;
                $concatenatedString = '';
            }
        }
    }
    if ($concatenatedString !== '') {
        $to_convert[] = $concatenatedString;
    }
    $markdown = '';
    foreach ($to_convert as $line) {
        $line = preg_replace('/^(?!(<h[1-6]>)).+$/m', '<p>$0</p>', $line);
        $markdown .= preg_replace('/<\/p>\n<p>/', ' ', $line);
    }

    // Convert links
    $markdown = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2">$1</a>', $markdown);

    // Handle ellipsis
    $markdown = preg_replace('/\.{3}/', "...", $markdown);

    return $markdown;
}

$input = "";
$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST["input"];
    $output = convertMarkdownToHTML($input);
}

var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown to HTML Converter</title>
</head>
<body>
    <h1>Markdown to HTML Converter</h1>
    <form action="" method="post">
        <label for="input">Enter Markdown:</label><br>
        <textarea id="input" name="input" rows="10" cols="50" required><?php echo $input; ?></textarea><br>
        <input type="submit" value="Convert">
    </form>

    <h2>HTML Output</h2>
    <?php
    if (!empty($output)) {
        echo nl2br(htmlspecialchars($output));
    } else {
        echo "<p>No input!</p>";
    }
    ?>
</body>
</html>


