<?php  // Login User
include_once("../models/userClass.php");
$user = new User();

if (isset($_POST["login"])){
  $username = htmlspecialchars($_POST["lmsUsername"]);
  $password = htmlspecialchars($_POST["lmsPassword"]);
  $login = $user->login($username, $password);
  unset($_POST, $password);
  if ($login) {
    // Login Success
    header("location:../views/main.php");
  } else {
    // Login Failure
    header("location:../views/user-logout.php");
  }
}
?>