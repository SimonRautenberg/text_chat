<?php

class Messages
{
private int $messageID;
private string $creator;
private string $content;

public function __construct($id)
{
    $this->messageID = $id;
    $this->creator = User::selectUsernameByID(Self::getCreatorByID($id));
    $this->content = Self:: getContentByID($id);
}

public function getCreator()
{
     return $this->creator;
}

public function getContent()
{
     return $this->content;
}

private static function getCreatorByID($id):string
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT userID FROM messages WHERE messageID = :messageID";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':messageID', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['userID'];
}

private static function getContentByID($id):string
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT message FROM messages WHERE messageID = :messageID";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':messageID', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['message'];
}
public static function store_message($userID, $message):void
{
    try {
        $dbh = (new ConnectDB())->connect();
        $sql = "INSERT INTO messages (userID, message) VALUES (:userID, :message)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':message', $message);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Fehler beim Einfügen der Nachricht: " . $e->getMessage());
    }
}
public static function select_max_ID():int
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT MAX(messageID) AS maxID FROM messages";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['maxID'] ?? 0;
}


}