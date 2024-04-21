<?php
session_start();
if (!$_SESSION["loggedin"]) {
  header("Location: /login");
  exit;
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="../../imgs/temp_logo.png">
  <link rel="stylesheet" href="../../static/bootstrap.min.css">
  <link rel="stylesheet" href="feed.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback</title>
  <style>
    /* THIS PLACE IS NEEDED FOR THE THEME AND FONT CHANGES */
  </style>
</head>

<body>
  <div class="container mt-2">
    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">/ Feedback</li>
      </ol>
    </nav>
  </div>

  <div class="container mt-5 p-2">
    <div class="container col-md-6 shadow-lg mt-4 rounded-3 p-3">

      <!-- ################ FORM START ################ -->
      <form action="feedHandler.php" method="post">

        <div class="text-start p-2">
          <h1 class="text-primary">Write to us</h1>
        </div>

        <div class="container">
          <textarea name="feed" required class="form-control" id="" cols="30" rows="10"></textarea>
        </div>

        <div class="container">
          <div class="form-check d-flex width">
            <input class="form-check-input" type="checkbox" name="bug-report" value="checked" id="flexCheckChecked">
            <label class="form-check-label text-primary b-flex" id="checkbox" for="flexCheckChecked"> Bug report</label>
          </div>
        </div>

        <div class="container">
          <button type="button" class="btn btn-primary col-md-12 mt-2" id="modal-button">Rate us</button>

          <article id="modal-container">
            <section id="modal-section" style="height: 200px;">
              <span id="modal-close-button"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-circle text-light rounded-5 mt-1" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                </svg></span>
              <h5 id="modal-title" class="text-light p-1 text-center">Rate us</h5>
              <p id="modal-content text-center">

              <div class="text-center">

                <input type="hidden" name="star" id="starValue" value="">

                <!-- Stars are here -->
                <span class="btn btn-transparent text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="" class="bi bi-star-fill g-star" data-value="1" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </span>

                <span class="btn btn-transparent text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="" class="bi bi-star-fill g-star" data-value="2" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </span>

                <span class="btn btn-transparent text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="" class="bi bi-star-fill g-star" data-value="3" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </span>

                <span class="btn btn-transparent text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="" class="bi bi-star-fill g-star" data-value="4" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </span>

                <span class="btn btn-transparent text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="" class="bi bi-star-fill g-star" data-value="5" viewBox="0 0 16 16">
                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                  </svg>
                </span>

              </div>

              <div class="container text-center mt-1 mb-3">
                <input id="out-user" type="submit" name="submit" value="Submit" class="btn mb-1 btn-success  text-center col-md-12 shadow done">
              </div>
              </p>

            </section>
          </article>

        </div>
      </form>
      <!-- ################ FORM END ################ -->
    </div>
  </div>

  <script>
    if (localStorage.getItem("font-family")) document.querySelector("style").innerHTML = `*{font-family:"${localStorage.getItem("font-family")}";}`
  </script>
  <script src="../../static/bootstrap.bundle.min.js"></script>
  <script src="feed.js"></script>
  <script src="../../static/jquery-3.7.1.min.js"></script>
</body>

</html>