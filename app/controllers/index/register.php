<?php  // INDEX - Register New User
include_once "../app/models/userClass.php";
$user = new User();
include_once "../app/models/messageClass.php";
$message = new Message();

// Register New User if ReigisterForm POSTed
if (isset($_POST["register"])) {
  $username = cleanInput($_POST["username"], "string");
  $password = cleanInput($_POST["password"], "password");
  $firstName = cleanInput($_POST["firstName"], "string");
  $lastName = cleanInput($_POST["lastName"], "string");
  $email = cleanInput($_POST["email"], "email");
  $contactNo = cleanInput($_POST["contactNo"], "string");

  // Create Database Entry
  $newUserID = $user->register($username, $password, $firstName, $lastName, $email, $contactNo);
  unset($password, $_POST["password"]);

  if ($newUserID) {  // Database Entry Success
    $_POST = [];
    // Send Admin message
    $notify = $message->add($newUserID, DEFAULTS["userAdminUserID"], "New User", "Please process my New User registration.");
  } 
}

// Initialise Registration Form
$newUserRecord = [
  "Username" => postValue("username"),
  "FirstName" => postValue("firstName"),
  "LastName" => postValue("lastName"),
  "Email" => postValue("email"),
  "ContactNo" => postValue("contactNo"),
];

// Show Register View/Form
include "../app/views/index/registerForm.php";
?>