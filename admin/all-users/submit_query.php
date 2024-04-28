<?php
session_start();
include("../scripts/dashboard_setup.php");
require_once "../scripts/classes.php";

$id = $_POST['id'];
$adminStatus = $_SESSION["admin_status"];

if (!preg_match('/\d/', $id)){
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if ($adminStatus!='1'){
    header('HTTP/1.1 403 Forbidden');
    echo "You are not admin";
    exit;
}
if (!validateInteger($id)){
    die("Validation error");
}

// $db = new DataBase();
// $result = json_decode(json_encode($db->executeSql("SELECT * FROM projects WHERE user_id = ?", [$id], true)), true);
// print_r($result);
// if ($result["rows"] != 0) {
//     $path = "/dashboard/upload/uploads" . $result[0]["file_path"];
//     $path = realpath($path);
//     if (!unlink($path)) {
//         die("Unexpected error occurred; Failed to delete user's project(s).");
//     }
// }


$stmt=$con->prepare("select file_path from projects where user_id=?");
$stmt->execute([$id]);

$file = $stmt->fetchAll(PDO::FETCH_ASSOC);

unlink("../../dashboard/upload/uploads/".$file[0]["file_path"]);

$stmt = $con->prepare('delete from users where id=?');
$stmt->execute([$id]);

echo "User successfully deleted with id $id";

exit;