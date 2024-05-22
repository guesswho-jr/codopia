<?php

require_once "../scripts/classes.php";

$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $users = $_POST["users"];
    $check = $_POST["check"];
    $title = $_POST["title"];
    $message = $_POST["message"];

    if (!$users and !$check) die(json_encode(["type" => "error", "text" => "Please specify to whom you are sending"]));
    if (!$message or !$title) die(json_encode(["type" => "error", "text" => "Please make sure you entered title and message properly"]));

    $currentTime = time();

    if ($check) { // Notify everyone
        $everyone = json_encode(["everyone"]);
        $db->executeSql("INSERT INTO notifications (notify_title, notify_message, notify_to, notify_time) VALUES (?, ?, ?, ?)", [$title, $message, $everyone, $currentTime]);
        die(json_encode(["type" => "success", "text" => "Notification sent to every user"]));
    } else if (!$check and $users) {
        $usersArray = explode(",", $users);
        foreach ($usersArray as $user) {
            $found = $db->executeSql("SELECT username FROM users WHERE username = ?", [$user], true)["rows"];
            if ($found == 0) {
                die(json_encode(["type" => "error", "text" => "User $user is not found!"]));
            }
        }
        $usersJSON = json_encode($usersArray);
        $db->executeSql("INSERT INTO notifications (notify_title, notify_message, notify_to, notify_time) VALUES (?, ?, ?, ?)", [$title, $message, $usersJSON, $currentTime]);
        die(json_encode(["type" => "success", "text" => "Notification sent to $users"]));
    }
}

?>