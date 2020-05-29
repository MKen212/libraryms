<?php
session_start();
if (!$_SESSION["userLogin"] == true) {
  $_SESSION["message"] = "Sorry - You need to Login with a Valid User Account to proceed.";
  header("location:../views/user-logout.php");
}
include_once("../config/_config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="decription" content="Library Management System" />
  <meta name="author" content="Malarena SA" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Library MS - My Messages</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" integrity="sha384-EbSscX4STvYAC/DxHse8z5gEDaNiKAIGW+EpfzYTfQrgIlHywXXrM9SUIZ0BlyfF" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js" integrity="sha256-e0DUqNhsFAzOlhrWXnMOQwRoqrCRlofpWgyhnrIIaPo=" crossorigin="anonymous"></script>
</head>

<body>
  <!-- Top -->
  <?php include("../views/main-navbar.php");?>
  <div class=container-fluid>
    <div class="row">
      <!-- Sidebar Menu -->
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <!-- Welcome -->
            <li class="nav-brand">
              <h6 class="ml-2">Welcome, <?php include("../controllers/welcomeUser.php")?></h6>
              <hr>
            </li>
            <!-- Home -->
            <li class="nav-item">
              <a class="nav-link" href="main-home.php"><span data-feather="home"></span>Home<span class="sr-only">(current)</span></a>
            </li>
            <!-- Display Books -->
            <li class="nav-item">
              <a class="nav-link" href="main-booksDisplay.php"><span data-feather="book"></span>Display Books</a>
            </li>
            <!-- Issued to Me -->
            <li class="nav-item">
              <a class="nav-link" href="main-booksIssuedToMe.php"><span data-feather="book-open"></span>My Issued Books</a>
            </li>
            <!-- Send a Message -->
            <li class="nav-item">
              <a class="nav-link" href="main-messagesSend.php"><span data-feather="send"></span>Send a Message</a>
              <hr />
            </li>
            <!-- My Profile -->
            <li class="nav-item">
              <a class="nav-link" href="main-usersProfile.php"><span data-feather="user"></span>My Profile</a>
              <hr />
            </li>
          </ul>
          <!-- Admin Section -->
          <?php if ($_SESSION["userIsAdmin"] == true) { ?>
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Admin Section</h6>
            <ul class="nav flex-column">
              <!-- Issue Books-->
              <li class="nav-item">
                <a class="nav-link" href="main-booksIssuedAdd.php"><span data-feather="arrow-up-circle"></span>
                Issue Books</a>
              </li>
              <!-- Return Books -->
              <li class="nav-item">
                <a class="nav-link" href="main-booksIssuedRtn.php"><span data-feather="arrow-down-circle"></span>
                Return Books</a>  
              </li>
              <!-- Add Books -->
              <li class="nav-item">
                <a class="nav-link" href="main-booksAdd.php"><span data-feather="plus-circle"></span>
                Add Books</a>
              </li>
              <!-- List/Edit Books -->
              <li class="nav-item">
                <a class="nav-link" href="main-booksList.php"><span data-feather="layers"></span>
                List/Edit Books</a>
              </li>
              <!-- List/Edit Users-->
              <li class="nav-item">
                <a class="nav-link" href="main-usersList.php"><span data-feather="users"></span>
                List/Edit Users</a>
              </li>
            </ul>
          <?php ;}?>
        </div>
      </nav>

      <!-- Main Section - Messages -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">My Messages</h1>
        </div>
        <!-- Received Messages -->
        <div class="table-responsive">
          <h3>Received:</h3>
          <table class="table table-striped table-sm">
            <thead>
              <!-- Received Messages Table Header -->
              <th style="width: 180px">Received</th>
              <th>Read / Unread</th>
              <th>Sender</th>
              <th>Subject</th>
              <th>Message</th>
              <th>Reply?</th>
            </thead>
            <tbody>
              <!-- List All Received Messages -->
              <?php include("../controllers/messagesListRcvd.php");?>
            </tbody>
          </table>
        </div>
        <hr />
        <!-- Sent Messages -->
        <div class="table-responsive">
          <h3>Sent:</h3>
          <table class="table table-striped table-sm">
            <thead>
              <!-- Messages Table Header -->
              <th style="width: 180px">Sent</th>
              <th>Receiver</th>
              <th>Subject</th>
              <th>Message</th>
            </thead>
            <tbody>
              <!-- List All Sent Messages -->
              <?php include("../controllers/messagesListSent.php");?>
            </tbody>
          </table>
        </div>
      </main>

    </div>
  </div>
  
  <!--Update Feather Icons & Initialise Bootstrap CustomFileInput -->
  <script>
    feather.replace();
    bsCustomFileInput.init();
  </script>

</body>
</html>