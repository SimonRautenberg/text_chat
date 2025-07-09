<?php
if(isset($_SESSION['userID'])) {
    if($_SESSION['userID'] > 0) {
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>text-chat</title>
        <link rel="stylesheet" href="/text_chat/styles/chat.css">
    </head>
    <body>
        <a id="logout" href="index.php?action=logout" style="text-decoration: none;">
            Logout
        </a>
        <h1>TextChat</h1>
        <div id="textBox"></div>
        <textarea id="messageBox" rows="4" cols="50"></textarea>
        <br>
        <button id="sendButton">Send</button>
        <script src="textChat.js"></script>
    </body>
</html>
<?php
    }
} else{
    header("Location: index.php?page=login");
}