<?php  // Select User ID
include_once("../models/userClass.php");
$user = new User();

// Extend the RecursiveIteratorIterator with option tags
class UserIDRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "UserID") {
      echo "<option value='$parentValue'";
      if (isset($_POST["userIDSelected"])) {
        // If userIDSelected then make this the "selected" value in the option list
        if ($parentValue == $_POST["userIDSelected"]) echo " selected";
      } elseif (isset($_GET["r"])) {
        // If reply recipient then make this the "selected" value in the option list
        if ($parentValue == $_GET["r"]) echo " selected";
      }
      echo ">$parentValue > ";
    } elseif ($parentKey == "UserName") {
      echo "$parentValue</option>";
    }
  }
}

// Loop through the Users and output "UserID > UserName" for each
foreach (new UserIDRows(new RecursiveArrayIterator($user->getUserIDs())) as $value) {
  echo $value;
}
?>