<!-- index.php -->
ini_set('display_errors', 1);
error_reporting(E_ALL);

<?php
function convertMarkdownToHTML($markdown) {
    // Convert headings
    $html = preg_replace("/###### (.+)/", "<h6>$1</h6>", $markdown);
    $html = preg_replace("/## (.+)/", "<h2>$1</h2>", $html);
    $html = preg_replace("/# (.+)/", "<h1>$1</h1>", $html);

    // Handle ellipsis
    $html = preg_replace("/\.\.\./", "&hellip;", $html);

    return $html;    
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
        echo $output;
    } else {
        echo "<p>No input!</p>";
    }
    ?>
</body>
</html>
