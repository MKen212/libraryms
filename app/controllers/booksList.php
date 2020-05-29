<?php  // List all Books in column format without image
include_once("../models/bookClass.php");
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class BookListRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION
      $_SESSION["curBookID"] = $parentValue;
    }
    if ($parentKey == "ImgFilename") {
      // For ImgFileName skip output
      return;
    } else if ($parentKey == "AddedDate") {
      // For Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } else if ($parentKey == "BookStatus") {
      if ($parentValue == 0) {
        $returnValue = "<a class='badge badge-danger' href='../controllers/booksUpdateStatus.php?updateID=" . $_SESSION["curBookID"] . "&newStatus=1'>Deleted</a>";
      } else {
        $returnValue = "<a class='badge badge-success' href='../controllers/booksUpdateStatus.php?updateID=" . $_SESSION["curBookID"] . "&newStatus=0'>Active</a>";
      }
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>" . $returnValue . "</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
    unset ($_SESSION["curBookID"]);
  }
}

if (isset($_POST["bookSearch"])) {
  $schString = trim($_POST["schTitle"]);
  $schString = str_replace("?", "_", $schString);  // Fix MariaDB one char wildcard
  $schString = str_replace("*", "%", $schString);  // Fix MariaDB multi char wildcard
  foreach (new BookListRows(new RecursiveArrayIterator($book->getBooksByTitle($schString))) as $value) {
    echo $value;
  }
  unset($_POST);
} else {
  // Loop through ALL Books and output the values
  foreach (new BookListRows(new RecursiveArrayIterator($book->getBooksAll())) as $value) {
    echo $value;
  }
}
?>