<?php  // DASHBOARD - List all Outstanding Issued Books for Particular Book
include_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
include_once "../app/models/bookClass.php";
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class BooksIssuedListRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "BookID" || $parentKey == "Title" || $parentKey == "ReturnActualDate" || $parentKey == "RecordStatus") {
      // Skip ouput for BookID, Title, ReturnActualDate and RecordStatus
      return;
    } elseif (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
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

// Get recordID & bookRecord if provided
$bookID = 0;
$bookRecord = [];
if (isset($_GET["id"])) {
  $bookID = cleanInput($_GET["id"], "int");
  $bookRecord = $book->getRecord($bookID);
}
$_GET = [];

// Get List of outstanding books_issued for BookID
$booksIssuedList = $bookIssued->getList(null, $bookID, true);

// Prep Book List Data
$listData = [
  "listTitle" => "Currently Issued for Book ID: {$bookID}",
];

// Display Books Issued List View
include "../app/views/dashboard/booksIssuedList.php";
?>