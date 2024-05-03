<?php

function cleanUp($value)
{
    $value = htmlspecialchars($value);
    $value = htmlentities($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = str_replace("'", "", $value);
    $value = str_replace('"', "", $value);
    return $value;
}

function validateInteger(&$value)
{
    $value = cleanUp($value);
    return preg_match('/\d+/', $value);
}
function validateString(&$value)
{
    $value = cleanUp($value);
    return preg_match("/[a-zA-Z]+/", $value);
}
function validateStringWithSpaces(&$value)
{
    $value = cleanUp($value);
    return preg_match("/[a-z A-Z0-9\-]+/", $value);
}
function validateDate(&$value)
{
    $value = cleanUp($value);
    return preg_match("/[0-9]{4}-[1-12]{2}-[1-30]{2}\s\d:\d:\d/", $value);
} // 2022-01-02
function validateEmail(&$value)
{
    $value = cleanUp($value);
    if (filter_var($value, FILTER_VALIDATE_EMAIL) == FALSE) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function validatePassword($value)
{
    $value = cleanUp($value);
    return preg_match("/\w{8,}/", $value);
}

function signupValidation(string $fname, string $email, string $username, $password, $confirm, int $checkbox)
{
    if (empty($fname) or empty($email) or empty($username) or empty($password) or empty($confirm)) {
        die(json_encode(["STATUS_CODE" => "0051", "STATUS_TITLE" => "Incomplete form!", "STATUS_TEXT" => "Please fill in all the necessary input fields."]));
    }
    if (!preg_match("/[a-zA-Z]\s[a-zA-Z]/", $fname)) {
        die(json_encode(["STATUS_CODE" => "0052", "STATUS_TITLE" => "Invalid full name!", "STATUS_TEXT" => "Please make sure you have typed a valid full name."]));
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die(json_encode(["STATUS_CODE" => "0053", "STATUS_TITLE" => "Invalid email!", "STATUS_TEXT" => "Please make sure you have typed a valid email."]));
    }
    if (strlen($password) < 8) {
        die(json_encode(["STATUS_CODE" => "0054", "STATUS_TITLE" => "Password too short!", "STATUS_TEXT" => "Please make sure your password contains at least 8 characters."]));
    }
    if ((preg_match("/^[a-zA-Z0-9_]+$/", $username) == 0)) {
        die(json_encode(["STATUS_CODE" => "0055", "STATUS_TITLE" => "Invalid username!", "STATUS_TEXT" => "Only letters, underscore and numbers are allowed for username."]));
    }
    if (strcmp($password, $confirm) != 0) {
        die(json_encode(["STATUS_CODE" => "0056", "STATUS_TITLE" => "Confirmation error!", "STATUS_TEXT" => "Passwords don't match."]));
    }
    // For strict password checks
    if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password) == 0) {
        die(json_encode(["STATUS_CODE" => "0056", "STATUS_TITLE" => "Password is not strong enough enough!", "STATUS_TEXT" => "Password doesn't meet our criteria."]));
    }
    if (!$checkbox) {
        die(json_encode(["STATUS_CODE" => "0057", "STATUS_TITLE" => "Checkbox error", "STATUS_TEXT" => "You must agree to our terms and regulations to proceed."]));
    }
    return true;
}
