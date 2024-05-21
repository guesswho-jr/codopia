<?php

declare(strict_types=1);

require_once "../../admin/scripts/classes.php";
require_once "../../admin/scripts/validation.php";
session_start();
$db = new DataBase();

if ((
    empty($_POST["username"]) &&
    empty($_POST["full_name"]) &&
    empty($_POST["bio"]) &&
    empty($_POST["old_pwd"]) &&
    empty($_POST["new_pwd"]) &&
    empty($_POST["conf_pwd"])
)) {
    // die("<div class='alert alert-danger'>Please resubmit your form</div>");
    die(json_encode(["type" => "error", "text" => "Please specify what you want to change"]));
}
if (!empty($_POST["username"])) {
    if (!validateString($_POST["username"])) {
        // die("<div class='alert alert-danger'>Validation error occurred!</div>");
        die(json_encode(["type" => "error", "text" => "Username cannot start with a digit"]));
    }
    $r = $db->executeSql("select username from users where username=? limit 1", [$_POST["username"]], true);
    if ((int)$r["rows"] !== 0) {
        // die("<div class='alert alert-danger'>Username is taken!</div>");
        die(json_encode(["type" => "error", "text" => "Username is taken!"]));
    }
    $db->executeSql("update users set username=? where id=?", [$_POST["username"], (int)$_SESSION["userid"]]);
    $_SESSION["username"] = $_POST["username"];
} //username update

if (!empty($_POST["old_pwd"])) {
    if (!empty($_POST["new_pwd"]) && !empty($_POST["conf_pwd"])) {
        $user = $db->executeSql("Select password from users where id=?", [(int)$_SESSION["userid"]], true);
        if (!password_verify($_POST["old_pwd"], $user[0]["password"])) {
            // die("<div class='alert alert-danger'>Incorrect password!</div>");
            die(json_encode(["type" => "error", "text" => "Incorrect password!"]));
        }
        if ($_POST["new_pwd"] !== $_POST["conf_pwd"]) {
            // die("<div class='alert alert-danger'>Passwords don't match!</div>");
            die(json_encode(["type" => "error", "text" => "Passwords don't match!"]));
        }
        if (!validatePassword($_POST["new_pwd"]) || !validatePassword($_POST["conf_pwd"])) {
            die(json_encode(["type" => "error", "text" => "Password must contain at least one lowercase, one uppercase, one digit, and one special character"]));
        }
        $new_hash = password_hash($_POST["conf_pwd"], PASSWORD_ARGON2ID);
        $db->executeSql("UPDATE users set password = ? WHERE id = ?", [$new_hash, (int)$_SESSION["userid"]]);
    } else {
        // die("<div class='alert alert-danger'>If you want to submit the password you must specify all 3 password fields.</div>");
        die(json_encode(["type" => "error", "text" => "If you want to change your password, you must specify all 3 password fields."]));
    } // Password update
}

if (!empty($_POST["full_name"])) {
    if (!validateStringWithSpaces($_POST["full_name"])) {
        // die("<div class='alert alert-danger'>Validation error!</div>");
        die(json_encode(["type" => "error", "text" => "Validation error!"]));
    }
    $db->executeSql("UPDATE users SET full_name = ? WHERE id = ?", [$_POST["full_name"], (int) $_SESSION["userid"]]);
    $_SESSION["full_name"] = $_POST["full_name"];
} // full_name update

if (!empty($_POST["bio"])) {
    if (!validateStringWithSpaces($_POST["bio"])) {
        // die("<div class='alert alert-danger'>Validation error!</div>");
        die(json_encode(["type" => "error", "text" => "Validation error!"]));
    }
    $db->executeSql("UPDATE users SET bio = ? WHERE id = ?", [$_POST["bio"], (int)$_SESSION["userid"]]);
    $_SESSION["bio"] = $_POST["bio"];
} // bio update

die(json_encode(["type" => "success", "text" => "Profile updated!"]));