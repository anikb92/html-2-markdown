<!-- form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown to HTML Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Markdown to HTML Converter</h1>
    <?php 
        session_start();

        if (isset($_SESSION["input"])) {
            $input = $_SESSION["input"];
            unset($_SESSION["input"]);
        }
    ?>
    <form method="post" action="converter.php">
        <label for="input">Enter Markdown:</label><br>
        <textarea id="input" name="input" rows="10" cols="50" required><?php echo $input; ?></textarea><br>
        <input type="submit" value="Convert">
    </form>
    <br>
    <h2><u>HTML Raw Output</u></h2>
    <?php 
        $output = "";    
        if (isset($_SESSION["output"])) {
            $output = $_SESSION["output"];
            unset($_SESSION["output"]);
        }
        
        if (!empty($output)) {
            echo nl2br(htmlspecialchars($output));
        } else {
            echo "<p>No input!</p>";
        }
        ?>
        <br>
        <h2><u>HTML Output</u></h2>
        <?php
        if (!empty($output)) {
            echo $output;
        } else {
            echo "<p>No input!</p>";
        }
        ?>
</body>
</html>