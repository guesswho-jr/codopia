<?php
require_once "../scripts/admin_check.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/imgs/logo.png">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <title>Notification</title>
</head>

<body>
    <div class="container-fluid px-5 pb-5">
        <nav style="--bs-breadcrumb-divider: '/'; " aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../" style="text-decoration: none;">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Notifications</li>
            </ol>
        </nav>
        <div class="container p-1 d-flex flex-column align-items-center shadow col-8">
            <div class="card-title mt-3">
                <h1>Notify</h1>
            </div>
            <form id="notify-form" class="p-3 col-12 text-center">
                <div class="card-body">
                    <input type="text" id="users" class="form-control" placeholder="Username(s)">
                    <div class="form-check text-start">
                        <input class="form-check-input check" type="checkbox" id="flexCheckDefault">
                        <label class="form-check-label fw-bold" for="flexCheckDefault">Notify all users</label>
                    </div>
                    <input type="text" id="title" class="form-control mb-1" placeholder="Enter your title" required>
                    <textarea id="message" cols="30" rows="10" class="form-control" placeholder="Enter your message" required></textarea>
                </div>
                <button class="btn btn-primary col-6 mt-3" type="submit" id="send">Send</button>
            </form>
        </div>
    </div>

    <script src="/static/bootstrap.bundle.min.js"></script>
    <script src="./script.js"></script>
</body>

</html>