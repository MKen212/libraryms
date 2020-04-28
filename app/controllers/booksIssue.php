<?php  // Issue Book
include_once("../models/bookIssuedClass.php");
$bookIssued = new BookIssued();

// Show Issue Book section if User or Book already selected
if (isset($_POST["selectBook"]) || isset($_POST["issueBook"])) {
  echo "</div>
    <hr />
    <div class='form-group row'>
      <div class='col-form-label labFixed'>
        <button class='btn btn-primary' type='submit' name='issueBook' id = 'issueBook'>Issue Book</button>
    </div>
    <div class='inpFixed'>";
  // Create New issued_books Record once Submit button selected
  if (isset($_POST["issueBook"])) {
    // Check user is an Admin
    if ($_SESSION["userIsAdmin"] != true) {
      echo "<div class='alert alert-danger form-user'>
        Error: Only Admin Users can issue books.
      </div>";
      unset($_POST, $_FILES);
      return;
    }
    // Create Database Entry
    $bookID = htmlspecialchars($_POST["bookIDSelected"]);
    $userID = htmlspecialchars($_POST["userIDSelected"]);
    $issuedDate = htmlspecialchars($_POST["issueDate"]);
    $returnDueDate = htmlspecialchars($_POST["returnDate"]);
    $issueBook = $bookIssued->addBookIssued($bookID, $userID, $issuedDate, $returnDueDate);
    unset($_POST);
    if ($issueBook) {
      // Book Issue Success
      echo "<div class='alert alert-success form-user'>
        Issue of Book '$bookID' to User '$userID' was successful.
      </div>";
    } else {
      // Book Issue Failure
      echo "<div class='alert alert-danger form-user'>
        Sorry - Issue of Book '$bookID' to User '$userID' failed.
      </div>";
    }
  }
  echo "</div>";
}
?>
