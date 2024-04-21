<?php
require("../scripts/admin_check.php");
require("../scripts/dashboard_setup.php");
require("../scripts/validation.php");

$statementFeedback = $con->query("select * from feedbacks");
$statementFeedback->setFetchMode(PDO::FETCH_ASSOC);
$feedbackUserInformation = $statementFeedback->fetchAll();

function giveInformationAboutUser($information)
{
  // This works for only this file.
  global $con;
  $userInformation = $con->prepare("SELECT email, full_name FROM users where id=?");
  $userInformation->execute([$information["user_id"]]);
  $userInformation->setFetchMode(PDO::FETCH_ASSOC);
  return $userInformation->fetchAll();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/static/bootstrap.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedbacks</title>
</head>

<body class="bg-light">
  <div class="container">
    <nav style="--bs-breadcrumb-divider: '/'; " aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../" style="text-decoration: none;">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Feedbacks</li>
      </ol>
    </nav>
    <form action="" class="mb-1" style="float: right;">
      <input type="text" style="border: none; height: 30px;" placeholder="Search user(full name)" class="mt-2 me-2" id="searchInput">
      <button class="btn btn-dark me-2"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
          <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
        </svg></button>
    </form>
    <table class="table table-hover table-bordered table-striped shadow">
      <thead class="thead-dark">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Bug</th>
          <th scope="col">Rating</th>
          <th scope="col">Feedback</th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($feedbackUserInformation as $userInformation) {
          $userData = giveInformationAboutUser($userInformation);
          $fullName = $userData[0]["full_name"];
          $userEmail = $userData[0]["email"];
          $bugs = $userInformation['bug'] ? "Reported" : "";
          $rating = $userInformation['rating'];
          $feedback = $userInformation["feedback_body"];
          $timestamp = $userInformation["feedback_time"];
          echo "<tr>
            <td class='inputData'>$fullName</td>
            <td>$userEmail</td>
            <td>$bugs</td>
            <td>$rating</td>
            <td>$userEmail</td>
            <td><button id='openModalBtn' class='btn btn-dark g-open' data-toggle='modal' data-target='#myModal'>Read Feedback</button>
              <div id='myModal' class='modal g-modal'>
                <div class='modal-dialog'>
                  <div class='modal-content'>
                    <div class='modal-header'>
                      <h5 class='modal-title'>Feedback</h5>
                      <button type='button' class='close btn-danger btn g-close' data-dismiss='modal'><svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-x-circle' viewBox='0 0 16 16'>
                          <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                          <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>
                        </svg></button>
                    </div>
                    <div class='modal-body'>
                      <p>$timestamp</p>
                      <p>$feedback</p>
                    </div>
                  </div>
                </div>
              </div></td>
          </tr>
          ";
        }
        ?>

      </tbody>
    </table>
    <script src="feed.js"></script>
    <script src="/static/bootstrap.bundle.min.js"></script>
</body>

</html>