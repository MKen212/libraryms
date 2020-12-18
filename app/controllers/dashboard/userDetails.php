<?php  // DASHBOARD - Display/Edit User Record
// Check User is Admin
if ($_SESSION["userIsAdmin"] != 1) {
  $_SESSION["message"] = msgPrep("warning", "Sorry - You need Admin Privileges to view the '{$page}' page.");
  ob_start();
  header("location:dashboard.php?p=home");
  ob_end_flush();
  exit();
}

include_once "../app/models/userClass.php";
$user = new User();

// Get recordID if provided
$userID = 0;
if (isset($_GET["id"])) {
  $userID = cleanInput($_GET["id"], "int");
}
$_GET = [];

if (isset($_POST["updateUser"])) {  // Update User record if UpdateUser POSTed
  $username = cleanInput($_POST["username"], "string");
  $firstName = cleanInput($_POST["firstName"], "string");
  $lastName = cleanInput($_POST["lastName"], "string");
  $email = cleanInput($_POST["email"], "email");
  $contactNo = cleanInput($_POST["contactNo"], "string");
  // Update Database Entry for User Record
  $updateUser = $user->updateRecord($userID, $username, $firstName, $lastName, $email, $contactNo);
} elseif (isset($_POST["updatePassword"])) {  // Update Password if UpdatePassword POSTed
  $existingPassword = cleanInput($_POST["existingPassword"], "password");
  $newPassword = cleanInput($_POST["newPassword"], "password");
  // Update Database Entry for User Password
  $updatePassword = $user->updatePassword($userID, $existingPassword, $newPassword);
  unset($existingPassword, $newPassword, $repeatPassword);
}
$_POST = [];

// Get User Details for selected record
$userRecord = $user->getRecord($userID);

// Prep User Form Data
$formData = [
  "formUsage" => "Update",
  "formTitle" => "User Details - ID: {$userID}",
  "submitName" => "updateUser",
  "submitText" => "Update User",
];

// Show User Form
include "../app/views/dashboard/userForm.php";
?>