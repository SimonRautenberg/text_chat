<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
spl_autoload_register(function ($class) {
    include __DIR__ . '/../classes/' . $class . '.php';
});

$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);
if($_SESSION["userID"] > 0){
    Messages::store_message($_SESSION["userID"], $input['message']);
}
