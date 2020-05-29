<?php  // Update Users Record
include_once("../models/userClass.php");
$user = new User();

// Update record
if (isset($_POST["updateUser"])) {
  $userID = $_SESSION["userID"];
  $username = htmlspecialchars($_POST["lmsUsername"]);
  $firstName = htmlspecialchars($_POST["lmsFirstName"]);
  $lastName = htmlspecialchars($_POST["lmsLastName"]);
  $email = htmlspecialchars($_POST["lmsEmail"]);
  $contactNo = htmlspecialchars($_POST["lmsContactNo"]);
  $_POST = [];
  
  $update = $user->updateRecord($userID, $firstName, $lastName, $email, $contactNo);
  if ($update) {
    // Update Success
    echo "<div class='alert alert-success form-user'>
        Update of User Profile was successful.
      </div>";
  } else {
    // Update Failure
    echo "<div class='alert alert-danger form-user'>
      Sorry - Update of User Profile failed.
    </div>";
  }
}
?>