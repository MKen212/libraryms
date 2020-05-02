<?php  // Add Issued Book
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
      unset($_POST);
      return;
    }
    // Check QtyAvailable is > 0
    if ($_SESSION["qtyAvail"] <= 0) {
      echo "<div class='alert alert-danger form-user'>
        Error: No Quantity Available.
      </div>";
      unset($_POST, $_SESSION["qtyAvail"]);
      return;
    }
    // Create books_issued Database Entry
    $bookID = htmlspecialchars($_POST["bookIDSelected"]);
    $userID = htmlspecialchars($_POST["userIDSelected"]);
    $issuedDate = htmlspecialchars($_POST["issueDate"]);
    $returnDueDate = htmlspecialchars($_POST["returnDate"]);
    $issueBook = $bookIssued->addBookIssued($bookID, $userID, $issuedDate, $returnDueDate);
    unset($_POST, $_SESSION["qtyAvail"]);
    if ($issueBook) {
      // Book Issue Success / Now Update books database
      include_once("../models/bookClass.php");
      $book = new Book();
      $updateBooks = $book->updateBookQtyAvail($bookID, -1);
      if ($updateBooks) {
        // Update to books also success
        echo "<div class='alert alert-success form-user'>
          Issue of Book '$bookID' to User '$userID' was successful.
        </div>";
      } else {
        // Update to books Failure
        echo "<div class='alert alert-warning form-user'>
          Issue of Book '$bookID' to User '$userID' was only partially successful. Please check.
        </div>";
      }
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
