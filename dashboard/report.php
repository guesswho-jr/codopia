<?php

declare(strict_types=1);
require_once "../admin/scripts/classes.php";
session_start();
$db = new DataBase();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $projectId = $_POST["projectId"];
    $reportValue = (int) $_POST["reportValue"];
    // $reportText = $_POST["reportText"]; // it's just to keep the protocol (i really dont use this anywhere);

    function projectReport()
    {
        global $db, $projectId;
        $reported_by = json_decode($db->executeSql("SELECT reported_by FROM projects WHERE project_id = ?", [$projectId], true)[0]["reported_by"], true);
        if (in_array($_SESSION["userid"], $reported_by)) {
            die(json_encode(["STATUS_CODE" => "002", "STATUS_TYPE" => "error", "STATUS_TITLE" => "Already reported!", "STATUS_MESSAGE" => "You have previously reported on this project."]));
        }

        array_push($reported_by, $_SESSION["userid"]);
        $encoded = json_encode($reported_by);
        $db->executeSql("UPDATE projects SET reported_by = ? WHERE project_id = ?", [$encoded, $projectId]);
        $db->executeSql("UPDATE projects SET reports = reports + 1 WHERE project_id = ?", [$projectId]);
    }

    function tableReport(mixed $value)
    {
        global $db, $projectId;
        $allowed_columns = ["R1", "R2", "R3", "R4"];
        $column = (string) "R" . $value;
        if (!in_array($column, $allowed_columns)) {
            die(json_encode(["STATUS_CODE" => "003", "STATUS_TYPE" => "error", "STATUS_TITLE" => "Validation error!", "STATUS_MESSAGE" => "Please check your report subject choice."]));
        }

        $exist = $db->executeSql("SELECT * FROM reports WHERE project_id = ?", [$projectId], true);
        if ($exist["rows"] == 0) {
            $db->executeSql("INSERT INTO reports (project_id) VALUES (?)", [$projectId]);
            $db->executeSql("UPDATE reports SET $column = $column + 1 WHERE project_id = ?", [$projectId]);
        } else $db->executeSql("UPDATE reports SET $column = $column + 1 WHERE project_id = ?", [$projectId]);
    }

    switch ($reportValue) {
        case 1:
            $reportText = "Embedded Virus";
            projectReport();
            tableReport(1);
            die(json_encode(["STATUS_CODE" => "01", "STATUS_TYPE" => "success", "STATUS_TITLE" => "Successfully reported!", "STATUS_MESSAGE" => "We will check on your '{$reportText}' report subject."]));
            break;
        case 2:
            $reportText = "Explicit Content";
            projectReport();
            tableReport(2);
            die(json_encode(["STATUS_CODE" => "01", "STATUS_TYPE" => "success", "STATUS_TITLE" => "Successfully reported!", "STATUS_MESSAGE" => "We will check on your '{$reportText}' report subject."]));
            break;
        case 3:
            $reportText = "Improper Name";
            projectReport();
            tableReport(3);
            die(json_encode(["STATUS_CODE" => "01", "STATUS_TYPE" => "success", "STATUS_TITLE" => "Successfully reported!", "STATUS_MESSAGE" => "We will check on your '{$reportText}' report subject."]));
            break;
        case 4:
            $reportText = "Copyright Issue";
            projectReport();
            tableReport(4);
            die(json_encode(["STATUS_CODE" => "01", "STATUS_TYPE" => "success", "STATUS_TITLE" => "Successfully reported!", "STATUS_MESSAGE" => "We will check on your '{$reportText}' report subject."]));
            break;
        default:
            echo json_encode(["STATUS_CODE" => "001", "STATUS_TYPE" => "error", "STATUS_TITLE" => "Invalid report subject", "STATUS_MESSAGE" => "You must choose a report subject first!"]);
    }
}
