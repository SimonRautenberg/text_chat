<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>register</title>
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
            <label for="password2">
                Repeat Password:
            </label>
            <input type="password" id="password2" name="password2" placeholder="Repeat your Password" required>
            <div class="wrap">
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>
        
        <p>alredy registered?
            <a href="index.php?page=login" style="text-decoration: none;">
                back to login
            </a>
        </p>
    </div>
</body>

</html>
<?php
if(isset($_POST['first']) && isset($_POST['password']) && isset($_POST['password2'])){
    User::create_user($_POST['first'], $_POST['password'], $_POST['password2']);
}