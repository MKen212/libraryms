<?php
/**
 * DASHBOARD/bookAdd controller - Add Book
 */

require_once "../app/models/bookClass.php";
$book = new Book();
require_once "../app/models/uploadImgClass.php";
$uploadImg = new UploadImg();

// Add Product Record if Add POSTed
if (isset($_POST["addBook"])) {
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
    $quantity = cleanInput($_POST["quantity"], "int");
    $imgFilename = null;
    if ($_FILES["imgFilename"]["error"] == 0) {
      $imgFilename = basename($_FILES["imgFilename"]["name"]);
    }

    // Create Database Entry
    $newBookID = $book->add($title, $author, $publisher, $ISBN, $price, $quantity, $imgFilename);

    if ($newBookID) {  // Book Add Database Entry Success
      $_POST = [];
      if ($_FILES["imgFilename"]["error"] == 0) {  // Image File included - Create dir & upload
        $newUpload = $uploadImg->addBookImg($newBookID, $imgFilename);
      } else {  // No Image File Included
        $_SESSION["message"] = msgPrep("success", ($_SESSION["message"] . " No Image to upload."));
      }
      $_FILES = [];
    }
  }
}

// Initialise Book Record
$bookRecord = [
  "Title" => postValue("title"),
  "Author" => postValue("author"),
  "Publisher" => postValue("publisher"),
  "ISBN" => postValue("ISBN"),
  "Price" => postValue("price"),
  "Quantity" => postValue("quantity"),
];

// Prep Book Form Data
$formData = [
  "formUsage" => "Add",
  "formTitle" => "Add Book",
  "submitName" => "addBook",
  "submitText" => "Add Book",
];

// Show Book Form
include "../app/views/dashboard/bookForm.php";
