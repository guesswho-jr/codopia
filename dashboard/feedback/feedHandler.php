<?php

require_once "../../admin/scripts/classes.php";
session_start();

$database = new DataBase();

if (isset($_POST["submit"])) {
    $feed = htmlspecialchars($_POST["feed"]);
    $bug = $_POST["bug-report"] ? 1 : 0;
    $rating = $_POST["star"] ? htmlspecialchars($_POST["star"]) : "Not rated";
    $userId = $_SESSION["userid"];

    if (!empty($feed)) {
        $database->executeSql("INSERT INTO feedbacks (feedback_body, bug, rating, user_id) VALUES (?, ?, ?, ?)", [$feed, $bug, $rating, $userId]);
    }
}

header("Location: /dashboard");