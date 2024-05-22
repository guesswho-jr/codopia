<?php
require_once "../admin/scripts/validation.php";
require_once "../admin/scripts/classes.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/bootstrap.min.css">
    <link rel="stylesheet" href="./fix.css">
    <link rel="stylesheet" href="./side.css">
    <title>User Profile</title>
    <style>
        .form-control:hover {
            box-shadow: none;
            border-color: inherit;
        }

        .user-initial {
            font-size: 75px;
            border-radius: 50%;
            padding: 30px;
            cursor: pointer;
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease-in-out;
        }

        .user-initial:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
            transition: all 0.2s ease-in-out;

        }
    </style>

<body class="">
    <div class="container-fluid">
        <div class="row pt-5 pt-md-0">
            <?php
            //MARK: SIDEBAR
            ?>
            <!-- #1e2d40 -->
            <div id="sidebar" class="sidebar d-none d-md-block col-md-3 sidebar-g position-relative shadow" style="background-color: #1e2d40;">
                <div class="logo d-flex h-25 justify-content-center align-items-center">
                    <a href="../"><img src="/imgs/text-logo.png" style="width: 187.5px;" alt="codopia logo"></a>
                </div>
                <ul class="nav mt-5 flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="./">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-house" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                            </svg> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="../test_page/" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-code-slash" viewBox="0 0 16 16">
                                <path d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294zM4.854 4.146a.5.5 0 0 1 0 .708L1.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0m6.292 0a.5.5 0 0 0 0 .708L14.293 8l-3.147 3.146a.5.5 0 0 0 .708.708l3.5-3.5a.5.5 0 0 0 0-.708l-3.5-3.5a.5.5 0 0 0-.708 0" />
                            </svg> Test</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./projects/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-buildings" viewBox="0 0 16 16">
                                <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z" />
                                <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z" />
                            </svg> Projects</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./upload/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-upload" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                            </svg> Upload</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./feedback/">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-journal-arrow-up" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 11a.5.5 0 0 0 .5-.5V6.707l1.146 1.147a.5.5 0 0 0 .708-.708l-2-2a.5.5 0 0 0-.708 0l-2 2a.5.5 0 1 0 .708.708L7.5 6.707V10.5a.5.5 0 0 0 .5.5" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                            </svg> Feedback</a>
                    </li>
                    <li class="nav-item position-absolute bottom-0 mb-3">
                        <div class="container col-12">
                            <button type="button" class="btn btn-dark border-0" data-bs-toggle="modal" data-bs-target="#coolModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                                </svg> More
                            </button>
                        </div>
                    </li>
                </ul>
            </div>

            <?php
            //MARK: MOBILE VIEW NAVBAR
            ?>
            <div id="mob-view" class="navbar navbar-expand-md navbar-light bg-light d-md-none shadow border border-1" style="z-index: 999;">
                <ul class="mt-3 p-0" id="mv-ul">
                    <li class="nav-item">
                        <a href="./" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-house" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                            </svg></a>
                        <!-- HOME -->
                    </li>

                    <li>
                        <a href="../test_page/" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi me-2 bi-balloon" viewBox="0 0 16 16">
                                <path d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294zM4.854 4.146a.5.5 0 0 1 0 .708L1.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0m6.292 0a.5.5 0 0 0 0 .708L14.293 8l-3.147 3.146a.5.5 0 0 0 .708.708l3.5-3.5a.5.5 0 0 0 0-.708l-3.5-3.5a.5.5 0 0 0-.708 0" />
                            </svg></a>
                        <!-- TEST -->
                    </li>

                    <li>
                        <a href="./projects/" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-buildings" viewBox="0 0 16 16">
                                <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z" />
                                <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z" />
                            </svg></a>
                        <!-- PROJECTS -->
                    </li>

                    <li>
                        <a href="./upload/" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-upload" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                            </svg></a>
                        <!-- UPLOADS -->
                    </li>

                    <li>
                        <a href="./feedback/" class="nav-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-bookmark me-2" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8" />
                                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                            </svg></a>
                        <!-- FEEDBACKS -->
                    </li>

                    <li>
                        <button class="btn btn-transparent border-0 mb-5 p-0" data-bs-toggle="modal" data-bs-target="#coolModal"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                            </svg></button>
                        <!-- SETTINGS -->
                    </li>
                </ul>
            </div>

            <?php
            //MARK: MAIN CONTAINER
            ?>
            <div class="container col-md-9 main-content-g position-relative pb-5">
                <!-- <div class="row sticky-top py-3 d-flex d-flex justify-content-between px-5">
                    <div class="container col-10 d-flex justify-content-center align-items-center bg-transparent p-0">
                        <div class="container search col-12 d-flex justify-content-center shadow rounded-4 align-items-center bg-white border border-dark p-2">
                            <input type="text" class="form-control bg-transparent border-0 me-2" placeholder="Search" id="search">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-search me-2" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </div>
                    </div>
                </div> -->
                <?php
                if (!$_GET["id"]) header("Location: /dashboard");

                if (!$_GET["id"]) die(1);
                if ($_SERVER['REQUEST_METHOD'] !== "GET") die();
                if (!validateInteger($_GET["id"])) exit;
                $userID = $_GET["id"];
                $db = new DataBase();
                $user = $db->executeSql("select username, points, bio, is_admin from users where id=?", [$userID], true);

                if ($user["rows"] == 0) die("<div class='alert alert-danger text-center'>User not found!</div>");
                ?>
                <div class="container mt-5 p-2">
                    <div class="container profile-card shadow rounded-2 bg-light p-3 col-md-8">
                        <div class="profile-info p-2">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="user-initial  text-light "><?php echo strtoupper($user[0]["username"][0]); ?></div>
                                </div>
                                <div class="col p-3">
                                    <h2>Username: @<?php echo $user[0]["username"] ?></h2>
                                    <p>Points: <?php echo $user[0]["points"] ?></p>
                                    <p>Bio: <?php echo $user[0]["bio"] ?></p>
                                    <div>
                                        <?php
                                        list($text, $class) = getBadge((int)$user[0]["points"]);
                                        // echo "<div class=\"badge $class\" style='font-size: 20px;'>$text</div>";
                                        echo "<div class='badge $class' style='font-size: 20px; cursor: pointer;'>$text</div>";
                                        echo $user[0]["is_admin"] ? "<div class='badge bg-success text-white' style='font-size: 20px;'>Admin</div>" : "";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- input -->
                <div class="container search col-md-8 d-flex mt-5 justify-content-center shadow rounded-4 align-items-center bg-transparent p-2">
                    <input type="text" class="form-control bg-transparent border-0 me-2" placeholder="Search" id="search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-search me-2" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </div>

                <div class="container d-flex flex-column align-items-center mb-5">
                    <?php
                    $profileProjects = $db->executeSql("SELECT project_id, project_name, project_detail, project_time, likes, comments, reports FROM projects WHERE user_id = ?", [$_GET["id"]], true);
                    if ($profileProjects["rows"] == 0) die("<div class='alert alert-danger text-center'>@{$user[0]['username']} has not uploaded a project yet!</div>");
                    foreach ($profileProjects as $projects) {
                        if (is_array($projects)) {
                            $time = date("M d, Y", $projects["project_time"]);
                            echo "
                            <div class='row bg-light shadow border border-dark rounded-4 mt-5 col-12 col-lg-8 col-md-10 project-style'>
                                <div class='col-6 border border-dark bg-dark text-white' style='border-top-left-radius: 15px; border-bottom-left-radius: 15px;'>
                                    <h2 class='search-item project-name'>{$projects['project_name']}</h2>
                                    <h6 class='search-item project-detail'>{$projects['project_detail']}</h6>
                                </div>
                                <div class='col-2'>
                                    <div class='d-flex align-items-center mt-2'>
                                        <img src='/imgs/heart.svg' width='30' height='30'>
                                        <p class='d-flex align-items-center my-0 ms-1'>{$projects['likes']}</p>
                                    </div>
                                    <div class='d-flex align-items-center mt-2'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                                            <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z' />
                                            <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0' />
                                        </svg>
                                        <p class='d-flex align-items-center my-0 ms-1'>{$projects['comments']}</p>
                                    </div>
                                    <div class='d-flex align-items-center mt-2 mb-2'>
                                        <img src='/imgs/exclamation.svg' width='30' height='30'>
                                        <p class='d-flex align-items-center my-0 ms-1'>{$projects['reports']}</p>
                                    </div>
                                </div>
                                <div class='col-4 d-flex flex-column justify-content-center align-items-end'>
                                    <p class='text-end'><span class='bg-warning fw-bold p-2 rounded small shrink-below-450'>$time</span></p>
                                    <a href='./index.php#project_{$projects['project_id']}' class='btn btn-outline-info p-3 rounded-4 fw-bold shrink-below-450'>Go to >></a>
                                </div>
                            </div>
                            ";
                        }
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const projectStyles = document.querySelectorAll('.project-style');

        searchInput.addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            projectStyles.forEach(function(project) {
                const projectName = project.querySelector('.search-item.project-name').textContent.toLowerCase();
                const projectDetail = project.querySelector('.search-item.project-detail').textContent.toLowerCase();
                if (
                    projectName.includes(searchQuery) ||
                    projectDetail.includes(searchQuery)
                ) {
                    project.style.display = 'flex';
                } else {
                    project.style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>