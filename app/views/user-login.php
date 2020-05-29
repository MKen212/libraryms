<?php
session_start();
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
  <title>Library MS - User Login</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/extra.css" />

</head>

<body class="text-center">
  <!-- Login Page -->
  <div class="container-fluid">
    <!-- Header -->
    <div class="row justify-content-center">
      <h1>Library Management System</h1>
    </div>
    <!-- Login Form -->
    <div class="row">
      <form class="form-user" action="" method="POST" name="loginForm">
        <h3 class="mb-3">Please sign in</h3>
        <!-- User Name -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Username:</span>
          </div>
          <input class="form-control" type="text" name="lmsUsername" placeholder="Username" required autofocus />
        </div>
        <!-- Password -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Password:</span>
          </div>
          <input class="form-control" type="password" name="lmsPassword"  placeholder="Password" required />
        </div>
        <br />
        <!-- Submit Button -->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" >Sign in</button><!-- Removed onclick="return(loginCheck());" as browser can do validation-->
        <!-- New Account Links -->
        <a href="../views/user-registration.php">Create new account</a>
      </form>
    </div>
    <!-- Result -->
    <div class="row justify-content-center">
      <?php include("../controllers/loginUser.php");?>
    </div>
  </div>

</body>
</html>