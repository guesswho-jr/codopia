<?php
require_once "../../admin/scripts/classes.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practice</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        .post {
            border: 1px solid black;
            padding: 25px;
            margin: 25px;
        }
        .liked {
            color: white;
            background-color: crimson;
            border: 1px solid crimson;
        }
        .unliked {
            color: crimson;
            background-color: white;
            border: 1px solid crimson;
        }
    </style>
</head>
<body>
    <?php
    $db = new DataBase();
    $results = $db->executeSql("SELECT * FROM trial", [], true);

    for ($i = 0; $i < count($results) - 1; $i++) {
        echo "
        <div class='post'>
            <p>{$results[$i]['post']}</p>
            <span>{$results[$i]['likes']}</span>
            <button post_id='{$results[$i]['id']}' class='liker'>Like</button>
        </div>
        ";
    }
    ?>

    <script src="./request.js"></script>
</body>
</html>