<?php
/**
 * DASHBOARD/listReturnIssuedBooks controller - List/Return Issued Books
 */

require_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
require_once "../app/models/bookClass.php";
$book = new Book();

// Get recordID if provided and process Status changes if hyperlinks clicked
$issuedID = 0;
if (isset($_GET["id"])) {
  $issuedID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update books_issued RecordStatus
    $updateStatus = $bookIssued->updateRecordStatus($issuedID, $newStatus);
  } elseif (isset($_GET["updReturn"])) {  // Return link was clicked
    $bookID = cleanInput($_GET["bookID"], "int");
    $returnedDate = date("Y-m-d");  // Set returned date to today
    $returnBook = $bookIssued->returnBook($issuedID, $returnedDate);
    // If Return Processed then update books table
    if ($returnBook != 1) {
      msgPrep("warning", "Sorry - Return not processed correctly.");
    } else {
      $updateBooks = $book->updateBookQtyAvail($bookID, +1);
    }
  }
}
$_GET = [];

// Fix Search String, if entered
$schString = null;
if (isset($_POST["bksIssSearch"])) {
  $schString = fixSearch($_POST["schString"]);
}
$_POST = [];

// Get List of books_issued
$booksIssuedList = $bookIssued->getList($schString);

// Show BooksIssuedList View
include "../app/views/dashboard/booksIssuedList.php";
