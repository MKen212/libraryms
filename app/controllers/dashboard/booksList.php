<?php  // DASHBOARD - List all Books (No Image)
include_once "../app/models/bookClass.php";
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class BookListRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION & skip output
      $_SESSION["curBookID"] = $parentValue;
      return;
    } elseif ($parentKey == "Title") {
      // For Title output edit hyperlink
      $returnValue = "<a href='dashboard.php?p=bookDetails&id={$_SESSION["curBookID"]}'>{$parentValue}</a>";
    } elseif ($parentKey == "AddedTimestamp") {
      // For Date/Time Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "RecordStatus") {
      // For Status Codes output texts with update hyperlinks
      $returnValue = statusOutput("RecordStatus", $parentValue, "dashboard.php?p=booksList&id={$_SESSION["curBookID"]}&cur={$parentValue}&updRecordStatus");
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
    unset ($_SESSION["curBookID"]);
  }
}

// Get recordID if provided and process Status changes if hyperlinks clicked
$bookID = 0;
if (isset($_GET["id"])) {
  $bookID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update Book RecordStatus
    $updateStatus = $book->updateRecordStatus($bookID, $newStatus);
  }
}
$_GET = [];

// Fix Book Title Search, if entered
$title = null;
if (isset($_POST["bookSearch"])) $title = fixSearch($_POST["schTitle"]);
$_POST = [];

// Get List of books
$bookList = $book->getList($title);

// Display Books List View
include "../app/views/dashboard/booksList.php";
?>