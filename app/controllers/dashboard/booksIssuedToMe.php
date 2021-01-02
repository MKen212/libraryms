<?php  // DASHBOARD - List all Issued Books for Logged-in User
include_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();

// Extend the RecursiveIteratorIterator with table tags
class BooksIssuedToMeRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate" || $parentKey == "ReturnActualDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "RecordStatus") {
      //Skip RecordStatus
      return;
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
  }
}

// Get List of ACTIVE books_issued for current user
$userID = $_SESSION["userID"];
$booksIssuedToMe = $bookIssued->getListByUser($userID, 1, false);

// Display Books Issued To Me View
include "../app/views/dashboard/booksIssuedToMe.php";
?>