<?php  // Display all Books in card format
include_once("../models/bookClass.php");
$book = new Book();
$curColumn = 0;

// Loop through ALL Books and output the values
foreach($book->getBooksAll() as $value) {
  $curColumn += 1;
  if ($curColumn == 1) echo "<div class='row'>";
  echo "<div class='col border rounded'>";
    // Display Image
    $filename = $value["ImgFilename"];
    $fullPath = DEFAULTS["booksImgPath"] . $value["BookID"] . "/" . $filename;
    echo "<img class='img-thumbnail float-left mt-3 mb-3 mr-3' style='width:140px; height:220px' src='$fullPath' alt='$filename' />";
    // Output Book Details
    echo "<div class='mt-3'>";
      echo "<b>Book ID: </b>" . $value["BookID"] . "<br />";
      echo "<b>Title: </b>" . $value["Title"] . "<br />";
      echo "<b>Author: </b>" . $value["Author"] . "<br />";
      echo "<b>Publisher: </b>" . $value["Publisher"] . "<br />";
      echo "<b>ISBN: </b>" . $value["ISBN"] . "<br />";
      echo "<b>Price (GBP): </b>" . $value["PriceGBP"] . "<br />";
      echo "<b>Total Qty: </b>" . $value["QtyTotal"] . " - ";
      echo "<b>Available: <span class='";
      if ($value["QtyAvail"] == 0) {
        echo "text-danger";
      } else {
        echo "text-success";
      }
      echo "'>" . $value["QtyAvail"] . "</span></b><br />";
      echo "<b>Date Added: </b>" . $value["AddedDate"] . " ";
      echo "<b>by User: </b>" . $value["UserID"] . "<br />";
    echo "</div>";

  echo "</div>";
  if ($curColumn == DEFAULTS["booksDisplayCols"]) {
    echo "</div>";
    $curColumn = 0;
  }
}
if ($curColumn != 0) echo "</div>";  // Final </div> if not output

// NEED TO SORT SEARCH BAR WIDTH (FOR BOTH) AND SEARCH DIFFERENCE
/*
echo "<pre>";
print_r($value);
echo "</pre>";
*/
?>