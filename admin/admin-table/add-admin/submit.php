<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


include("../../scripts/validation.php");
require_once "../../scripts/classes.php";

$username = $_POST["username"];
// $full_name = $_POST["full_name"];
// $email = $_POST["email"];
$selection = $_POST["category"];


if (!(validateString($username) || validateStringWithSpaces($full_name) || validateEmail($email) || validateString($selection))){
    echo json_encode(["type"=>"error", "error"=>"Not validated"]);
    exit;
}

$db = new DataBase();
$dataFromUsersTable = $db->executeSql("SELECT full_name, username, email, id, is_admin FROM users WHERE username = ?", [$username], true);
if ($dataFromUsersTable["rows"] == 0) {
    die(json_encode(["type"=>"error", "error"=>"User not found"]));
}

$full_name = $dataFromUsersTable[0]["full_name"];
$email = $dataFromUsersTable[0]["email"];
$id = $dataFromUsersTable[0]["id"];
$isAdmin = $dataFromUsersTable[0]["is_admin"];

if ($isAdmin) {
    die(json_encode(["type"=>"error", "error"=>"User is already an admin"]));
}

$db->executeSql("INSERT INTO admins (full_name, username, category, email, user_id) VALUES (?, ?, ?, ?, ?)", [$full_name, $username, $selection, $email, $id]);
$db->executeSql("UPDATE users SET is_admin = true WHERE username = ? and email = ?", [$username, $email]);

echo json_encode(["type"=>"success"]);