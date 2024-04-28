<?php
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
  <title>All Projects</title>
</head>

<body>

  <div class="container col-12 main-content-g position-relative">
    <nav style="--bs-breadcrumb-divider: '/'; " aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../" style="text-decoration: none;">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Projects</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped" id="project_table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Project Name</th>
            <th>Project Detail</th>
            <th>Released Date</th>
            <th>Likes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $db = new DataBase();
          $projects = $db->executeSql("SELECT project_id, project_name, project_detail, project_time, likes, username, user_id FROM projects INNER JOIN users ON projects.user_id = users.id ORDER BY project_time DESC", [], true);
          if ($projects["rows"] != 0) {
            for ($i = 0; $i < count($projects) - 1; $i++) {
              $projectTime = date("M d, Y", $projects[$i]['project_time']);
              echo "
                <tr>
                  <td>{$projects[$i]['username']}</td>
                  <td>{$projects[$i]['project_name']}</td>
                  <td>{$projects[$i]['project_detail']}</td>
                  <td>{$projectTime}</td>
                  <td>{$projects[$i]['likes']}</td>
                  <td><button projectId='{$projects[$i]['project_id']}' userId='{$projects[$i]['user_id']}' class='btn btn-danger p-1 delete-btn'>Delete</button></td>
                </tr>
              ";
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="/static/sweetalert2.js"></script>
  <script src="./delete.js"></script>
</body>

</html>