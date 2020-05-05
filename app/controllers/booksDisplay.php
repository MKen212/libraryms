<?php  // Display all Books in card format
include_once("../models/bookClass.php");
$book = new Book();

// Extend the RecursiveIteratorIterator with div tags
class BookDisplayRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION
      $_SESSION["curBookID"] = $parentValue;
      return;
    } else if ($parentKey == "ImgFilename") {
      if (is_null($parentValue) || ($parentValue == "")) {  // No Image Uploaded - Use Default
        $fullPath = DEFAULTS["noImgUploaded"];
      } else {
        $fullPath = DEFAULTS["booksImgPath"] . $_SESSION["curBookID"] . "/" . $parentValue;
      }
      $returnContent = "<img class='img-thumbnail float-left mt-3 mb-3 mr-3' style='width:140px; height:220px' src='$fullPath' alt='$parentValue' />" . 
        "<div class='mt-3'>" .
        "<b>Book ID: </b>" . $_SESSION["curBookID"]. "<br />";
    } else if ($parentKey == "PriceGBP") {
      $returnContent = "<b>Price (GBP): </b>$parentValue<br />";
    } else if ($parentKey == "QtyTotal") {
      $returnContent = "<b>Total Qty: </b>$parentValue - ";
    } else if ($parentKey == "QtyAvail") {
        $parentValue <= 0 ?
          $returnClass="text-danger" : $returnClass="text-success";
        $returnContent = "<b>Available: <span class=$returnClass>$parentValue</span></b><br />";
    } else if ($parentKey == "AddedDate") {
      $returnContent = "<b>Date added: </b>" . date("d/m/Y", strtotime($parentValue)) ." ";
    } else if ($parentKey == "UserID") {
      $returnContent = "<b>by User: </b>$parentValue<br />" .
        "</div>";
    } else {
      $returnContent = "<b>$parentKey: </b>$parentValue<br />";
    }
    return $returnContent;
  }
  public function beginChildren() {
    $_SESSION["curColumn"] += 1;
    if ($_SESSION["curColumn"] == 1) echo "<div class='row'>";  // Create New Row div
    echo "<div class='col border rounded'>"; // Create Col div
  }
  public function endChildren() {
    echo "</div>";  // Close Col div
    unset ($_SESSION["curBookID"]);
    if ($_SESSION["curColumn"] == DEFAULTS["booksDisplayCols"]) {
      echo "</div>";  // If Default Cols reached close row div
      $_SESSION["curColumn"] = 0;
    }
  }
}

$_SESSION["curColumn"] = 0;

if (isset($_POST["bookSearch"])) {
  $schString = trim($_POST["schTitle"]);
  $schString = str_replace("?", "_", $schString);  // Fix MariaDB one char wildcard
  $schString = str_replace("*", "%", $schString);  // Fix MariaDB multi char wildcard
  foreach(new BookDisplayRows(new RecursiveArrayIterator($book->getBooksByTitle($schString))) as $value) {
    echo $value;
  }
  unset($_POST);
} else {
  // Loop through ALL Books and output the values
  foreach(new BookDisplayRows(new RecursiveArrayIterator($book->getBooksAll())) as $value) {
    echo $value;
  }
}

if ($_SESSION["curColumn"] == 2) { // Create 1 blank col & close row 
  echo "<div class='col'></div></div>";
} else if ($_SESSION["curColumn"] == 1) { // Create 2 blank cols & close row
  echo "<div class='col'></div><div class='col'></div></div>";
}
unset ($_SESSION["curColumn"]);
?>