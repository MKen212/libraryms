<?php  // Register New User
include_once("../models/userClass.php");
$user = new User();

if (isset($_POST["register"])) {
  $username = htmlspecialchars($_POST["lmsUsername"]);
  $password = htmlspecialchars($_POST["lmsPassword"]);
  $firstName = htmlspecialchars($_POST["lmsFirstName"]);
  $lastName = htmlspecialchars($_POST["lmsLastName"]);
  $email = htmlspecialchars($_POST["lmsEmail"]);
  $contactNo = htmlspecialchars($_POST["lmsContactNo"]);
  $isAdmin = 0;

  $register = $user->registerUser($username, $password, $firstName, $lastName, $email, $contactNo, $isAdmin);
  unset($_POST, $password);
  if ($register) {
    // Registration Success
    echo "<div class='alert alert-success form-user'>" .
    "Registration of '$username' was successful.<br />" .
    "They will receive an email once their account is approved." .
    "</div>";
  } else {
    // Registration Failure
    echo "<div class='alert alert-danger form-user'>" .
    "Sorry - Registration of '$username' failed." .
    "</div>";
  }
}
?>
