<?php

declare(strict_types=1);
require_once "../scripts/classes.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/imgs/logo.png">
    <link rel="stylesheet" href="/dashboard/projects/project.css">
    <link rel="stylesheet" href="/dashboard/side.css">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <link rel="stylesheet" href="/static/sweetalert2.min.css">
    <title>All Events</title>
</head>

<body>

    <div class="container col-12 main-content-g position-relative">
        <nav style="--bs-breadcrumb-divider: '/'; " aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../" style="text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">All Events</li>
            </ol>
        </nav>
        <div class="table-responsive">
            <table class="table table-hover table-striped" id="project_table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Event</th>
                        <th>Details</th>
                        <th>XP</th>
                        <th>Deadline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $db = new DataBase();
                    $events = $db->executeSql("SELECT * FROM events ORDER BY deadline ASC", [], true);
                    if ($events["rows"] != 0) {
                        for ($i = 0; $i < count($events) - 1; $i++) {
                            $deadline = new DateTime($events[$i]["deadline"]);
                            $acceptedBy = json_decode($events[$i]["accepted_by"], true);
                            foreach ($acceptedBy as $acceptedUserId) {
                                $user = $db->executeSql("SELECT id, email, username FROM users WHERE id = ?", [$acceptedUserId], true)[0];
                                echo "
                                    <tr>
                                        <td>@{$user['username']}</td>
                                        <td><a href='https://mail.google.com/mail/u/0/?fs=1&tf=cm&source=mailto&to={$user['email']}' style='text-decoration: none;'>{$user['email']}</a></td>
                                        <td>{$events[$i]['event_name']}</td>
                                        <td>{$events[$i]['event_desc']}</td>
                                        <td>{$events[$i]['xp']}</td>
                                        <td>{$deadline->format('M d, Y')}</td>
                                    </tr>
                                ";
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="/static/sweetalert2.js"></script>
</body>

</html>