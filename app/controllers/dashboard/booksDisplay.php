<?php  // DASHBOARD - Display all Books in card format
include_once "../app/models/bookClass.php";
$book = new Book();

// Extend the RecursiveIteratorIterator with div tags
class BookDisplayCard extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION
      $_SESSION["curBookID"] = $parentValue;
      return;
    } elseif ($parentKey == "ImgFilename") {
      $returnValue = "<img class='img-thumbnail float-left mt-3 mb-3 mr-3' style='width:140px; height:220px;' src='" . getFilePath($_SESSION["curBookID"], $parentValue) . "' alt='{$parentValue}' /><div class='mt-3'><b>Book ID: </b>{$_SESSION["curBookID"]}<br />";
    } elseif ($parentKey == "Price") {
      $returnValue = "<b>Price (" . DEFAULTS["currency"] . "): </b>{$parentValue}<br /><br />";
    } elseif ($parentKey == "QtyTotal") {
      $returnValue = "<b>Total Qty: </b>{$parentValue} - ";
    } elseif ($parentKey == "QtyAvail") {
      $parentValue <= 0 ? $returnClass = "text-danger" : $returnClass = "text-success";
      $returnValue = "<b>Available: <span class='{$returnClass}'>{$parentValue}</span></b><br /></div>";
    } elseif ($parentKey == "RecordStatus") {
      // For RecordStatus skip output
      return;
    } else {
      $returnValue = "<b>{$parentKey}: </b>{$parentValue}<br />";
    }
    return $returnValue;
  }
  public function beginIteration() {  // Start Column Count
    $_SESSION["curColumn"] = 0;
  }
  public function beginChildren() {
    $_SESSION["curColumn"] += 1;
    if ($_SESSION["curColumn"] == 1) echo "<div class='row'>";  // Create New Row div
    echo "<div class='col-4 border rounded'>"; // Create Col div
  }
  public function endChildren() {
    // Add Hyperlink to Show Books Issued for book
    echo "<a class='badge badge-info' href='dashboard.php?p=booksIssued.php&id={$_SESSION["curBookID"]}'>Show Currently Issued</a>";
    echo "</div>";  // Close Col div
    unset ($_SESSION["curBookID"]);
    if ($_SESSION["curColumn"] == 3) {
      echo "</div>";  // If 3 Cols reached close row div & reset count
      $_SESSION["curColumn"] = 0;
    }
  }
  public function endIteration() {
    if ($_SESSION["curColumn"] > 0) {  // If in middle of a row then pad blank columns
      for ($count = $_SESSION["curColumn"]; $count < 3; $count += 1) {
        echo "<div class='col-4'></div>"; // Add Blank Columns
      }
      echo "</div>"; // Close final row
    }
    unset ($_SESSION["curColumn"]);
  }
}

// Fix Book Title Search, if entered
$title = null;
if (isset($_POST["bookSearch"])) $title = fixSearch($_POST["schTitle"]);
$_POST = [];

// Get Display List of ACTIVE books
$bookDisplay = $book->getDisplay($title);

// Show Books Display View
include "../app/views/dashboard/booksDisplay.php";
?>