

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <script src="/static/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>
<body>
<?php
session_start();
require_once "../admin/scripts/validation.php";
require_once "../admin/scripts/classes.php";

if (!$_GET["id"]) header("Location: /dashboard");

if (!$_GET["id"]) die(1);
if ($_SERVER['REQUEST_METHOD']!=="GET") die();
if (!validateInteger($_GET["id"])) exit;
$userID = $_GET["id"];
$db = new DataBase();
$user = $db->executeSql("select username, points, bio from users where id=?", [$userID], true);

if ($user["rows"]==0) die("<div class='alert alert-danger text-center'>User not found!</div>");

?>
<div class="container-lg d-flex shadow-lg col-6 p-5 justify-content-center" style="align-items: center;">
    <div class="row " >
        <div class="col-md-12">
           <?php 
            $colors = ["bg-success", "bg-primary", "bg-secondary", "bg-danger", "bg-warning"];
            $rand = rand(0, count($colors));
            echo '<div class="' . $colors[$rand -1] . ' px-5 py-3 text-uppercase w-50 h-50 text-light mx-5" style="font-size: 75px;border-radius: 50%;">';
            echo $user[0]["username"][0] ?></div>
            <div class="fs-2 text-center">Username: @<?php echo $user[0]["username"] ?></div>
            <div class="fs-3">Points: <?php echo $user[0]["points"] ?></div>
            <div class="text-center fs-3">Bio: <?php echo $user[0]["bio"] ?></div>
            Badges:
            <?php
            list($text, $class) = getBadge((int)$user[0]["points"]);
            echo "<div class=\" badge $class\" style='font-size: 20px;'>$text</div>";
            echo $_SESSION["admin_status"] ? "<div class='badge badge-success'>Admin</div>": "";
            ?>
        </div>
    </div>
</div>
</body>
</html>