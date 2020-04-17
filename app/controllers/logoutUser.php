<?php  // Logout User
include_once("../models/userClass.php");
$user = new User();

if (isset($_GET["q"])) {
  $user->logout();
  unset($_GET);
  header("location:../views/logout.php");
  }
?>