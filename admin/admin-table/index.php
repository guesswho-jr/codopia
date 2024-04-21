<?php
require("../scripts/admin_check.php");
require("../scripts/dashboard_setup.php");

if (!$_SESSION["admin_status"]) {
  header("Location: /dashboard");
  exit;
}
if (!$_SESSION["loggedin"]) {
  header("Location: /login");
  exit;
}

$adminPeopleStatement = $con->query("select * from admins");
$adminPeople = $adminPeopleStatement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/static/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin-table</title>

</head>

<body class="bg-light">

  <div class="container">
    <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Admin-Table</li>
      </ol>
    </nav>

    <a href="add-admin/ad.html" class="btn btn-success shadow"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle me-2" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
      </svg> Add Admins</a>
  </div>

  <div class="container">
    <form action="" class="mb-1" style="float: right;">
      <input type="text" style="border: none; height: 30px;" placeholder="Search username" class="mt-2 me-2" id="searchInput">
      <button class="btn btn-dark me-2"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
        </svg></button>
    </form>
    <table class="table table-hover table-bordered table-striped shadow">
      <thead class="thead-dark">
        <tr>
          <th scope="col"><Small>Name</Small></th>
          <th scope="col"><small>Username</small></th>
          <th scope="col"><small>Email</small></th>
          <th scope="col"><small>Work catagory</small></th>

        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($adminPeople as $adminPerson) {
          $full = $adminPerson["full_name"];
          $category = $adminPerson["category"];
          $emailAdmin  = $adminPerson["email"];
          $adminUsername = $adminPerson["username"];
          echo "<tr>";
          echo "  <td>$full</td>";
          echo "  <td class=\"inputData\">@$adminUsername</td>";
          echo "  <td>$emailAdmin</td>";
          echo "  <td>$category</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="/static/bootstrap.bundle.min.js"></script>
  <script>
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



      });
    });
  </script>
</body>

</html>