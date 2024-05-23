<?php
session_start();
include("scripts/dashboard_setup.php");
require_once "../admin/scripts/classes.php";

if ($_SESSION["loggedin"] && !$_SESSION["admin_status"]) {
  header("Location: /dashboard");
  exit;
}
if (!isset($_SESSION["loggedin"])) {
  header("Location: /login");
  exit;
}
if (!$_SESSION["admin_status"]) {
  header("Location: /dashboard");
  exit;
}
$user_stmt = $con->prepare("SELECT COUNT(`username`) as NUMBER_OF_USERS FROM `users` ");
$user_stmt->execute();
$result_ = $user_stmt->setFetchMode(PDO::FETCH_ASSOC);
$result_ = $user_stmt->fetchAll();
$number_of_users = $result_[0]["NUMBER_OF_USERS"];
$feedback_stmt = $con->query("SELECT COUNT(`feedback_id`) as NUMBER_OF_FEEDBACKS FROM `feedbacks`");
$user_stmt->setFetchMode(PDO::FETCH_ASSOC);
$result_feedbacks = $feedback_stmt->fetchAll();
$number_of_feedbacks = $result_feedbacks[0]["NUMBER_OF_FEEDBACKS"];

$db = new DataBase();
$number_of_projects = $db->executeSql("SELECT COUNT(*) as NUMBER_OF_PROJECTS FROM projects", [], true)[0]["NUMBER_OF_PROJECTS"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="dash.css">
  <link rel="shortcut icon" href="/imgs/logo.png">
  <link rel="stylesheet" href="/static/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - <?php echo $_SESSION["username"] ?> </title>
  <style>

  </style>
</head>

<body class="vh-100 bg-light overflow-hidden d-flex justify-content-center align-items-center">

  <nav class="navbar  fixed-top" id="nav-b">
    <div class="container-fluid d-flex justify-content-around">
      <nav class="navbar">
        <a class="navbar-brand" href="../dashboard/">
          <img src="/imgs/logo.png" alt="Logo" width="75" class="d-inline-block align-text-top">
        </a>
      </nav>
      <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
          <li class="breadcrumb-item"><a class="breadcrumb-item" href="/term/">Terms / Regulations</a></li>
        </ul>
      </nav>
      <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon shadow-none"></span>
      </button>
      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header bg-dark">
          <button type="button" class="btn-close border border-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <h5 class="offcanvas-title text-light bg-dark text-light text-center admin" id="offcanvasNavbarLabel" style="cursor: pointer;"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
            <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
          </svg> <?php echo $_SESSION["full_name"] ?></h5>

        <div class="container bg-dark text-center">
          <p class="text-light bg-dark" style="cursor: pointer;">@<?php echo $_SESSION["username"] ?></p>
        </div>

        <div class="offcanvas-body bg-dark navbar-dark shadow">
          <ul class="navbar-nav justify-content-start flex-grow-1 pe-3 mt-2">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-house me-2" viewBox="0 0 16 16">
                  <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                </svg> Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./all-users/"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-check me-2" viewBox="0 0 16 16">
                  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4" />
                  <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10q.39 0 .74.025c.226-.341.496-.65.804-.918Q8.844 9.002 8 9c-5 0-6 3-6 4s1 1 1 1z" />
                </svg> Users</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./feedback/"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-journal-text" viewBox="0 0 16 16">
                  <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1z" />
                </svg> Feedbacks</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./all-projects/"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-buildings" viewBox="0 0 16 16">
                  <path d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022M6 8.694 1 10.36V15h5zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5z" />
                  <path d="M2 11h1v1H2zm2 0h1v1H4zm-2 2h1v1H2zm2 0h1v1H4zm4-4h1v1H8zm2 0h1v1h-1zm-2 2h1v1H8zm2 0h1v1h-1zm2-2h1v1h-1zm0 2h1v1h-1zM8 7h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zM8 5h1v1H8zm2 0h1v1h-1zm2 0h1v1h-1zm0-2h1v1h-1z" />
                </svg> All Projects</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./events/"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="me-2 bi bi-upload" viewBox="0 0 16 16">
                  <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5" />
                  <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z" />
                </svg> Upload Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./all-events/"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-balloon me-2" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M8 9.984C10.403 9.506 12 7.48 12 5a4 4 0 0 0-8 0c0 2.48 1.597 4.506 4 4.984M13 5c0 2.837-1.789 5.227-4.52 5.901l.244.487a.25.25 0 1 1-.448.224l-.008-.017c.008.11.02.202.037.29.054.27.161.488.419 1.003.288.578.235 1.15.076 1.629-.157.469-.422.867-.588 1.115l-.004.007a.25.25 0 1 1-.416-.278c.168-.252.4-.6.533-1.003.133-.396.163-.824-.049-1.246l-.013-.028c-.24-.48-.38-.758-.448-1.102a3 3 0 0 1-.052-.45l-.04.08a.25.25 0 1 1-.447-.224l.244-.487C4.789 10.227 3 7.837 3 5a5 5 0 0 1 10 0m-6.938-.495a2 2 0 0 1 1.443-1.443C7.773 2.994 8 2.776 8 2.5s-.226-.504-.498-.459a3 3 0 0 0-2.46 2.461c-.046.272.182.498.458.498s.494-.227.562-.495" />
                </svg> All Events</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./upload_test/"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi me-2 bi-code-slash" viewBox="0 0 16 16">
                  <path d="M10.478 1.647a.5.5 0 1 0-.956-.294l-4 13a.5.5 0 0 0 .956.294zM4.854 4.146a.5.5 0 0 1 0 .708L1.707 8l3.147 3.146a.5.5 0 0 1-.708.708l-3.5-3.5a.5.5 0 0 1 0-.708l3.5-3.5a.5.5 0 0 1 .708 0m6.292 0a.5.5 0 0 0 0 .708L14.293 8l-3.147 3.146a.5.5 0 0 0 .708.708l3.5-3.5a.5.5 0 0 0 0-.708l-3.5-3.5a.5.5 0 0 0-.708 0" />
                </svg> Upload Tests</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./notification/"><img src="/imgs/admin-bell.svg" width="30" height="30"> Notifications</a>
            </li>
            <li class="nav-item">
              <a href="./admin-table/" class="nav-link"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="me-2 bi bi-controller" viewBox="0 0 16 16">
                  <path d="M11.5 6.027a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m2.5-.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m-1.5 1.5a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1m-6.5-3h1v1h1v1h-1v1h-1v-1h-1v-1h1z" />
                  <path d="M3.051 3.26a.5.5 0 0 1 .354-.613l1.932-.518a.5.5 0 0 1 .62.39c.655-.079 1.35-.117 2.043-.117.72 0 1.443.041 2.12.126a.5.5 0 0 1 .622-.399l1.932.518a.5.5 0 0 1 .306.729q.211.136.373.297c.408.408.78 1.05 1.095 1.772.32.733.599 1.591.805 2.466s.34 1.78.364 2.606c.024.816-.059 1.602-.328 2.21a1.42 1.42 0 0 1-1.445.83c-.636-.067-1.115-.394-1.513-.773-.245-.232-.496-.526-.739-.808-.126-.148-.25-.292-.368-.423-.728-.804-1.597-1.527-3.224-1.527s-2.496.723-3.224 1.527c-.119.131-.242.275-.368.423-.243.282-.494.575-.739.808-.398.38-.877.706-1.513.773a1.42 1.42 0 0 1-1.445-.83c-.27-.608-.352-1.395-.329-2.21.024-.826.16-1.73.365-2.606.206-.875.486-1.733.805-2.466.315-.722.687-1.364 1.094-1.772a2.3 2.3 0 0 1 .433-.335l-.028-.079zm2.036.412c-.877.185-1.469.443-1.733.708-.276.276-.587.783-.885 1.465a14 14 0 0 0-.748 2.295 12.4 12.4 0 0 0-.339 2.406c-.022.755.062 1.368.243 1.776a.42.42 0 0 0 .426.24c.327-.034.61-.199.929-.502.212-.202.4-.423.615-.674.133-.156.276-.323.44-.504C4.861 9.969 5.978 9.027 8 9.027s3.139.942 3.965 1.855c.164.181.307.348.44.504.214.251.403.472.615.674.318.303.601.468.929.503a.42.42 0 0 0 .426-.241c.18-.408.265-1.02.243-1.776a12.4 12.4 0 0 0-.339-2.406 14 14 0 0 0-.748-2.295c-.298-.682-.61-1.19-.885-1.465-.264-.265-.856-.523-1.733-.708-.85-.179-1.877-.27-2.913-.27s-2.063.091-2.913.27" />
                </svg> Admins</a>
            </li>
          </ul>
        </div>



      </div>
    </div>
  </nav>
  <div class="container">
    <div class="list row justify-content-evenly g-5">
      <div class="box col-lg-3 col-md-5 col-sm-6 shadow-lg bg-light ml-2">
        <div class="text-center text-dark mt-4">
          <h3>Users</h3>
        </div>
        <h1 class="description text-center text-dark"><?php echo $number_of_users ?></h1>
      </div>

      <div class="box col-lg-3 col-md-5 col-sm-6 shadow-lg bg-light ml-2 gap-2">
        <h3 class="text-center text-dark mt-4">Feedbacks</h3>
        <h1 class="description text-center mb-5"><?php echo $number_of_feedbacks ?></h1>
      </div>

      <div class="box col-lg-3 col-md-5 col-sm-6 shadow-lg bg-light ml-2 gap-2">
        <h3 class="text-center text-dark mt-4">Projects</h3>
        <h1 class="description text-center mb-5"><?php echo $number_of_projects ?></h1>
      </div>
    </div>
  </div>
  <script src="/static/bootstrap.bundle.min.js"></script>
</body>

</html>