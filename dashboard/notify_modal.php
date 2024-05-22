<?php

require_once "../admin/scripts/classes.php";
session_start();
$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $notifyId = $_POST["notifyId"];
    $notification = $db->executeSql("SELECT notify_id, notify_title, notify_message FROM notifications WHERE notify_id = ? LIMIT 1", [$notifyId], true);
    if ($notification["rows"] == 0) {
        die(json_encode(["type" => "error", "text" => "Error: Notification could not be found!"]));
    } else {
        $response = json_encode(["title" => $notification[0]["notify_title"], "message" => $notification[0]["notify_message"]]);
        die(json_encode(["type" => "error", "username" => $_SESSION["username"], "text" => $response]));
    }
}

?>