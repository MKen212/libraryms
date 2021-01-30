<?php
/**
 * DASHBOARD/listEditUsers controller - List all Users with link to
 * Display/Edit
 */

require_once "../app/models/userClass.php";
$user = new User();

// Get recordID if provided and process Status changes if hyperlinks clicked
$userID = 0;
if (isset($_GET["id"])) {
  $userID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updIsAdmin"])) {  // IsAdmin link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("IsAdmin", $curStatus);
    // Update User IsAdmin
    $updateStatus = $user->updateStatus("IsAdmin", $userID, $newStatus);
  } elseif (isset($_GET["updUserStatus"])) {  // UserStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("UserStatus", $curStatus);
    // Update User UserStatus
    $updateStatus = $user->updateStatus("UserStatus", $userID, $newStatus);
  } elseif (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update User RecordStatus
    $updateStatus = $user->updateStatus("RecordStatus", $userID, $newStatus);
  }
}
$_GET = [];

// Fix Username Search, if entered
$username = null;
if (isset($_POST["userSearch"])) $username = fixSearch($_POST["schUsername"]);

// Get List of users
$userList = $user->getList($username);

// Display Users List View
include "../app/views/dashboard/usersList.php";
