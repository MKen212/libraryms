<?php
session_start();
require "../app/helpers/helperFunctions.php";
require "../app/config/_config.php";

// Get Page Details
$page = "login";
if (isset($_GET["p"])) {
  $page = cleanInput($_GET["p"], "string");
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

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/extra.css" />
</head>

<body class="text-center">
  <div class="container-fluid">
    <!-- Header -->
    <div class="row justify-content-center">
      <h1>Library Management System</h1>
    </div>
    <?php include "../app/controllers/index/{$page}.php"; ?>
  </div>
</body>
</html>