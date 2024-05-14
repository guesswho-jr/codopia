<?php

declare(strict_types=1);
date_default_timezone_set("UTC");
require_once "../admin/scripts/classes.php";
require_once "../admin/scripts/validation.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = (string) $_POST["fname"];
    $email = (string) $_POST["email"];
    $username = (string) $_POST["username"];
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $bio = $_POST["bio"] ? (string) $_POST["bio"] : "No bio for the moment";
    $checkbox = (int) $_POST["checkbox"] ? 1 : 0;

    $inputCode = $_POST["code"];

    signupValidation($fname, $email, $username, $password, $confirm, $checkbox);

    if ($inputCode == $_SESSION["verification"]) {
        unset($_SESSION["verification"]);
        unset($_SESSION["trial"]);

        $user = new User($username, $password);
        $result = $user->createUser($username, $password, $confirm, $bio, $fname, $email, (int) $checkbox);

        if ($result["code"] == 0) {
            die(json_encode(["type" => "success"]));
        } 
        else if ($result["code"] == 1) {
            die($result["data"]);
        } 
        else if ($result["code"] == 2) {
            $obj = $result["obj"];
            if ($obj->getCode() == 23000) {
                $code = $obj->getCode();
                die(json_encode(["type" => "error", "message" => "User already registered",  "code" => ($code)]));
            } 
            else {
                die(json_encode(["type" => "error", "message" => $obj->getMessage(), "code" => $obj->getCode()]));
            }
        } 
        else {
            die(json_encode(["type" => "error", "message" => "Unknown error occurred"]));
        }
    }
    else {
        die(json_encode(["type" => "error", "message" => "Code doesn't match!"]));
    }
}
