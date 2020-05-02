<?php  // Return Issued Book
include("../config/_config.php");
include_once("../models/bookIssuedClass.php");
$bookIssued = new BookIssued();

if (isset($_GET["updateID"])) {
  $issuedID = $_GET["updateID"];
  $bookID = $_GET["bookID"];
  $returnedDate = date("Y-m-d");  // Set returned date to today
  $returnBook = $bookIssued->returnBookIssued($issuedID, $returnedDate);
  unset($_GET);
  if ($returnBook) {
    // Book Return Success / Now Update books database
    include_once("../models/bookClass.php");
    $book = new Book();
    $updateBooks = $book->updateBookQtyAvail($bookID, +1);
    if ($updateBooks) {
      // Update to books also success
      header("location:../views/main.php");
    } else {
      // Update to books Failure
      print_r($updateBooks);
    }
  } else {
    // Book Return Failure
    print_r($returnBook);
  }
}
?>