<?php  // DASHBOARD - Display/Edit Book Record
include_once "../app/models/bookClass.php";
$book = new Book();
include_once "../app/models/uploadImgClass.php";
$uploadImg = new UploadImg();

// Get recordID if provided
$bookID = 0;
if (isset($_GET["id"])) {
  $bookID = cleanInput($_GET["id"], "int");
}
$_GET = [];

// Update Book record if updateBook POSTed
if (isset($_POST["updateBook"])) {
  // If Image File included - Perform initial checks on file
  $initialChecks = false;
  if ($_FILES["imgFilename"]["error"] != 4) {  // File was Uploaded
    $initialChecks = $uploadImg->initialChecks();
  }

  // Only continue adding record if no file uploaded or initial checks passed
  if ($_FILES["imgFilename"]["error"] == 4 || $initialChecks == true) {
    $title = cleanInput($_POST["title"], "string");
    $author = cleanInput($_POST["author"], "string");
    $publisher = cleanInput($_POST["publisher"], "string");
    $ISBN = cleanInput($_POST["ISBN"], "string");
    $price = cleanInput($_POST["price"], "float");
    $qtyTotal = cleanInput($_POST["qtyTotal"], "int");
    $qtyAvail = cleanInput($_POST["qtyAvail"], "int");
    $imgFilename = null;
    if ($_FILES["imgFilename"]["error"] == 0) {
      $imgFilename = basename($_FILES["imgFilename"]["name"]);
    } else {
      $imgFilename = $_POST["origImgFilename"];
    }

    // Update Database Entry
    $updateBook = $book->updateRecord($bookID, $title, $author, $publisher, $ISBN, $price, $qtyTotal, $qtyAvail, $imgFilename);

    if ($updateBook == true) {  // Database Update Success
      $_POST = [];
      if ($_FILES["imgFilename"]["error"] == 0) {  // Image File included - Create dir & upload
        $newUpload = $uploadImg->addBookImg($bookID, $imgFilename);
      } else {  // No Image File Included
        $_SESSION["message"] = msgPrep("success", ($_SESSION["message"] . " No Image to upload."));
      }
      $_FILES = [];
    }
  }
}

// Get Book Details for selected record
$bookRecord = $book->getRecord($bookID);

// Prep Book Form Data
$formData = [
  "formUsage" => "Update",
  "formTitle" => "Book Details - ID: {$bookID}",
  "submitName" => "updateBook",
  "submitText" => "Update Book",
];

// Show Book Form
include "../app/views/dashboard/bookForm.php";
?>