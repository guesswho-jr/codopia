<?php

declare(strict_types=1);
require("../admin/scripts/dashboard_setup.php");
require_once("../admin/scripts/classes.php");
session_start();

if (isset($_SESSION["loggedin"]) and !$_SESSION["loggedin"]) {
  header("Location: /login");
  exit;
}

// --- --- to clear the session when we delete a user account --- ---
$db = new DataBase();
$isUser = $db->executeSql("SELECT id FROM users WHERE id = ?", [$_SESSION['userid']], true);

if ($isUser["rows"] == 0) {
  session_unset();
  session_destroy();
  header("Location: /login");
}
// --- --- # --- ---

$sessionUserId = $_SESSION["userid"];

$statementForThePointsAndUploads = $con->prepare("select points, uploads from users where id=?");
$statementForThePointsAndUploads->execute([$_SESSION["userid"]]);
$statementForThePointsAndUploads->setFetchMode(PDO::FETCH_ASSOC);
$resultForThePointsAndUploads = $statementForThePointsAndUploads->fetchAll();
$resultForThePointsAndUploads = $resultForThePointsAndUploads[0];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/imgs/logo.png">
  <link rel="stylesheet" href="side.css">
  <link rel="stylesheet" href="fix.css">
  <link rel="stylesheet" href="loader.css">
  <link rel="stylesheet" href="/static/bootstrap.min.css">
  <title>Dashboard - <?php echo strtolower($_SESSION["username"]); ?></title>
  <style>
    /* THIS PLACE IS NEEDED FOR THE THEME AND FONT CHANGES */
  </style>
</head>

<body class="d-flex justify-content-center align-items-center" style="background-color: rgb(235, 235, 235);">

  <div id="loader-container">
    <div class="loader"></div>
  </div>

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
            <a class="nav-link" href="#">
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
      //MARK: MAIN CONTAINER
      ?>
      <div class="container col-md-9 main-content-g position-relative">

        <?php
        //MARK: Search
        ?>

        <div class="row sticky-top py-3 d-flex d-flex justify-content-between px-5">
          <div class="container col-10 d-flex justify-content-center align-items-center bg-transparent p-0">
            <input type="text" class="form-control shadow Search" placeholder="Search" id="search">
          </div>
          <!-- <div class="container col-3 d-block d-md-none d-flex justify-content-center align-items-center">
            <a href="/"><img src="/imgs/logo.png" width="75" alt=""></a>
          </div> -->
          <div class="container col-2 d-flex justify-content-end align-items-center p-0">
            <!-- <img src="/imgs/activity-light.svg" alt="" width="40" height="40" style="cursor: pointer;"> -->
            <button id="notification-opener" class="btn border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi text-warning bi-bell" viewBox="0 0 16 16">
                <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6" />
              </svg>
              <br>
              <span id="notification-count" class="fw-bold">2</span>
            </button>
          </div>
        </div>

        <div class="row m-0 p-0 justify-content-center">

          <?php
          //MARK: Profile
          ?>

          <div class="row justify-content-center col-md-12">
            <div class="col-12 col-md-10 mt-2 text-center">
              <div class="card shadow">
                <div class="row g-0">
                  <div class="col-md-4 bg-dark text-white d-flex align-items-center justify-content-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                    </svg>
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <h3 class="card-title">@<?php echo strtolower($_SESSION["username"]); ?></h3>
                      <h5 class="card-subtitle mb-2 text-muted">
                        <?php echo $_SESSION["full_name"] ?>
                      </h5>
                      <p class="mb-2 text-muted"><?php echo $_SESSION["bio"] ?></p>

                      <div class="row">
                        <div class="col-md-6">
                          <p class="card-text"><strong>XP:</strong>
                            <?php echo "<span id='total-xp'>{$resultForThePointsAndUploads['points']}</span>" ?>
                          </p>
                        </div>
                        <div class="col-md-6">
                          <p class="card-text"><strong>Uploads:</strong>
                            <?php echo $resultForThePointsAndUploads["uploads"] ?>
                          </p>
                        </div>
                      </div>
                      <div class="mt-3">
                        <a href="./edit-profile/" class="btn btn-primary">Edit Profile</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <?php
            //MARK: Event
            ?>

            <div class="col-12 col-md-10 mt-2">
              <div class="card shadow">
                <div class="card-body">
                  <div class="card-title">
                    <?php
                    $db = new DataBase();
                    $r = $db->executeSql("select count(*) as count from events", [], true);
                    if ((int)$r[0]["count"] === 0) {
                      echo '<h2 class="text-center text-dark fw-bold">No events released so far</h2>
                  </div>
                  <div class="card-body">
                      ';
                    } else if ((int)$r[0]["count"] > 0) {
                      echo "
                      <h1 class=\"text-center text-dark fw-bold\">{$r[0]['count']} Event found</h1>
                      </div>
                  <div class=\"card-body\">
                      <h4 class=\"text-center p-2 text-muted\">Click read more for more information</h4>
                      <div class=\"container d-flex justify-content-center\">
                      <button class=\"btn btn-primary btn-lg col-md-6\" data-bs-toggle=\"modal\" data-bs-target=\"#eventModal\">
                        <i class=\"bi bi-info-circle me-10\"></i>Read More
                      </button>
                    </div>
                      ";
                    }
                    ?>

                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php
          //MARK: Project
          ?>

          <span id="comment-tracker"></span>

          <div class="row mb-5">
            <div class="container p-2 d-flex flex-wrap overflow-auto justify-content-center">
              <?php
              $statementForTheProjects = $con->prepare("SELECT * FROM projects INNER JOIN users ON projects.user_id = users.id ORDER BY project_time DESC");
              $statementForTheProjects->execute();
              $resultsForTheProjects = $statementForTheProjects->fetchAll(PDO::FETCH_ASSOC);

              if ($statementForTheProjects->rowCount() === 0) {
                echo '<div class="text-muted text-center">No projects uploaded so far</div>';
              } else {
                foreach ($resultsForTheProjects as $eachProjects) {
                  $eachProjectId = (string) "project_{$eachProjects['project_id']}";
                  $projectTime = date("M d, Y", $eachProjects['project_time']);

                  list($badgeName, $badgeColor) = getBadge((int)$eachProjects["points"]);
                  $admin = $eachProjects["is_admin"] ? "<div class='badge bg-success col-3 col-sm-2 col-xs-3 d-flex justify-content-center align-items-center' style='margin-right: 6px'>Admin</div>" : "";

                  $reported_by = json_decode($eachProjects["reported_by"], true);
                  $reportSVG = "";
                  if (in_array($sessionUserId, $reported_by)) $reportSVG = "exclamation-muted";
                  else $reportSVG = "exclamation";

                  $liked_by = json_decode($eachProjects["liked_by"], true);
                  $likeSVG = "";
                  $likeColor = "";
                  if (!in_array($sessionUserId, $liked_by)) {
                    $likeSVG = "heart-muted";
                    $likeColor = "text-dark";
                  } else {
                    $likeSVG = "heart";
                    $likeColor = "text-danger";
                  }

                  echo "
                  
                  <div class='container shadow col-10 col-md-9 rounded-3 mt-5 mb-5 border border-1 project-style bg-white pt-0'>
                    <div class='row d-flex px-2 pt-2'>
                      $admin
                      <div class='badge $badgeColor col-3 col-sm-2 col-xs-3 d-flex justify-content-center align-items-center' style='margin-right: 6px'>$badgeName</div>
                    </div>
                    <div class='row d-flex ps-2 pt-2'>
                      <div class='col-md-4 col-sm-4 col-6 fw-bold text-muted p-0 rounded-2' style='font-size: 0.75rem;'><span class='small-date-360'>{$projectTime}</span></div>
                    </div>
                    <div class='text-center p-2'>
                      <a href='profile.php?id={$eachProjects['user_id']}' class='nav-link'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='100' height='100' fill='currentColor' class='bi text-primary bi-person' viewBox='0 0 16 16'>
                          <path d='M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z' />
                        </svg>
                        <p class='search-item username'>@{$eachProjects['username']}<p></a>
                      <a href='profile.php?id={$eachProjects['user_id']}' class='nav-link'>
                        <h3 class='search-item full_name'>{$eachProjects['full_name']}</h3>
                      </a>
                      <div class='mt-1 text-center'>
                        <p class='text-muted'>{$eachProjects['bio']}</p>
                      </div>
                    </div>
  
                    <div class='text-center p-2'>
                      <h1 class='text search-item project_name'>{$eachProjects['project_name']}</h1>
                    </div>
  
                    <div class='text-center p-4'>
                      <p class='text search-item project_detail'>{$eachProjects['project_detail']}</p>
                    </div>
  
                    <div class='p-0 p-sm-4 d-flex justify-content-center align-items-center'>
                      <a href='download.php?file={$eachProjects['file_path']}' class='btn btn-lg shadow btn-success p-2 me-1 col-xl-3 col-lg-4 col-md-5 col-sm-4 col-6'><span class='small-font-360'>Download</span></a>
                      <button id='project_{$eachProjects['project_id']}' class='btn btn-lg btn-transparent p-2 border border-3 border-dark ms-1 col-xl-3 col-lg-4 col-md-5 col-sm-4 col-6' onclick='(copyLinkToClipboard(\"{$eachProjectId}\"))'>
                        <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-share hide-below-420' viewBox='0 0 16 16'>
                          <path d='M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z' />
                        </svg>
                        <span class='small-font-360'>Share</span>
                      </button>
                    </div>
  
                    <div class='row my-3'>
                      <div class='col-4 p-0 text-center'>
            
                          <button type='submit' class='btn btn-transparent p-2 liker' project_id='{$eachProjects['project_id']}'>
                            <img src='/imgs/$likeSVG.svg' width='30' height='30'>
                            <br>
                            <span class='$likeColor'>{$eachProjects['likes']}</span>
                          </button>
            
                      </div>
  
                      <div class='col-4 p-0 text-center'>
                        <button class='btn btn-transparent p-2 comment-opener' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasScrolling' aria-controls='offcanvasScrolling' projectId='{$eachProjects['project_id']}'>
                          <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                            <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                            <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                          </svg>
                          <br>
                          <span class='small comment-count'>{$eachProjects['comments']}</span>
                        </button>
                      </div>
  
                      <div class='col-4 p-0 text-center'>
                        <button class='btn btn-transparent text-dark p-2 pt-1 report-btn' projectId='{$eachProjects['project_id']}'>
                          <img src='/imgs/$reportSVG.svg' width='35' height='35'>
                          <br>
                          <span class='small report-count'>{$eachProjects['reports']}</span>
                        </button>
                      </div>
  
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
    </div>

    <div class="row">
      <?php
      //MARK: MOBILE VIEW NAVBAR
      ?>
      <div id="mob-view" class="navbar navbar-expand-md navbar-light bg-light d-md-none shadow border border-1" style="z-index: 999;">
        <ul class="mt-3 p-0" id="mv-ul">
          <li class="nav-item">
            <a href="#" class="nav-link">
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
    </div>
  </div>

  <?php
  //MARK: MODALS
  ?>

  <?php
  //MARK: Setting
  ?>
  <div class="modal fade" id="coolModal" tabindex="-1" role="dialog" aria-labelledby="coolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content text-center col-md-10 mb-5">
        <div class="modal-header">
          <h5 class="modal-title" id="coolModalLabel">Settings</h5>
          <button type="button" class="close shadow-none bg-white border border-dark rounded" data-bs-dismiss="modal" aria-label="Close">
            <span class="shadow-none" aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center d-flex flex-column">
          <div class="dropdown">
            <button class="btn border-0 dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              Fonts
            </button>
            <ul class="dropdown-menu">
              <li><button class="btn btn-transparent col-md-12 font-changer" style="font-family: 'Segoe UI', serif;">Segoe
                  UI</button></li>
              <li><button class="btn btn-transparent col-md-12 font-changer" style="font-family: 'Courier New', Courier, monospace;">Courier New</button></li>
              <li><button class="btn btn-transparent col-md-12 font-changer" style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Verdana</button></li>
              <li><button class="btn btn-transparent col-md-12 font-changer" style="font-family: 'Comic Sans MS';">Comic Sans MS</button></li>
              <li><button class="btn btn-transparent col-md-12 font-changer" style="font-family: 'Luminari';">Luminari</button></li>
            </ul>
          </div>
          <button class="col-12 mt-3 btn btn-dark" onclick="share()"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
              <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3" />
            </svg> Share</button>

          <a href="../logout/"><button class="col-12 btn mt-2 btn-danger">Log Out</button></a>
        </div>
        <div class="modal-footer">
          <a href="#" class="nav-link">Powered by <img src="../imgs/logo.png" style="height: 50px;" alt=""></a>
        </div>
      </div>
    </div>
  </div>


  <?php
  //MARK: Event
  ?>
  <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <?php
      $statementForTheEvent = $con->prepare("SELECT * FROM events ORDER BY deadline DESC LIMIT 1");
      $statementForTheEvent->execute();
      $resultForTheEvent = $statementForTheEvent->fetch(PDO::FETCH_ASSOC);

      if ($resultForTheEvent) {
        $date = strtotime($resultForTheEvent["deadline"]);
        $formattedDate = date("l, F d, Y", $date);
        $acceptedBy = json_decode($resultForTheEvent["accepted_by"], true);
        if (in_array($sessionUserId, $acceptedBy)) {
          $joinBgColor = "#dc3545"; // if already accepted
          $joinText = "Reject";
        } else {
          $joinBgColor = "#0d6efd"; // if already accepted
          $joinText = "Join";
        }
        echo "
              
          <div class='modal-content'>
            <form action='./acceptHandler.php' method='post' id='event-form' event_id='{$resultForTheEvent['event_id']}' xp='{$resultForTheEvent['xp']}'>
              <div class='modal-header'>
                <h5 class='modal-title' id='eventModalLabel'><b>Upcoming Event</b></h5>
                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
              </div>

              <div class='modal-body'>
                <h5><b>{$resultForTheEvent['event_name']}</b></h5>
                <p>{$resultForTheEvent['event_desc']}</p>
                <h5><b>Event Details</b></h5>

                <ul>
                  <li>Date: {$formattedDate}</li>
                  <li>XP: <span id='event-xp'>{$resultForTheEvent['xp']}</span></li>
                  <div class='form-check'>
                    <input name='condition' class='form-check-input condition' required type='checkbox' id='flexCheckDefault'>
                    <label class='form-check-label' for='flexCheckDefault'>
                      I have acknowledged the conditions
                    </label>
                  </div>
                </ul>
              </div>

              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                <div id='liveAlertPlaceholder'></div>
                <button type='submit' class='btn join-btn' style='color: white; background-color: {$joinBgColor};'>{$joinText}</button>
              </div>
            </form>
          </div>
    
          ";
      } else {
        echo "
              
          <div class='modal-content'>
            <div class='modal-header'>
              <h5 class='modal-title' id='eventModalLabel'>Upcoming Event</h5>
              <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
            </div>
            <div class='modal-body'>
              <p>Currently, there is no available event</p>
            </div>
            <div class='modal-footer'>
              <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
              <div id='liveAlertPlaceholder'></div>
              </form>
            </div>
          </div>

          ";
      }

      ?>
    </div>
  </div>

  <!-- COMMENTS BAR -->
  <div class='offcanvas offcanvas-start' data-bs-scroll='true' data-bs-backdrop='false' tabindex='-1' id='offcanvasScrolling' aria-labelledby='offcanvasScrollingLabel'>
    <div class='offcanvas-header'>
      <h5 class='offcanvas-title' id='offcanvasScrollingLabel'>Comments</h5>
      <button type='button' class='btn-close shadow-none' data-bs-dismiss='offcanvas' aria-label='Close'></button>
    </div>
    <div class='offcanvas-body'>
      <div class='container p-0' id="comment-bar">
        <div class='d-flex'>
          <input type='text' id="my-comment" class='form-control me-1' placeholder='Leave your comments'>
          <button id="comment-submit" class='btn btn-dark btn-outline-light border border-outline-2 border-outline-dark'>Send</button>
        </div>
        <div class="container" id="comment-container">
          <div class='container my-3 p-3 border border-2 border-muted shadow-sm bg-light'>
            <div class='col-12'>
              <span class='bg-dark text-white col-3' style='width: 30px; height: 30px; display: inline-flex; justify-content: center; align-items: center; border-radius: 50%;'>U</span>
              <a href='' class='text-dark fw-bold col-9' style='text-decoration: none;'>@username</a>
            </div>
            <div class='col-12'>
              <p class='m-0'>comment text</p>
              <div class='d-flex justify-content-between'>
                <div class='text-center'>
                  <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-suit-heart' viewBox='0 0 16 16'>
                    <path d='m8 6.236-.894-1.789c-.222-.443-.607-1.08-1.152-1.595C5.418 2.345 4.776 2 4 2 2.324 2 1 3.326 1 4.92c0 1.211.554 2.066 1.868 3.37.337.334.721.695 1.146 1.093C5.122 10.423 6.5 11.717 8 13.447c1.5-1.73 2.878-3.024 3.986-4.064.425-.398.81-.76 1.146-1.093C14.446 6.986 15 6.131 15 4.92 15 3.326 13.676 2 12 2c-.777 0-1.418.345-1.954.852-.545.515-.93 1.152-1.152 1.595zm.392 8.292a.513.513 0 0 1-.784 0c-1.601-1.902-3.05-3.262-4.243-4.381C1.3 8.208 0 6.989 0 4.92 0 2.755 1.79 1 4 1c1.6 0 2.719 1.05 3.404 2.008.26.365.458.716.596.992a7.6 7.6 0 0 1 .596-.992C9.281 2.049 10.4 1 12 1c2.21 0 4 1.755 4 3.92 0 2.069-1.3 3.288-3.365 5.227-1.193 1.12-2.642 2.48-4.243 4.38z' />
                    <span class='small ms-1'>23</span>
                  </svg>
                </div>
                <span class='text-muted d-flex flex-column justify-content-end small'>May 1, 2024</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- NOTIFICATION BAR -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasRightLabel">Notifications</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr>
    <div class="offcanvas-body">

      <?php
      require_once "../admin/scripts/classes.php";
      $db = new DataBase();

      $notes = $db->executeSql("SELECT notify_title, notify_message, notify_to, notify_time FROM notifications ORDER BY notify_time DESC", return: true);
      if ($notes["rows"] == 0) {
        echo "
          <div class='container text-center'>
            <div class='col-12'>
                <h4 class='m-0'>Your inbox is empty <img src='../imgs/box.svg' width='50' height='50'></h4>
            </div>
          </div>
        ";
      } else if ($notes["rows"] != 0) {
        foreach ($notes as $note) {
          if (is_array($note)) {
            $notifyFullMessage = str_replace("%USER%", strtolower($_SESSION["username"]), $note["notify_message"]);
            $notifyTime = date("M d, Y", $note["notify_time"]);
            $notifyShortMessage = substr($notifyFullMessage, 0, 30);
            if (json_decode($note["notify_to"], true)[0] == "everyone") {
              echo "
                <div class='container notification mt-3 bg-light p-4 rounded shadow-sm'>
                  <div class='d-flex justify-content-between align-items-center'>
                    <div>
                      <button class='btn btn-close text-danger'></button>
                      <span><b>{$note['notify_title']}</b></span>
                    </div>
                    <div>
                      <span class='text-muted'>$notifyTime</span>
                    </div>
                  </div>
                  <hr class='my-3'>
                  <div class='d-flex justify-content-between align-items-center'>
                    <span>$notifyShortMessage...</span>
                    <button type='button' class='btn p-1 text-secondary border' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                      Read more
                    </button>
                  </div>
                </div>
              ";
            } else if (in_array(strtolower($_SESSION["username"]), json_decode($note["notify_to"], true))) {
              echo "
                <div class='container notification mt-3 bg-light p-4 rounded shadow-sm'>
                  <div class='d-flex justify-content-between align-items-center'>
                    <div>
                      <button class='btn btn-close text-danger'></button>
                      <span><b>{$note['notify_title']}</b></span>
                    </div>
                    <div>
                      <span class='text-muted'>$notifyTime</span>
                    </div>
                  </div>
                  <hr class='my-3'>
                  <div class='d-flex justify-content-between align-items-center'>
                    <span>$notifyShortMessage...</span>
                    <button type='button' class='btn p-1 text-secondary border' data-bs-toggle='modal' data-bs-target='#staticBackdrop'>
                      Read more
                    </button>
                  </div>
                </div>
              ";
            }
          }
        }
      }

      ?>

    </div>
  </div>

  <!-- Notification Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">

      <div class="modal-content" id="notification-modal">
        <div class='modal-header'>
          <h5 class='modal-title' id='staticBackdropLabel'>Message</h5>
          <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
        </div>
        <div class='modal-body'>
          <p> In the heart of the bustling city, amidst the cacophony of honking cars and chatter of passersby, there exists a hidden oasis, a quaint bookstore tucked away on a narrow cobblestone street. Its weathered exterior bears testament to the passage of time, yet inside, it emanates a timeless charm. Rows of bookshelves stand tall, each one a portal to a different world, inviting exploration and discovery. The scent of old paper mingles with the aroma of freshly brewed coffee, creating an atmosphere where every page turned feels like a journey embarked upon. Here, amidst the books and the whispers of stories yet untold, one can find solace from the chaos outside, losing oneself in the endless possibilities of literature.</p>
        </div>
      </div>

    </div>
  </div>

</body>

<script>
  if (localStorage.getItem("font-family")) document.querySelector("style").innerHTML = `*{font-family:"${localStorage.getItem("font-family")}";}`
</script>
<script src="/static/sweetalert2.js"></script>
<script src="/static/bootstrap.bundle.min.js"></script>
<script src="./loader.js"></script>
<script src="./script.js"></script>
<script src="./request.js"></script>
<script src="./comment.js"></script>
<script src="./report.js"></script>
<script src="./notify.js"></script>

</html>