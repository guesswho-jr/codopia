<?php
define("UPLOAD_PATH", realpath("./upload/uploads"));

function getPrettyFile($bulkyfile) {
    $bulkyfileArr = explode('--', $bulkyfile);
    // if (count($bulkyfileArr) < 3) {
    //     // Handle unexpected file name format gracefully
    //     return $bulkyfile;
    // }
    return $bulkyfileArr[0] . $bulkyfileArr[2];
}

if (isset($_GET["file"])) {
    $file = basename($_GET["file"]); // Sanitize the file input to prevent directory traversal
    $filePath = UPLOAD_PATH . DIRECTORY_SEPARATOR . $file;
    
    if (file_exists($filePath)) {
        // Set headers for file download
        header("Content-Description: File Transfer");
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=" . basename(getPrettyFile($file)));
        header("Expires: 0");
        header("Cache-Control: must-revalidate");
        header("Pragma: public");
        header("Content-Length: " . filesize($filePath));

        // Read the file and output it to the browser
        readfile($filePath);
        exit;
    } else {
        die("File not found: " . htmlspecialchars($filePath));
    }
} else {
    die("Invalid request");
}
?>
