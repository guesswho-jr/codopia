<?php

$dbname = "donict";
$dbpass = "";
$dbuser = "root";

try {
    $con = new PDO("mysql:host=localhost;dbname=$dbname", $dbuser, $dbpass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Failed to connect to the server: " . $e;
}