<?php
/**
 * DASHBOARD/myIssuedBooks controller - List all Issued Books for Logged-in User
 */

require_once "../app/models/bookIssuedClass.php";
$bookIssued = new BookIssued();

// Get List of ACTIVE books_issued for current user
$userID = $_SESSION["userID"];
$booksIssuedToMe = $bookIssued->getListByUser($userID, 1, false);

// Display My Issued Books View
include "../app/views/dashboard/myIssuedBooks.php";
