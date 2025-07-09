<?php
session_start();
spl_autoload_register(function ($class) {
    include 'classes/' . $class . '.php';
});


$page = $_GET['page'] ?? 'login';
$action = $_GET['action'] ?? 'none';
if (!isset($_SESSION['userID'])){
  $_SESSION['userID'] = 0;
}

  if ($action === 'logout') {
        $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header("Location: index.php?page=login");
  }
if ($_SESSION['userID'] > 0) {
    include 'views/secret.php';

} else {
if ($page === 'register') {
    include 'views/register.php';
} else {
    include 'views/login.php';
}
}