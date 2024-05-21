<?php
require("../scripts/admin_check.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/imgs/logo.png">
    <link rel="stylesheet" href="/static/bootstrap.min.css">
    <link rel="stylesheet" href="/static/sweetalert2.min.css">
    <title>Upload Test</title>
</head>

<body class="d-flex justify-content-center">

    <div class="container-fluid p-5">
        <div class="row mb-5">
            <div class="container d-flex justify-content-center">
                <div class="col-3 me-2">
                    <input type="text" class="form-control " placeholder="Number of questions" id="number" name="number">
                </div>

                <div class="col-6 d-flex">
                    <!-- <input type="text" name="subject" id="subject" class="form-control me-2" placeholder="Subject" required> -->
                    <select name="subject" id="subject" class="form-control me-2">
                        <option value="HTML" name="HTML">HTML</option>
                        <option value="CSS" name="CSS">CSS</option>
                        <option value="JavaScript" name="JavaScript">JavaScript</option>
                        <option value="Bootstrap" name="Bootstrap">Bootstrap</option>
                        <option value="Python" name="Python">Python</option>
                    </select>
                    <select name="diff" id="diff" class="form-control">
                        <option value="Easy" name="Easy">Easy</option>
                        <option value="Medium" name="Medium">Medium</option>
                        <option value="Hard" name="Hard">Hard</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="container d-flex justify-content-center">
                <form action="" method="post" id="form" class="col-6">
                    <div class="form-group container" id="questions">
                        <!-- <div class="container col-2"> -->
                        <!-- </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/static/sweetalert2.js"></script>
    <script src="./script.js"></script>
</body>

</html>