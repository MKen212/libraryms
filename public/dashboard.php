<?php
session_start();
require "../app/helpers/helperFunctions.php";

// Reject User that is not logged in
if (!isset($_SESSION["userLogin"])) {
  $_SESSION["message"] = msgPrep("warning", "Sorry - You need to Login with a Valid User Account to proceed.");
  ob_start();
  header("location:index.php?p=logout");
  ob_end_flush();
  exit();
}

require "../app/config/_config.php";

// Get Page Details
$page = "home";
if (isset($_GET["p"])) {
  $page = cleanInput($_GET["p"], "string");
}

// Check Valid Page is entered
if (!in_array($page, VALID_PAGES["dashboard"]) && !in_array($page, VALID_PAGES["dashboard_admin"])) {
  $_SESSION["message"] = msgPrep("danger", "Error - Page Not Found.");
  $page = "home";
}

// Check User IsAdmin to view admin pages
if ($_SESSION["userIsAdmin"] == 0 && in_array($page, VALID_PAGES["dashboard_admin"])) {
  $_SESSION["message"] = msgPrep("warning", "Sorry - You need Admin Privileges to view the '{$page}' page.");
  $page = "home";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="description" content="Library Management System" />
  <meta name="author" content="Malarena SA" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Library MS - <?= ucfirst($page) ?></title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="css/dashboard.css">

  <link rel="shortcut icon" href="images/favicon-96x96.png" type="image/x-icon" />

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" integrity="sha384-EbSscX4STvYAC/DxHse8z5gEDaNiKAIGW+EpfzYTfQrgIlHywXXrM9SUIZ0BlyfF" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input@1.3.4/dist/bs-custom-file-input.min.js" integrity="sha256-e0DUqNhsFAzOlhrWXnMOQwRoqrCRlofpWgyhnrIIaPo=" crossorigin="anonymous"></script>
</head>

<body>
  <!-- Top -->
  <?php include "../app/views/dashboard/navbar.php"; ?>
  <div class=container-fluid>
    <div class="row">
      <!-- Side -->
      <?php include "../app/controllers/dashboard/sidebar.php"; ?>
      <!-- Main -->
      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <?php include "../app/controllers/dashboard/{$page}.php"; ?>
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