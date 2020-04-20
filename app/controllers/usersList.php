<?php  // List all Users
include_once("../models/userClass.php");
$user = new User();

// Extend the RecursiveIteratorIterator with table tags
class TableRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "UserID") {
      // For UserID save the current value to $_SESSION
      $_SESSION["curUserID"] = $parentValue;
    }
    if ($parentKey == "IsAdmin") {
      // For IsAdmin output Yes/No
      if ($parentValue == 1) {
        $returnValue = "<a class='badge badge-primary' href=''>Yes</a>";
      } else {
        $returnValue = "<a class='badge badge-secondary' href=''>No</a>";
      }
    } else if ($parentKey == "UserStatus") {
      // For UserStatus output Approved/Unapproved + Change Link
      if ($parentValue == 1) {
        $returnValue = "<a class='badge badge-success' href='../controllers/usersUpdateStatus.php?updateID=" . $_SESSION["curUserID"] . "&newStatus=0'>Approved</a>";
      } else {
        $returnValue = "<a class='badge badge-danger' href='../controllers/usersUpdateStatus.php?updateID=" . $_SESSION["curUserID"] . "&newStatus=1'>Unapproved</a>";
      }
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>" . $returnValue . "</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
    unset ($_SESSION["curUserID"]);
  }
}

// Loop through the Users and output the values
foreach(new TableRows(new RecursiveArrayIterator($user->getUsers())) as $value) {
  echo $value;
}
?>