<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>login</title>
    <link rel="stylesheet" href="/text_chat/styles/login.css">
</head>
<body>
    <div class="main">
        <h1>TextChat</h1>
        <h3>Enter your login credentials</h3>
        <form method="post">
            <label for="first">
                Username:
            </label>
            <input type="text" id="first" name="first" placeholder="Enter your Username" required>
            <label for="password">
                Password:
            </label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>
            <div class="wrap">
                <button type="submit">Submit</button>
            </div>
        </form>
        
        <p>Not registered?
            <a href="index.php?page=register" style="text-decoration: none;">
                Create an account
            </a>
        </p>

        <?php
        if (isset($_POST['first']) && isset($_POST['password'])) {
            $_SESSION["userID"] = User::login($_POST['first'], $_POST['password']);
            if ($_SESSION["userID"] > 0) {
                header("Location: index.php");
                exit;
            } else {
                echo "<p style='color:red;'>Login fehlgeschlagen. Bitte versuche es erneut.</p>";
            }
        }
        ?>
    </div>
</body>
</html>
