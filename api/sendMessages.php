<?php

session_start();
spl_autoload_register(function ($class) {
    include __DIR__ . '/../classes/' . $class . '.php';
});

$inputRaw = file_get_contents('php://input');
$input = json_decode($inputRaw, true);
$lastKnownMessage = $input['lastKnownMessage'] ?? 0;

echo json_encode(return_range_of_messages($lastKnownMessage, Messages::select_max_ID()));

function return_range_of_messages($lastKnownMessage, $maxID){
    if($_SESSION["userID"] > 0){
        $firstWantedMessage = $lastKnownMessage + 1;
        $range_of_messages = [];
        for($i = $firstWantedMessage; $i <= $maxID; $i++){
            $message = new Messages($i);
            $messageArr = [
                'creator' => $message->getCreator(),
                'ownMessage' => User::selectUserID($message->getCreator()) == $_SESSION['userID'],
                'content' => $message->getContent()
            ];
            $range_of_messages[]=$messageArr;
        }
        return $range_of_messages;
    }
}