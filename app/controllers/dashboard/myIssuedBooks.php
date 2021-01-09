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
    if (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "ReturnActualDate") {
      if (empty($parentValue)){
        $returnValue = $parentValue;
        $_SESSION["countOutstanding"] += 1;
      } else {
        $returnValue = date("d/m/Y", strtotime($parentValue));
      }
    } elseif ($parentKey == "RecordStatus") {
      //Skip RecordStatus
      return;
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }
  public function beginIteration() {
    $_SESSION["countIssued"] = 0;
    $_SESSION["countOutstanding"] = 0;
  }
  public function beginChildren() {
    $_SESSION["countIssued"] += 1;
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
  }
  public function endIteration() {
    echo "<tr class='table-info'><td colspan='5'><b>Total issued to me: {$_SESSION["countIssued"]} / Outstanding: {$_SESSION["countOutstanding"]}</b></td></tr>";
    unset($_SESSION["countIssued"], $_SESSION["countOutstanding"]);
  }
}

// Get List of ACTIVE books_issued for current user
$userID = $_SESSION["userID"];
$booksIssuedToMe = $bookIssued->getListByUser($userID, 1, false);

// Display My Issued Books View
include "../app/views/dashboard/myIssuedBooks.php";
?>