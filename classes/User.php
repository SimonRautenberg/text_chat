<?php
class User
{

public static function login($username, $given_password):int
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT password FROM users WHERE userName = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        return 0;
    }
    if ($result['password'] === $given_password) {
        return self::selectUserID($username);
    } else {
        return 0;
    }
}

public static function selectUserID($username):int
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT userID FROM users WHERE userName = :username";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['userID'] : 0;
}

public static function selectUserName($userID):string
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT userName FROM users WHERE userID = :userID";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ? $result['userName'] : '';
}

public static function selectUsernameByID($userID):string
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT userName FROM users WHERE userID = :userID";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['userName'];
}

public static function user_exists($username):bool
{
    $dbh = (new ConnectDB())->connect();
    $sql = "SELECT EXISTS (SELECT 1 FROM users WHERE userName = :username)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return (bool)$stmt->fetchColumn();
}

public static function password_match($password, $password2):bool
{
    if($password === $password2) {
        return true;
    } else {
        return false;
    }
}
public static function store_user($username, $password):void
{
    try {
        $dbh = (new ConnectDB())->connect();
        $sql = "INSERT INTO users (userName, password) VALUES (:username, :password)";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Fehler beim Einfügen des Benutzers: " . $e->getMessage());
    }
}
public static function create_user($username, $password, $password2):int
{
    if(!self::user_exists($username) && self::password_match($password, $password2)){
        self::store_user($username, $password);
        self::login($username,$password);
        return self::selectUserID($username);
    } else{
        return 0;
    }
}
}