<?php  // Get Current User Details
if (isset($_POST["updateUser"])) {  // User has posted changes, so use those
  $curuser = [
    "UserID" => $_SESSION["userID"],
    "UserName" => $_POST["lmsUsername"],
    "FirstName" => $_POST["lmsFirstName"],
    "LastName" => $_POST["lmsLastName"],
    "Email" => $_POST["lmsEmail"],
    "ContactNo" => $_POST["lmsContactNo"],
  ];
} else {  // Get user record from database
  include_once("../models/userClass.php");
  $user = new User();

  $curuser = $user->getUserByID($_SESSION["userID"]);
}
?>