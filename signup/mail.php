<?php

declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', 1);

date_default_timezone_set("UTC");
session_start();

require_once "../admin/scripts/classes.php";
require_once "../admin/scripts/validation.php";

if (!isset($_SESSION["trial"])) {
    $_SESSION["trial"] = [
        "code_sent" => 0,
        "last_trial" => time()
    ];
}

if (time() - (int) $_SESSION["trial"]["last_trial"] > 86400) {
    $_SESSION["trial"] = [
        "code_sent" => 0,
        "last_trial" => time()
    ];
}

// --- --- ---


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_SESSION["loggedin"]) and $_SESSION["loggedin"]) {
        die(json_encode(["STATUS_CODE" => "004", "STATUS_TITLE" => "Already logged in!", "STATUS_TEXT" => "Log out from your current account to create a new account."]));
    }
    
    $fname = (string) $_POST["fname"];
    $email = (string) $_POST["email"];
    $username = (string) $_POST["username"];
    if (!validateString($username)){
        die(json_encode(["STATUS_CODE" => "0055", "STATUS_TITLE" => "Validation error!", "STATUS_TEXT" => "One of your fields is not valid please recheck."]));
    }
    $db = new DataBase();
    $userIfExits = $db->executeSql("select id from users where username=?",[$username],true);
    if ($userIfExits["rows"] !== 0){
        die(json_encode(["STATUS_CODE" => "006", "STATUS_TITLE" => "Error!", "STATUS_TEXT" => "Username is taken!!!!"]));
    }
    $password = $_POST["password"];
    $confirm = $_POST["confirm"];
    $bio = $_POST["bio"] ? (string) $_POST["bio"] : "No bio for the moment";
    $checkbox = $_POST["checkbox"] ? (int) 1 : (int) 0;
    // $checkbox = 1;

    signupValidation($fname, $email, $username, $password, $confirm, $checkbox);
    
    $code = random_int(100000, 999999);


    if (empty($email) or !validateEmail($email)) {
        die(json_encode(["STATUS_CODE" => "000", "STATUS_TITLE" => "Invalid email!", "STATUS_TEXT" => "Email validation error occurred. Make sure you are using a valid email."]));
    }

    if ((int) $_SESSION["trial"]["code_sent"] >= 5) {
        die(json_encode(["STATUS_CODE" => "002", "STATUS_TITLE" => "Limit reached!", "STATUS_TEXT" => "You have attempted to sign up 5 times in tha last 24 hours. Try again tomorrow."]));
    }

    // Include PHPMailer classes
    require_once '../admin/scripts/PHPMailer/src/Exception.php';
    require_once '../admin/scripts/PHPMailer/src/PHPMailer.php';
    require_once '../admin/scripts/PHPMailer/src/SMTP.php';

    // Create a new PHPMailer instance
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        // //Server settings
        // $mail->SMTPDebug = 0;
        // $mail->isSMTP();
        // $mail->Host = 'smtp.gmail.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'codopiaet@gmail.com';
        // $mail->Password = 'jskobrezvxrjsfua';
        // $mail->SMTPSecure = 'tls';
        // $mail->Port = 587;

        // // Recipients
        // $mail->setFrom('codopiaet@gmail.com', 'Codopia');
        // $mail->addAddress($email, "User");

        // // Content
        // $mail->isHTML(true);
        // $mail->Subject = 'Email Verification Code';
        // $mail->Body = "This is your verification code: <b>{$code}</b>";
        // $mail->AltBody = "This is your verification code: <b>{$code}</b>";

        // $mail->send();

        $_SESSION["trial"]["code_sent"]++;
        $_SESSION["trial"]["last_trial"] = time();
        $_SESSION["verification"] = $code; // OPTIMIZE: verify.php WORKS BASED ON THIS LINE

        die(json_encode(["STATUS_CODE" => "001", "STATUS_TITLE" => "Email sent!", "STATUS_TEXT" => "A verification code is sent. Please check your email."]));
    } catch (Exception $e) {
        
        die(json_encode(["STATUS_CODE" => "003", "STATUS_TITLE" => "Could not address email!", "STATUS_TEXT" => "Check your connection or contact the administrator."]));
    }
}
