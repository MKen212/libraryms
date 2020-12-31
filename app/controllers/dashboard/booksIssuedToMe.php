<?php  


// STARTING THIS...



// List all Issued Books for Logged-in User
include_once("../models/bookIssuedClass.php");
$bookIssued = new BookIssued();

// Extend the RecursiveIteratorIterator with table tags
class BooksIssuedListRows extends RecursiveIteratorIterator {
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

// Loop through ALL Issued Books for user and output the values
$_SESSION["rowCount"] = 0;
foreach (new BooksIssuedListRows(new RecursiveArrayIterator($bookIssued->getBooksIssuedByUserID($_SESSION["userID"]))) as $value) {
  echo $value;
}
?>