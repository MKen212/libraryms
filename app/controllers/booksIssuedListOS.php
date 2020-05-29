<?php  // List all Outstanding Issued Books for User
include_once("../models/bookIssuedClass.php");
$bookIssued = new BookIssued();

// Extend the RecursiveIteratorIterator with table tags
class BooksOSListRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "IssuedID") {
      // For IssuedID save the current value to $_SESSION
      $_SESSION["curIssuedID"] = $parentValue;
    }
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION
      $_SESSION["curBookID"] = $parentValue;
    }
    if ($parentKey == "IssuedDate") {
      if (!is_null($parentValue)) {
        // For Non-Null Date Fields modify date format
        $returnValue = date("d/m/Y", strtotime($parentValue));
      }
    } else if ($parentKey == "ReturnedDate") {
      // For Returned Date (which is Null) provide return link
      $returnValue = "<a class='badge badge-success' href='../controllers/booksIssuedReturn.php?updateID=" . $_SESSION["curIssuedID"] . "&bookID=" . $_SESSION["curBookID"] . 
      "'>Return</a>";
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
    unset ($_SESSION["curIssuedID"], $_SESSION["curBookID"]);
  }
}

if (isset($_POST["selectOSUser"])) {
  $selOSUser = $_POST["userIDSelected"];
  $_SESSION["rowCount"] = 0;
  // Output Table header
  echo "<div class='table-responsive'>
    <table class='table table-striped table-sm'>
      <thead>
        <th>Issued ID</th>
        <th>Book ID</th>
        <th>Book Title</th>
        <th>User ID</th>
        <th>User Name</th>
        <th>Issued Date</th>
        <th>Return Due Date</th>
        <th>Return Book</th>
      </thead>
      <tbody>";
  // Loop through ALL Outstanding Issued Books for user and output the values
  foreach (new BooksOSListRows(new RecursiveArrayIterator($bookIssued->getBooksOSByUserID($selOSUser))) as $value) {
    echo $value;
  }
  echo "</tbody>
    </table>
  </div>";
  echo "Record Count: " . $_SESSION["rowCount"] . " book(s).";
  unset ($_SESSION["rowCount"]);
}
?>
