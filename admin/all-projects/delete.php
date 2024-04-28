<?php
declare(strict_types=1);
define("UPLOAD_DIR", "../../dashboard/upload/uploads/");
require_once "../scripts/classes.php";
session_start();

$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectId = (int) $_POST["projectId"];
    $userId = (int) $_POST["userId"];
    $result = $db->executeSql("SELECT * FROM projects WHERE project_id = ? AND user_id = ?", [$projectId, $userId], true)[0];
    $path = UPLOAD_DIR . $result["file_path"];
    if (unlink($path)) {
        $db->executeSql("DELETE FROM projects WHERE project_id = ? AND user_id = ?", [$projectId, $userId]);
        $db->executeSql("UPDATE users SET uploads = uploads - 1 WHERE id = ?", [$userId]);
        $xp = new XPSystem($userId);
        $xp->decreaseXP(10);
        die(json_encode(["CODE" => 2001, "MESSAGE" => "Deleted"]));
    } else {
        die(json_encode(["CODE" => 2002, "MESSAGE" => "Unexpected error occurred; Failed to delete project."]));
    }
}

?>