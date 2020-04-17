<?php  // Update UserStatus
include("../config/_config.php");
include_once("../models/userClass.php");
$user = new User();

if (isset($_GET["updateID"])) {
  $userID = $_GET["updateID"];
  $newStatus = $_GET["newStatus"];
  $update = $user->updateStatus($userID, $newStatus);
  unset($_GET);
  if ($update) {
    // Update Success
    header("location:../views/main.php");
  } else {
    // Update Failure
    print_r($update);
  }
}
?>