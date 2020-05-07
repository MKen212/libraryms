<?php  // List all Outstanding Issued Books for Particular Book
include_once("../models/bookIssuedClass.php");
$bookIssued = new BookIssued();

// Extend the RecursiveIteratorIterator with table tags
class BooksIssuedListByBookRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate" || $parentKey == "ReturnedDate") && (!is_null($parentValue))) {
      // For Non-Null Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>" . $returnValue . "</td>";
  }
  public function beginChildren() {
    echo "<tr>";
    $_SESSION["rowCount"] += 1;
  }
  public function endChildren() {
    echo "</tr>";
  }
}

if (isset($_GET["bookID"])) {
  // Loop through ALL Outstanding Books for bookID and output the values
  $_SESSION["rowCount"] = 0;
  foreach (new BooksIssuedListByBookRows(new RecursiveArrayIterator($bookIssued->getBooksOSByBookID($_GET["bookID"]))) as $value) {
    echo $value;
  }
  unset($_GET);
}
?>