<?php

declare(strict_types=1);
define("THE_SECRET_KEY", bin2hex(random_bytes(10))); // 434f4445

require_once "../../admin/scripts/classes.php";
require_once "../../admin/scripts/validation.php";
session_start();

$xpSystem = new XPSystem((int)$_SESSION["userid"]);
$db = new DataBase();
$accepted = ["zip"];
$acceptedTypes = ["application/x-zip-compressed"];
if (isset($_POST["post"])) {
    $theFile = $_FILES["theFile"];
    $file_name = $theFile["name"];
    $project_name = htmlspecialchars($_POST["projName"]);
    $project_desc = htmlspecialchars($_POST["capInput"]);
    $userid = $_SESSION["userid"];
    if (!in_array(explode('.', $file_name)[1], $accepted) || !in_array($theFile["type"], $acceptedTypes) || $theFile["size"] > 5*1024*1024 || filesize($theFile["tmp_name"]) > 5*1024*1024) {
        header("HTTP/1.1 403 Forbidden");
        echo "Forbidden";
        exit;
    }

    if (!(validateString($project_name) && validateStringWithSpaces($project_desc))) {
        header("HTTP/1.1 403 Forbidden");
        exit;
    }

    if (!empty($file_name) && !empty($project_name) && !empty($project_desc)) {

        // Handling the file
        $tempFilePath = $_FILES["theFile"]["tmp_name"];
        $tempFile = fopen($tempFilePath, "rb");
        if ($tempFile) {
            // MARK: INSERT FILE TO DATABASE
            $currentDate = date("mdhms");

            $pathInfo = pathinfo($file_name); // If the file's name from $_FILES is text_doc.txt,
            $actualFilename = $pathInfo["filename"]; // = text_doc
            $extension = $pathInfo["extension"]; // = txt
            
            // Insert the path name without project id
            $toStorePathOld = (string) $actualFilename . "--" . $currentDate . "{THE_SECRET_KEY}UzX" . $userid . "{THE_SECRET_KEY}UzX" . "--." . $extension; // Without project id
            $db->executeSql("INSERT INTO projects (project_name, file_path, project_detail, user_id) VALUES(?, ?, ?, ?)", [$project_name, $toStorePathOld, $project_desc, $userid]);

            // Select from projects table and get the project id to set it to the file path
            $result = $db->executeSql("SELECT project_id FROM projects WHERE file_path = ?", [$toStorePathOld], true);
            $resultId = (int) $result[0]["project_id"];
            $toStorePathNew = (string) $actualFilename . "--" . $currentDate . "{THE_SECRET_KEY}UzX" . $userid . "{THE_SECRET_KEY}UzX" . "{THE_SECRET_KEY}PzX" . $resultId . "{THE_SECRET_KEY}PzX" . "--." . $extension;
            $db->executeSql("UPDATE projects SET file_path = ? WHERE project_id = ?", [$toStorePathNew, $resultId]);

            $fileContent = fread($tempFile, 5 * 1024 * 1024);
            fclose($tempFile);

            // MARK: WRITE ON A NEW FILE
            $toOpenPath = (string) "uploads/" . $toStorePathNew; // Prepare the environment
            $newFile = fopen($toOpenPath, "wb"); // Create a new file and write contents of project
            if ($newFile) {
                fwrite($newFile, $fileContent);
                fclose($newFile);
            } else exit;
        } else exit;

        $xpSystem->addXP(10);
        $db->executeSql("UPDATE users SET uploads = uploads + 1 WHERE id = ?", [$userid]);

        header("Location: ../projects/");
    } else {
        die("Please fill in all the fields");
    }
} else {
    header("Location: ../projects/");
}
