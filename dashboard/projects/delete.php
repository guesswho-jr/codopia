<?php
declare(strict_types=1);
define("UPLOAD_DIR", realpath("../upload/uploads"));
require_once "../../admin/scripts/classes.php";
session_start();
$userid = (int)$_SESSION["userid"];

$db = new DataBase();
$xp = new XPSystem($userid);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = file_get_contents("php://input");
    if (!$data) die(json_encode(["TYPE" => "error", "CODE" => 2004, "MESSAGE" => "Could not receive request. Refresh the page and try again."]));
    // die($data);
    $data = json_decode($data, true);
    if (json_last_error() !== JSON_ERROR_NONE) die(json_encode(["TYPE" => "error", "CODE" => 2005, "MESSAGE" => "Invalid client request. Refresh the page and try again or contact the administrators."]));
    $projectId = $data["projectId"];
    $pui = $data["pui"];
    $result = $db->executeSql("SELECT * FROM projects WHERE project_id = ? AND user_id = ? AND project_unique_identifier = ?", [$projectId, $userid, $pui], true);
    if ($result["rows"] == 0) {
        die(json_encode(["TYPE" => "error", "CODE" => 2003, "MESSAGE" => "Could not find and delete project."]));
    }
    $result = $result[0];
    $path = "../upload/uploads/" . $result["file_path"];
    $path = realpath($path);
    if (unlink($path)) {
        $db->executeSql("DELETE FROM projects WHERE project_id = ? AND user_id = ? AND project_unique_identifier = ?", [$projectId, $userid, $pui]);
        $db->executeSql("UPDATE users SET uploads = uploads - 1 WHERE id = ?", [$userid]);
        $xp->decreaseXP(10);
        die(json_encode(["TYPE" => "success", "CODE" => 2001, "MESSAGE" => "Deleted"]));
    } else {
        die(json_encode(["TYPE" => "error", "CODE" => 2002, "MESSAGE" => "Unexpected error occurred; Failed to delete project."]));
    }
}

?>