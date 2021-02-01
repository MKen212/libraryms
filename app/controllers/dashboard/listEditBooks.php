<?php
/**
 * DASHBOARD/listEditBooks controller - List all Books (No Image) with link
 * to Display/Edit
 */

namespace LibraryMS;

require_once "../app/models/bookClass.php";
$book = new Book();

// Get recordID if provided and process Status changes if hyperlinks clicked
$bookID = 0;
if (isset($_GET["id"])) {
  $bookID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update Book RecordStatus
    $updateStatus = $book->updateRecordStatus($bookID, $newStatus);
  }
}
$_GET = [];

// Fix Book Title Search, if entered
$title = null;
if (isset($_POST["bookSearch"])) {
  $title = fixSearch($_POST["schTitle"]);
}
$_POST = [];

// Get List of books
$bookList = $book->getList($title);

// Show Books List View
include "../app/views/dashboard/booksList.php";
