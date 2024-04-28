<?php
require("../../scripts/admin_check.php");
require("../../scripts/dashboard_setup.php");

if (!$_SESSION["admin_status"]) {
  header("Location: /dashboard");
  exit;
}
if (!$_SESSION["loggedin"]) {
  header("Location: /login");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add admin</title>

</head>
<body class="bg-light">


<div class="container mt-5">
  
  <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/">Home</a></li>
    <li class="breadcrumb-item"><a href="../">Admins Table</a></li>
    <li class="breadcrumb-item active" aria-current="page">Add admins</li>
  </ol>
</nav>
<form action="/admin-table/admin.html" id="form">
    <div class="input-group justify-content-center">
      <div class="col-lg-4 col-md-3 col-xl-3">
        <div class="row"><input type="text" placeholder="Username"  class="form-control mt-2" required="" name="username"></div>
      <!-- <div class="row"><input type="text" placeholder="Full name" class="form-control mt-2" required name="full_name"></div> -->
      <div class="row">
      <select name="category" class="form-control mt-2">
        <option value="" selected>Speciality</option>
        <option value="Front-end">Front end</option>
        <option value="Back-end">Back-end</option>
        <option value="Full-stack">Full stack</option>
      </select>
    </div>
    <!-- <div class="row"><input type="email" placeholder="Email" required name="email" class="form-control  mt-4"></div> -->
    <div class="row"><input type="submit" value="Done" class="btn btn-dark mt-3"></div>
  </div>
  
</div>
    </form>
     
</div>
    <script src="/static/bootstrap.bundle.min.js"></script>
    <script src="submit.js"></script>
</body>
</html>