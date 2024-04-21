<?php

declare(strict_types=1);
require_once "../../admin/scripts/classes.php";
session_start();

$db = new DataBase();
$userid = $_SESSION["userid"];
$data = file_get_contents("php://input");

function add(int $post_id, int $user_id, array $array) {
    global $db;
    array_push($array, $user_id);
    $encode = json_encode($array);
    $db->executeSql("UPDATE trial SET liked_by = ? WHERE id = ?", [$encode, $post_id]);
    $db->executeSql("UPDATE trial SET likes = likes + 1 WHERE id = ?", [$post_id]);
    echo "LIKED";
}

function remove(int $post_id, int $user_id, array $array) {
    global $db;
    $index = array_search($user_id, $array);
    unset($array[$index]);
    $encode = json_encode($array);
    $db->executeSql("UPDATE trial SET liked_by = ? WHERE id = ?", [$encode, $post_id]);
    $db->executeSql("UPDATE trial SET likes = likes - 1 WHERE id = ?", [$post_id]);
    echo "UNLIKED";
}

function search(mixed $element, array $array) {
    if (in_array($element, $array) == true) return 1;
    else return -1;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($data) {
        $data = json_decode($data, true);
        $result = (array) $db->executeSql("SELECT liked_by FROM trial WHERE id = ?", [$data['post_id']], true);
        $likedBy = json_decode($result[0]["liked_by"], true);

        $search = search($userid, $likedBy);

        if ($search == -1) add((int) $data['post_id'], $userid, $likedBy);
        else remove((int) $data["post_id"], $userid, $likedBy);
    } else {
        die("No data received!");
    }
}

?>