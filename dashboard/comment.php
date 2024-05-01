<?php

declare(strict_types=1);
date_default_timezone_set("UTC");
require_once "../admin/scripts/classes.php";
session_start();
$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["projectId"]) and !empty($_POST["projectId"])) {
        $projectId = $_POST["projectId"];
        $comments = $db->executeSql("SELECT comment_text, comment_time, comment_likes, comment_liked_by, username FROM comments INNER JOIN projects ON comments.comment_project_id = projects.project_id INNER JOIN users ON comments.comment_user_id = users.id WHERE comment_project_id = ? ORDER BY comment_time DESC;", [$projectId], true);
        if ($comments["rows"] == 0) {
            die(json_encode(["status" => "no", "text" => "Be the first to comment!"]));
        }
        else {
            $superData = [];
            for ($i = 0; $i < count($comments) - 1; $i++) {
                $data = $comments[$i];
                array_push($superData, $data);
            }
            die(json_encode(["status" => "yes", "text" => $superData]));
        }
    }

    if (isset($_POST["myComment"]) and !empty($_POST["myComment"])) {
        $myComment = htmlspecialchars($_POST["myComment"]);
        $projectId = (int) htmlspecialchars($_POST["submitProjectId"]);
        // FIX: CHECK IF LIKED OR NOT
        $db->executeSql("INSERT INTO comments (comment_text, comment_time, comment_project_id, comment_user_id) VALUES (?, ?, ?, ?)", [$myComment, time(), $projectId, $_SESSION["userid"]]);
        die(json_encode(["status" => "done", "data" => ["username" => $_SESSION["username"], "text" => $myComment, "time" => time()]]));
    } else {
        die(json_encode(["status" => "not done"]));
    }
}

?>