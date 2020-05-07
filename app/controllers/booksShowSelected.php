<?php  // Show Selected Book ID
include_once("../models/bookClass.php");
$book = new Book();

if (isset($_POST["selectBook"]) || isset($_POST["issueBook"]) || isset($_GET["bookID"])) {
  if (isset($_POST["selectBook"]) || isset($_POST["issueBook"])) {
    $selBook = $book->getBookByID($_POST["bookIDSelected"]);
  } else {
    $selBook = $book->getBookByID($_GET["bookID"]);
  }
  $_SESSION["qtyAvail"] = $selBook["QtyAvail"];  // Used to check availability when book issued
  if ($selBook["ImgFilename"] == "") { // No Image Uploaded - Use Default
    $fullPath = DEFAULTS["noImgUploaded"];
  } else {
    $fullPath = DEFAULTS["booksImgPath"] . $selBook["BookID"] . "/" . $selBook["ImgFilename"];
  }

  echo "<div class='table-responsive'>
    <table class='table table-striped table-sm'>
      <thead>
        <th>Book ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>ISBN</th>
        <th>Qty Available</th>
      </thead>
      <tbody>
        <tr>
          <td>" . $selBook["BookID"] . "</td>
          <td><img class='img-thumbnail' style='width:140px; height:220px' src='$fullPath' alt='" . $selBook['ImgFilename'] . "' /></td>
          <td>" . $selBook["Title"] . "</td>
          <td>" . $selBook["Author"] . "</td>
          <td>" . $selBook["Publisher"] . "</td>
          <td>" . $selBook["ISBN"] . "</td>
          <td>" . $selBook["QtyAvail"] . "</td>
        </tr>
      </tbody>
    </table>
  </div>";
}
?>

