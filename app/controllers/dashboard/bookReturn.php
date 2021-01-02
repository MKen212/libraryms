<?php  // DASHBOARD - Return Issued Book
include_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
include_once "../app/models/bookClass.php";
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class BooksReturnListRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "IssuedID") {
      // For IssuedID save the current value to $_SESSION
      $_SESSION["curIssuedID"] = $parentValue;
    }
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION
      $_SESSION["curBookID"] = $parentValue;
    }
    if (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "ReturnActualDate") {
      if (empty($parentValue)){
        // For ReturnActualDate (which is Null) provide return hyperlink
        $returnValue = "<a class='badge badge-primary' href='dashboard.php?p=bookReturn&id=" . $_SESSION["curIssuedID"] . "&bookID=" . $_SESSION["curBookID"] . "&updReturn'>Return</a>";
      } else {
        $returnValue = date("d/m/Y", strtotime($parentValue));
      }
    } else if ($parentKey == "RecordStatus") {
      $returnValue = statusOutput("RecordStatus", $parentValue, "dashboard.php?p=bookReturn&id={$_SESSION["curIssuedID"]}&cur={$parentValue}&updRecordStatus");
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
    unset ($_SESSION["curIssuedID"], $_SESSION["curBookID"]);
  }
}

// Get userID / issuedUD if provided and process Status changes if hyperlinks clicked
$userID = 0;
$issuedID = 0;
if (isset($_GET["selectUser"])) {

  // TO HERE - CHANGING POST TO GET//
  
  $userID = cleanInput($_GET["userIDSelected"], "int");
} elseif (isset($_GET["id"])) {
  $issuedID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update books_issued RecordStatus
    $updateStatus = $bookIssued->updateRecordStatus($issuedID, $newStatus);
  } elseif (isset($_GET["updReturn"])) {  // Return link was clicked
    $bookID = cleanInput($_GET["bookID"], "int");
    $returnedDate = date("Y-m-d");  // Set returned date to today
    $returnBook = $bookIssued->returnBook($issuedID, $returnedDate);
    // If Return Processed then update books table
    if ($returnBook != 1) {
      msgPrep("warning", "Sorry - Return not processed correctly.");
    } else {
      $updateBooks = $book->updateBookQtyAvail($bookID, +1);
    }
  }
}
$_GET = [];

// Get List of books_issued for selected user
if (!empty($userID)) {
  $booksIssuedByUserList = $bookIssued->getListByUser($userID, null, false);
}

// Show BookReturn Form
include "../app/views/dashboard/bookReturnForm.php";
?>