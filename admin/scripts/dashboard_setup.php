<?php

// $dbname = "if0_36424959_codopia";
// $dbpass = "15o4d15o3c";
// $dbuser = "if0_36424959";
// $dbhost = "sql104.infinityfree.com";

$dbname = "donict";
$dbpass = "";
$dbuser = "root";
$dbhost = "localhost";

try {
    $con = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed to connect to the server: " . $e;
}