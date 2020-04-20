<?php  // List all Books
include_once("../models/bookClass.php");
$book = new Book();

// Extend the RecursiveIteratorIterator with table tags
class TableRows extends RecursiveIteratorIterator {
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
      // For ImgFileName output img with URL
      $fullPath = DEFAULTS["booksImgPath"] . $_SESSION["curBookID"] . "/" . $parentValue;
      $returnValue = "<img class='img-thumbnail' style='width:140px; height:220px' src='$fullPath' alt='$parentValue' />";
    } else if ($parentKey == "DateAdded") {
      // For DateAdded modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
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

// UP TO HERE - NEED METHOD OF CHANGING ? & * to _ & %

  $schString = trim($_POST["schTitle"]);
  foreach(new TableRows(new RecursiveArrayIterator($book->getBooksByTitle($schString))) as $value) {
    echo $value;
  }
  unset($_POST);
} else {
  // Loop through ALL Books and output the values
  foreach(new TableRows(new RecursiveArrayIterator($book->getBooksAll())) as $value) {
    echo $value;
  }
}
?>