<?php
require_once "../scripts/admin_check.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../../static/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Manager</title>
</head>

<body class="vh-100 d-flex justify-content-center align-items-center">
    <div class="container mt-2 position-fixed top-0">
        <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">/ Events</li>
            </ol>
        </nav>
    </div>

    <form action="./eventUploader.php" method="post">
        <div class="container col-md-6 shadow rounded-2 p-3">
            <div class="text-start p-2">
                <h1>Upload Event</h1>
            </div>
            <div class="input-group">

                <div class="container p-2">
                    <input type="text" name="title" placeholder="Event title" class="form-control">
                </div>
                <div class="container p-2">
                    <input type="number" name="xp" required placeholder="XP" class="form-control">
                </div>
                <div class="container p-2">
                    <input type="date" name="deadline" required placeholder="Dead line" class="form-control">
                </div>
                <div class="container p-2">
                    <textarea name="info" required class="form-control" placeholder="Event info" id="" cols="30" rows="5"></textarea>
                </div>
                <div class="container">
                    <button type="submit" name="submit" class="btn btn-primary col-md-12 mb-2">Upload</button>
                </div>
                <div class="container">
                    <button type="reset" class="btn btn-danger col-md-12 mb-2">Reset</button>
                </div>

            </div>
        </div>
    </form>
    <script src="../../static/bootstrap.bundle.min.js"></script>
</body>

</html>