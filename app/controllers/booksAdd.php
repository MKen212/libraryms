<?php  // Add Book
include_once("../models/bookClass.php");
$book = new Book();

if (isset($_POST["addBook"])) {
  // Check user is an Admin
  if ($_SESSION["userIsAdmin"] != true) {
    echo "<div class='alert alert-danger form-user'>Error: Only Admin Users can add books.</div>";
    unset($_POST, $_FILES);
    return;
  }

  // Perform File Upload Checks if Image File chosen
  if ($_FILES["imgFilename"]["error"] != 4) {
    // Check Temp Image Upload Errors
    if ($_FILES["imgFilename"]["error"] != 0) {
      echo "<div class='alert alert-danger form-user'>";
      if ($_FILES["imgFilename"]["error"] == 2) {
        echo "Error: Image size larger than " . (DEFAULTS["maxUploadSize"] / 1000000) .
          " Mbytes.</div>";
      } else {
        echo "Error: Image upload error #" . $_FILES["imgFilename"]["error"] . ".</div>";
      }
      unset($_POST, $_FILES);
      return;
    }    
    // Check File Type to ensure it's an image
    $tmpFile = $_FILES["imgFilename"]["tmp_name"];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileType = $finfo->file($tmpFile);
    if (strpos($fileType, "image") === false) {
      echo "<div class='alert alert-danger form-user'>Error: Chosen File is not an image file.</div>";
      unset($_POST, $_FILES);
      return;
    }

    // Check if file already exists (Not required for adding new books!)
  }

  // Create database entry
  $title = htmlspecialchars($_POST["title"]);
  $author = htmlspecialchars($_POST["author"]);
  $publisher = htmlspecialchars($_POST["publisher"]);
  $ISBN = htmlspecialchars($_POST["ISBN"]);
  $priceGBP = htmlspecialchars($_POST["priceGBP"]);
  if ($_FILES["imgFilename"]["error"] == 0) {
    $imgFilename = basename($_FILES["imgFilename"]["name"]);
  } else {
    $imgFilename = NULL;
  }
  $addedDate = date("Y-m-d");
  $userID = $_SESSION["userID"];

  $addBook = $book->addBook($title, $author, $publisher, $ISBN, $priceGBP, $imgFilename, $addedDate, $userID);
  unset($_POST, $_FILES);
  if ($addBook) {
    // Book Add Database Entry Success
    if ($imgFilename) {
      // If Image File included, create Directory & Upload File
      $targetDir = DEFAULTS["booksImgPath"] . $addBook . "/";
      $targetFile = $targetDir . $imgFilename;
  
      if (!file_exists($targetDir)) {
        mkdir($targetDir, 0750);
      }
      if (move_uploaded_file($tmpFile, $targetFile)) {
        // File Upload Success
        echo "<div class='alert alert-success form-user'>" .
          "Addition of '$title' book with image was successful.<br />" .
          "</div>";
      }
      else {
        // File Upload Failure
        echo "<div class='alert alert-warning form-user'>" .
          "Addition of '$title' book was successful, but image upload failed.<br />" .
          "</div>";
      }
    } else {
      // No Image File to upload
      echo "<div class='alert alert-success form-user'>" .
          "Addition of '$title' book without image was successful.<br />" .
          "</div>";
    }
  } else {
    // Book Add Database Entry Failed
    echo "<div class='alert alert-danger form-user'>" .
    "Sorry - Addition of '$title' book failed." .
    "</div>";
  }
}
?>