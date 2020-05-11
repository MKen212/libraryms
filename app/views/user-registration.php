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
  <title>Library MS - User Registration</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/extra.css" />

</head>

<body class="text-center">
  <!-- Registration Page -->
  <div class="container-fluid">
    <!-- Header-->
    <div class="row justify-content-center">
      <h1>Library Management System</h1>
    </div>
    <!-- Registration Form -->
    <div class="row justify-content-center">
      <form class="form-user" action="" method="POST" name="registrationForm">
        <h3 class="mb-3">User Registration Form</h3>
        <!-- User Name -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">User Name:</span>
          </div>
          <input class="form-control" type="text" name="lmsUsername" placeholder="Enter User Name" required autofocus />
        </div>
        <!-- Password -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Password:</span>
          </div>
          <input class="form-control" type="password" name="lmsPassword" minlength="5" placeholder="Enter Password" required />
        </div>
        <!-- First Name -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">First Name:</span>
          </div>
          <input class="form-control" type="text" name="lmsFirstName" placeholder="Enter First Name" required />
        </div>
        <!-- Last Name -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Last Name:</span>
          </div>
          <input class="form-control" type="text" name="lmsLastName" placeholder="Enter Last Name" required />
        </div>
        <!-- Email -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Email:</span>
          </div>
          <input class="form-control" type="email" name="lmsEmail" placeholder="Enter Email Address" required />
        </div>
        <!-- Contact Number -->
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text form-labels">Contact No:</span>
          </div>
          <input class="form-control" type="tel" name="lmsContactNo" placeholder="Enter Contact Telephone Number" required />
        </div>
        <br />
        <!-- Submit Button -->
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="register">Register</button> <!-- Removed onclick="return(registerCheck());" as browser can do validation -->
        <!-- Back to Login Link -->
        <a href="../views/user-login.php">Back to Login</a>
        <br />
      </form>
    </div>
    <!-- Result -->
    <div class="row justify-content-center">
      <?php include("../controllers/registerUser.php");?>
    </div>
  </div>

</body>
</html>