<?php
/**
 * INDEX/login controller - Verify & Login User
 */

namespace LibraryMS;

require_once "../app/models/userClass.php";
$user = new User();

// Verify & Login User if Login Form POSTed
if (isset($_POST["login"])){
  $username = cleanInput($_POST["lmsUsername"], "string");
  $password = cleanInput($_POST["lmsPassword"], "password");
  $_POST = [];

  // Check database entry for user & update session variables
  $login = $user->login($username, $password);
  unset($password);
  if ($login) {  // Login Success
    header("location:dashboard.php?p=home");
  }
}

// Show Login View/Form
include "../app/views/index/loginForm.php";
