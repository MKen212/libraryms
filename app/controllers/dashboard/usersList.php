<?php  // DASHBOARD - List all Users
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

// Extend the RecursiveIteratorIterator with table tags
class UserListRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "UserID") {
      // For UserID save the current value to $_SESSION & skip output
      $_SESSION["curUserID"] = $parentValue;
      return;
    } elseif ($parentKey == "Username") {
      // For Username output edit hyperlink
      $returnValue = "<a href='dashboard.php?p=userDetails&id={$_SESSION["curUserID"]}'>{$parentValue}</a>";
    } elseif ($parentKey == "IsAdmin") {
      // For Status Codes output texts with update hyperlinks
      $returnValue = statusOutput("IsAdmin", $parentValue, "dashboard.php?p=usersList&id={$_SESSION["curUserID"]}&cur={$parentValue}&updIsAdmin");
    } else if ($parentKey == "UserStatus") {
      $returnValue = statusOutput("UserStatus", $parentValue, "dashboard.php?p=usersList&id={$_SESSION["curUserID"]}&cur={$parentValue}&updUserStatus");
    } else if ($parentKey == "RecordStatus") {
      $returnValue = statusOutput("RecordStatus", $parentValue, "dashboard.php?p=usersList&id={$_SESSION["curUserID"]}&cur={$parentValue}&updRecordStatus");
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
    unset ($_SESSION["curUserID"]);
  }
}

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
?>