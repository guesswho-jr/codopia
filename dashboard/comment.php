<?php

declare(strict_types=1);
date_default_timezone_set("UTC");
require_once "../admin/scripts/classes.php";
session_start();
$db = new DataBase();
$userid = $_SESSION["userid"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // WHEN DISPLAYING THE RIGHT CONTENTS OF THE COMMENT BAR
    if (isset($_POST["projectId"]) and !empty($_POST["projectId"])) {
        $projectId = $_POST["projectId"];
        $comments = $db->executeSql("SELECT comment_id, comment_text, comment_time, comment_likes, comment_liked_by, username FROM comments INNER JOIN projects ON comments.comment_project_id = projects.project_id INNER JOIN users ON comments.comment_user_id = users.id WHERE comment_project_id = ? ORDER BY comment_time DESC;", [$projectId], true);
        if ($comments["rows"] == 0) {
            die(json_encode(["status" => "no", "text" => "Be the first to comment!"]));
        } else {
            $superData = [];
            for ($i = 0; $i < count($comments) - 1; $i++) {
                $data = $comments[$i];
                array_push($superData, $data);
            }
            die(json_encode(["status" => "yes", "text" => $superData]));
        }
    }

    // WHEN ADDING NEW COMMENT
    if (isset($_POST["myComment"]) and !empty($_POST["myComment"])) {
        $myComment = htmlspecialchars($_POST["myComment"]);
        $projectId = (int) htmlspecialchars($_POST["submitProjectId"]);
        $currentTime = time();
        $checkComment = $db->executeSql("SELECT project_id, comment_id, comment_project_id, comment_user_id FROM projects INNER JOIN comments ON projects.project_id = comments.comment_project_id WHERE project_id = ? AND comment_user_id = ?", [$projectId, $_SESSION["userid"]], true);
        if ($checkComment["rows"] != 0) {
            if ($checkComment["rows"] >= 5) {
                die(json_encode(["status" => "commento", "text" => "Could not comment more than 5 comments for the same project!"]));
            }
        }
        $uniqueIdentifier = bin2hex(random_bytes(16)) . $currentTime;
        $db->executeSql("INSERT INTO comments (comment_text, comment_time, comment_project_id, comment_user_id, unique_identifier) VALUES (?, ?, ?, ?, ?)", [$myComment, $currentTime, $projectId, $_SESSION["userid"], $uniqueIdentifier]);
        $commentResult = $db->executeSql("SELECT comment_id, comment_project_id FROM comments WHERE comment_time = ? AND comment_user_id = ? AND unique_identifier = ? LIMIT 1", [$currentTime, $_SESSION["userid"], $uniqueIdentifier], true)[0];
        $db->executeSql("UPDATE projects SET comments = comments + 1 WHERE project_id = ?", [$commentResult["comment_project_id"]]);
        die(json_encode(["status" => "done", "data" => ["commentId" => $commentResult["comment_id"], "username" => $_SESSION["username"], "text" => $myComment, "time" => $currentTime]]));
    }
    // else {
    //     die(json_encode(["status" => "not done"]));
    // }

    if (isset($_POST["commentId"]) and !empty($_POST["commentId"])) {
        $commentIdForLike = (int) htmlspecialchars($_POST["commentId"]);
        $comment_liked_by = $db->executeSql("SELECT comment_liked_by FROM comments WHERE comment_id = ?", [$commentIdForLike], true);
        if ($comment_liked_by["rows"] != 0) {
            $comment_liked_by = json_decode($comment_liked_by[0]["comment_liked_by"], true);
            if (in_array($userid, $comment_liked_by)) {
                // the user has already liked the comment so now it's disliking
                $index = array_search($userid, $comment_liked_by);
                unset($comment_liked_by[$index]);
                $encoded_liked_by_for_dislike = json_encode($comment_liked_by);
                $db->executeSql("UPDATE comments SET comment_liked_by = ? WHERE comment_id = ?", [$encoded_liked_by_for_dislike, $commentIdForLike]);
                $db->executeSql("UPDATE comments SET comment_likes = comment_likes - 1 WHERE comment_id = ?", [$commentIdForLike]);
                die(json_encode(["status" => "disliked"]));
            } else {
                // the user didnt liked the comment before so now it's liking
                array_push($comment_liked_by, $userid);
                $encoded_liked_by_for_like = json_encode($comment_liked_by);
                $db->executeSql("UPDATE comments SET comment_liked_by = ? WHERE comment_id = ?", [$encoded_liked_by_for_like, $commentIdForLike]);
                $db->executeSql("UPDATE comments SET comment_likes = comment_likes + 1 WHERE comment_id = ?", [$commentIdForLike]);
                die(json_encode(["status" => "liked"]));
            }
        }
    }
}
