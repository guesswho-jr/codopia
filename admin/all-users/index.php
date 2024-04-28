<?php
include("../scripts/dashboard_setup.php");
session_start();

$sql = "SELECT * FROM `users`  \n" . "ORDER BY `users`.`is_admin` DESC";
$topUserStatement = $con->prepare($sql);
$topUserStatement->execute();
$topUserStatement->setFetchMode(PDO::FETCH_ASSOC);
$resultTopUser = $topUserStatement->fetchAll();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/static/bootstrap.min.css">
  <link rel="shortcut icon" href="/imgs/logo.png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Users</title>
</head>

<body class="bg-light">
  <div class="container">
    <nav style="--bs-breadcrumb-divider: '/'; " aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../" style="text-decoration: none;">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Users</li>
      </ol>
    </nav>
    <div class="mb-1" style="float: right;">
      <input type="text" style="border: none; height: 30px;" placeholder="Search by username" class="mt-2 me-2" id="searchInput">
      <button class="btn btn-dark me-2"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
        </svg></button>
    </div>
    <table class="table table-hover table-bordered table-striped shadow">
      <thead class="thead-dark">
        <tr>
          <th scope="col">User ID</th>
          <th scope="col">Name</th>
          <th scope="col">Username</th>
          <th scope="col">Project</th>
          <th scope="col">Point</th>
          <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($resultTopUser as $user) {
          $tempUser = $user["full_name"];
          $username = $user["username"];
          $projects = $user["uploads"];
          $points = $user["points"];
          $id = $user["id"];
          echo "<tr>\n";
          echo "<td>$id</td>\n";
          echo "<td>$tempUser</td>\n";
          echo "<td class=\"inputData\">@$username</td>\n";
          echo "<td>$projects projects</td>\n";
          echo "<td>$points XP</td>\n";
          echo "<td><button class=\"btn btn-danger delete_user\" userId=\"$id\">Delete</button></td>\n";
          echo "</tr>\n";
        }
        echo "</tbody>";
        echo "</table>";

        ?>

  </div>
  <script src="/static/bootstrap.bundle.min.js"></script>
  <script>
    const deleteUserButton = document.querySelectorAll('.delete_user');
    const searchInput = document.getElementById("searchInput");
    const elements = document.querySelectorAll(".inputData");

    searchInput.addEventListener("keyup", function(event) {


      elements.forEach(element => {
        // console.log(element.textContent.toLowerCase().includes(event.key), element);

        if (element.textContent.toLowerCase().includes(searchInput.value)) {
          element.parentElement.style.display = 'table-row';

        } else if (!element.textContent.toLowerCase().includes(searchInput.value)) {
          element.parentElement.style.display = "none";
        }



      }); // the foreach loop


    }) // the event listener
    function deleteUser(id) {
      var formData = new FormData();
      // const datatoSend = {
      //   id: id,
      //   adminStatus: "<?php echo $_SESSION["admin_status"] ?>"
      // }
      formData.append("id", id);
      // formData.append("adminStatus",datatoSend.adminStatus);
      fetch("submit_query.php", {
          method: "POST",
          body: formData,
        }).then(response => response.text())
        .then(data => alert(data))
        .catch(error => alert("Error occured " + error));

    }
    // Simple script to delete user YEAH
    deleteUserButton.forEach(element => {
      let userId = element.getAttribute("userId");
      element.addEventListener("click", () => {
        const response = confirm(`Are you sure do you want to delete user with the id of ${userId} (y/n) lowercase`);
        if (response) {
          deleteUser(userId);
        }
      })
    });
  </script>
</body>

</html>