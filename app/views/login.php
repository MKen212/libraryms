<?php
session_start();
include("../config/_config.php");
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

  <script src="../controllers/loginCheck.js"></script>
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
            <span class="input-group-text form-labels">User Name:</span>
          </div>
          <input class="form-control" type="text" name="lmsUsername" placeholder="User Name" required autofocus />
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
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" onclick="return(loginCheck());">Sign in</button>
        <!-- Lost Password / New Account Links -->
        <a class="mr-3" href="#">Lost password?</a>
        <a class="ml-3" href="../views/registration.php">Create new account</a>  
      </form>
    </div>
    <!-- Result -->
    <div class="row justify-content-center">
      <?php include("../controllers/loginUser.php");?>
    </div>
  </div>

</body>
</html>