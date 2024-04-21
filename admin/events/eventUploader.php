<?php

require_once "../scripts/admin_check.php";
require_once "../scripts/classes.php";

if (isset($_POST["submit"])) {
    $title = htmlspecialchars($_POST["title"]);
    $info = htmlspecialchars($_POST["info"]);
    $xp = htmlspecialchars($_POST["xp"]);
    $deadline = htmlspecialchars($_POST["deadline"]);

    if (!empty($title) && !empty($xp) && !empty($deadline) && !empty($info)) {
        $db = new DataBase();
        $sql = "INSERT INTO events (event_name, event_desc, xp, deadline) VALUES (?, ?, ?, ?);";
        $db->executeSql($sql, [$title, $info, $xp, $deadline]);
        header("Location: ..");
        exit;
    } else {
        die("Please fill in all fields");
    }
}
