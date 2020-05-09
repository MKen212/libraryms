<?php  // Update BookStatus
include("../config/_config.php");
include_once("../models/bookClass.php");
$book = new Book();

if (isset($_GET["updateID"])) {
  $bookID = $_GET["updateID"];
  $newStatus = $_GET["newStatus"];
  $update = $book->updateBookStatus($bookID, $newStatus);
  unset($_GET);
  if ($update) {
    // Update Success
    header("location:../views/main.php");
  } else {
    // Update Failure
    print_r($update);
  }
}
?>