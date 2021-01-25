<?php
/**
 * DASHBOARD/booksDisplay controller - Display all Books in card format
 */

require_once "../app/models/bookClass.php";
$book = new Book();

// Fix Book Title Search, if available in $_SESSION
$title = null;
if (isset($_SESSION["navSchString"])) {
  $title = fixSearch($_SESSION["navSchString"]);
}

// Get Display List of ACTIVE books
$bookDisplay = $book->getDisplay($title);

// Show Books Display View
include "../app/views/dashboard/booksDisplay.php";
