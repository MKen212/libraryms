<?php
/**
 * DASHBOARD/booksIssuedByBook controller - List all Outstanding Issued Books for a
 * Particular Book
 */

require_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();
require_once "../app/models/bookClass.php";
$book = new Book();

// Get recordID & bookRecord if provided
$bookID = 0;
$bookRecord = [];
if (isset($_GET["id"])) {
  $bookID = cleanInput($_GET["id"], "int");
  $bookRecord = $book->getRecord($bookID);
}
$_GET = [];

// Get List of ACTIVE & OUTSTANDING books_issued for BookID
$booksIssuedByBook = $bookIssued->getListByBook($bookID, 1, true);

// Display Books Issued By Book View
include "../app/views/dashboard/booksIssuedByBook.php";
