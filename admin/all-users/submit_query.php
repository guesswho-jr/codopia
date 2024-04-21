<?php
session_start();
include("../scripts/dashboard_setup.php");

$id = $_POST['id'];
$adminStatus = $_SESSION["admin_status"];

if (!preg_match('/\d/', $id)){
    header('HTTP/1.1 403 Forbidden');
    exit;
}

if ($adminStatus!='1'){
    header('HTTP/1.1 403 Forbidden');
    exit;
}

$stmt = $con->prepare('delete from users where id=?');
$stmt->execute([$id]);
echo "User successfully deleted with id $id";
exit;