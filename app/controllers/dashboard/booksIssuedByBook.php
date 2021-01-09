<?php  // DASHBOARD - List all Outstanding Issued Books for Particular Book
include_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
include_once "../app/models/bookClass.php";
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class BooksIssuedByBookRow extends RecursiveIteratorIterator {
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
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }
  public function beginIteration() {
    $_SESSION["countIssued"] = 0;
  }
  public function beginChildren() {
    $_SESSION["countIssued"] += 1;
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
  }
  public function endIteration() {
    echo "<tr class='table-info'><td colspan='3'><b>Total currently issued: {$_SESSION["countIssued"]}</b></td></tr>";
    unset($_SESSION["countIssued"]);
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

// Get List of ACTIVE & OUTSTANDING books_issued for BookID
$booksIssuedByBook = $bookIssued->getListByBook($bookID, 1, true);

// Display Books Issued By Book View
include "../app/views/dashboard/booksIssuedByBook.php";
?>