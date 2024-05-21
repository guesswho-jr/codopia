<?php
session_start();
require_once "../admin/scripts/classes.php";
require_once "../admin/scripts/validation.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $questionAsJson = $_POST["data"];
    $subject = $_POST["subject"];
    if ((!preg_match("/JavaScript|HTML/", $subject) && !validateString($_POST["diff"]))) {
        die(json_encode([
            "error" => "Resubmit your form please"
        ]));
    }

    $by = $_SESSION["username"];
    $questionAsArray = json_decode($questionAsJson, true);
    // die(print_r($questionAsArray));
    $db = new DataBase();
    $db->executeSql("insert into test_list (name, prepared_by, difficulity) 
        values (?,?,?)", [$subject, $by, $_POST["diff"]]);
    
    foreach ($questionAsArray as $qst) {
        $db->executeSql("insert into tests (question, answer, a, b, c, d, subject)
            values (?, ?, ?, ?, ?, ?, ?)", [$qst["question"], $qst["answer"], $qst["a"], $qst["b"], $qst["c"], $qst["d"], $subject]);
        // die(print_r($qst["a"]));
    }

    
    // ...
}
