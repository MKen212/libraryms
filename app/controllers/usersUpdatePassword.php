<?php  // Update Users Password
include_once("../models/userClass.php");
$user = new User();

// Update record
if (isset($_POST["updatePassword"])) {
  $userID = $_SESSION["userID"];
  $existingPW = htmlspecialchars($_POST["lmsPassword"]);
  $newPW = htmlspecialchars($_POST["lmsNewPassword"]);
  $repeatPW = htmlspecialchars($_POST["lmsRepeatPassword"]);
  $_POST = [];

  if ($newPW !== $repeatPW) {
    // New Password entries do not match
    echo "<div class='alert alert-danger form-user'>
      Error - New Password & Repeat Password do not match.
    </div>";
    return;
  }
  $update = $user->updatePassword($userID, $existingPW, $newPW);
  if ($update) {
    // Update Success
    echo "<div class='alert alert-success form-user'>" . $_SESSION["message"] . "</div>";
  } else {
    // Update Failure
    echo "<div class='alert alert-danger form-user'>" . $_SESSION["message"] . "</div>";
  }
  $_SESSION["message"] = null;
}
?>