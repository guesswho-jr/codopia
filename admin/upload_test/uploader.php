<?php
declare(strict_types=1);
session_start();
require_once "../scripts/classes.php";
require_once "../scripts/validation.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionAsJson = $_POST["data"];
    $subject = $_POST["subject"];
    if ((!preg_match("/HTML|CSS|JavaScript|Bootstrap|Python/", $subject) && !validateString($_POST["diff"]) && !validateString($_POST["subject"]))) {
        die(json_encode(["type" => "error", "text" => "Please check subject and resubmit the form"]));
    }

    $by = $_SESSION["username"];
    $questionAsArray = json_decode($questionAsJson, true);
    // die(print_r($questionAsArray));
    $unique = bin2hex(random_bytes(32));
    $db = new DataBase();
    $db->executeSql("insert into test_list (name, prepared_by, difficulty, test_list_unique_identifier) 
        values (?,?,?,?)", [$subject, $by, $_POST["diff"], $unique]);
    
    $testListId = $db->executeSql("SELECT id FROM test_list WHERE test_list_unique_identifier = ?", [$unique], true)[0]["id"];
    
    foreach ($questionAsArray as $qst) {
        $db->executeSql("insert into tests (question, answer, a, b, c, d, subject, test_list_id)
            values (?, ?, ?, ?, ?, ?, ?, ?)", [$qst["question"], $qst["answer"], $qst["a"], $qst["b"], $qst["c"], $qst["d"], $subject, $testListId]);
        // die(print_r($qst["a"]));
    }

    die(json_encode(["type" => "success", "text" => "Test uploaded!"]));
    // ...
}
