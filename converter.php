<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $markdown = $_POST["input"];
    
    // Convert Markdown to HTML
    $html = convertMarkdown2HTML($markdown);
}

function convertMarkdown2HTML($markdown) {
    return $markdown;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML output</title>
</head>
<body>
    <h1>HTML output:</h1>
    <?php
    if (isset($htmlOutput)) {
        echo $htmlOutput;
    } else {
        echo "<p>Invalid input!</p>";
    }
    ?>
</body>
</html>