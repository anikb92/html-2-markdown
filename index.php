<!-- form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Markdown to HTML Converter</title>
    <link rel="stylesheet" href="static/style.css">
    <script src="static/validation.js" defer></script>
</head>
<body>
    <h1>Markdown to HTML Converter</h1>
    <?php 
        session_start();

        $input = "";   
        if (isset($_SESSION["input"])) {
            $input = $_SESSION["input"];
            unset($_SESSION["input"]);
        }
    ?>
    <form method="post" action="converter.php">
        <label for="input">Enter Markdown:</label><br>
        <textarea id="input" name="input" rows="10" cols="50" maxlength="5000" required><?php echo $input; ?></textarea><br>
        <p>Characters remaining: <span id="char_count">5000</span></p>
        <input type="submit" id="convert" name="convert" value="Convert">
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