<?php
/**
 * DASHBOARD/bookIssue controller - Add Issued Book
 */

require_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
require_once "../app/models/userClass.php";
$user = new User();
require_once "../app/models/bookClass.php";
$book = new Book();

// Add books_issued Record if issueBook POSTed
if (isset($_POST["issueBook"])) {
  $bookID = cleanInput($_POST["bookIDSelected"], "int");
  $userID = cleanInput($_POST["userIDSelected"], "int");
  $qtyAvail = cleanInput($_POST["qtyAvail"], "int");
  $issuedDate = cleanInput($_POST["issuedDate"], "string");
  $returnDueDate = cleanInput($_POST["returnDueDate"], "string");
  // Check book/QtyAvailable is > 0
  if ($qtyAvail <= 0) {
    $_SESSION["message"] = msgPrep("danger", "Error - No Quantity Available to issue!");
  } else {
    // Create books_issued Database Entry
    $issuedBookID = $bookIssued->add($bookID, $userID, $issuedDate, $returnDueDate);
    if ($issuedBookID) {  // Book Issue Success
      $_POST = [];
      // Update books database with reduced QtyAvail
      $updateBooks = $book->updateBookQtyAvail($bookID, -1);
    }
  }
}

// Initialise BooksIssued Record
$returnDuration = DEFAULTS["returnDuration"] . " days";
$booksIssuedRecord = [
  "UserID" => postValue("userIDSelected", 0),
  "BookID" => postValue("bookIDSelected", 0),
  "EarliestIssueDate" => date("Y-m-d", strtotime("-" . $returnDuration)),
  "IssuedDate" => postValue("issuedDate", date("Y-m-d")),
  "EarliestReturnDate" => date("Y-m-d"),
  "ReturnDueDate" => postValue("returnDueDate", date("Y-m-d", strtotime("+" . $returnDuration))),
];

// Get User Record for Selected User
$userRecord = [];
if (isset($booksIssuedRecord["UserID"])) {
  $selectedUserID = cleanInput($booksIssuedRecord["UserID"], "int");
  $userRecord = $user->getRecord($selectedUserID);
}

// Get Book Record for Selected Book
$bookRecord = [];
if (isset($booksIssuedRecord["BookID"])) {
  $selectedBookID = cleanInput($booksIssuedRecord["BookID"], "int");
  $bookRecord = $book->getRecord($selectedBookID);
}

// Show BookIssue Form
include "../app/views/dashboard/bookIssueForm.php";
