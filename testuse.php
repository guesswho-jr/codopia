<?php

require_once "./admin/scripts/classes.php";
session_start();
$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // $commentId = $_POST[""]
    echo json_encode($_POST);
    $db->executeSql("DELETE FROM testuse WHERE testuse_id = ?", [$_POST["commentId"]]);
}
?>