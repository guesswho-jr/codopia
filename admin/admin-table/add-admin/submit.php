<?php

include("../../scripts/validation.php");

$username = $_POST["username"];
$full_name = $_POST["full_name"];
$email = $_POST["email"];
$selection = $_POST["category"];


if (!(validateString($username) || validateStringWithSpaces($full_name) || validateEmail($email) || validateString($selection))){
    echo json_encode(["type"=>"error", "error"=>"Not validated"]);
    exit;
}


$connection = new PDO("mysql:host=localhost;dbname=donict",'root','');
$addUserStatement = $connection->prepare("INSERT INTO `admins` (username,full_name,category,email) values (?,?,?,?)");
$addUserStatement->execute([$username, $full_name, $selection, $email]);
$updateIsAdmin = $connection->prepare("UPDATE `users` set is_admin=true where username=? and email=?");
$updateIsAdmin->execute([$username,$email]);
echo json_encode(["type"=>"success"]);