<?php
/**
 * UserRow Class - Used to extend the RecursiveIteratorIterator to display each row
 * of a User/getList query in table format
 */
class UserRow extends RecursiveIteratorIterator {
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
      // For Username output value with edit hyperlink
      $href = "dashboard.php?p=userDetails&id="
            . $_SESSION["curUserID"];
      $returnValue = "<a href={$href}>{$parentValue}</a>";
    } elseif ($parentKey == "IsAdmin") {
      // For IsAdmin output with value update hyperlink
      $href = "dashboard.php?p=usersList&id="
            . $_SESSION["curUserID"]
            . "&cur="
            . $parentValue
            . "&updIsAdmin";
      $returnValue = statusOutput("IsAdmin", $parentValue, $href);
    } elseif ($parentKey == "UserStatus") {
      // For UserStatus output value with update hyperlink
      $href = "dashboard.php?p=usersList&id="
            . $_SESSION["curUserID"]
            . "&cur="
            . $parentValue
            . "&updUserStatus";
      $returnValue = statusOutput("UserStatus", $parentValue, $href);
    } elseif ($parentKey == "RecordStatus") {
      // For RecordStatus output value with update hyperlink
      $href = "dashboard.php?p=usersList&id="
            . $_SESSION["curUserID"]
            . "&cur="
            . $parentValue
            . "&updRecordStatus";
      $returnValue = statusOutput("RecordStatus", $parentValue, $href);
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
