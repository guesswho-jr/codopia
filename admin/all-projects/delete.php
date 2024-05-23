<?php
declare(strict_types=1);
define("UPLOAD_DIR", "../../dashboard/upload/uploads/");
require_once "../scripts/classes.php";
session_start();

$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $projectId = (int) $_POST["projectId"];
    $pui = $_POST["pui"];
    $userId = (int) $_POST["userId"];
    $result = $db->executeSql("SELECT * FROM projects WHERE project_id = ? AND user_id = ? AND project_unique_identifier = ?", [$projectId, $userId, $pui], true);
    if ($result["rows"] == 0) {
        die(json_encode(["TYPE" => "error", "CODE" => 2003, "MESSAGE" => "Could not find and delete project."]));
    }
    $result = $result[0];
    $path = UPLOAD_DIR . $result["file_path"];
    // die(print_r($result));
    if (unlink($path)) {
        $db->executeSql("DELETE FROM projects WHERE project_id = ? AND user_id = ? AND project_unique_identifier = ?", [$projectId, $userId, $pui]);
        $db->executeSql("UPDATE users SET uploads = uploads - 1 WHERE id = ?", [$userId]);
        $xp = new XPSystem($userId);
        $xp->decreaseXP(10);
        die(json_encode(["TYPE" => "success", "CODE" => 2001, "MESSAGE" => "Deleted"]));
    } else {
        die(json_encode(["TYPE" => "error", "CODE" => 2002, "MESSAGE" => "Unexpected error occurred; Failed to delete project."]));
    }
}

?>