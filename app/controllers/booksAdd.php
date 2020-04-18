<?php  // Add Book
include_once("../models/bookClass.php");
$book = new Book();

if (isset($_POST["addBook"])) {
  // Perform File Upload if Image File chosen
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
      return;
    }
    $tmpFile = $_FILES["imgFilename"]["tmp_name"];
    $targetFile = DEFAULTS["booksImgPath"] . basename($_FILES["imgFilename"]["name"]);
    
    // Check File Type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileType = $finfo->file($tmpFile);
    if (strpos($fileType, "image") === false) {
      echo "<div class='alert alert-danger form-user'>Error: Chosen File is not an image file.</div>";
      return;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
      echo "<div class='alert alert-danger form-user'>Error: Image File Already Uploaded.</div>";
      return;
    }
    
    // Upload Image File
    if (move_uploaded_file($tmpFile, $targetFile) === false) {
      echo "<div class='alert alert-danger form-user'>Error: Image File upload failed.</div>";
      return;
    }
  }
  echo "File uploaded or not selected - now load DB";
  // Fix permission denied errors  <<< TO HERE

  // Should only upload file once DB created and can then use book id for directory but thats not going to work on exist check. Maybe need both sets of chec
  // Exist check not required if creating NEW entry as no file will yet exist
  /*
  
      


  

    

  
  // Check Image File for Initial Upload errors
  
  // Check Image File for additional errors




  /*
  $title = htmlspecialchars($_POST["title"]);
  $author = htmlspecialchars($_POST["author"]);
  $publisher = htmlspecialchars($_POST["publisher"]);
  $ISBN = htmlspecialchars($_POST["ISBN"]);
  $priceGBP = htmlspecialchars($_POST["priceGBP"]);
  $imgFilename = htmlspecialchars($_POST["imgFilename"]);
  $dateAdded = date("Y-m-d");
  $userID = $_SESSION["userID"];

  $addBook = $book->addBook($title, $author, $publisher, $ISBN, $priceGBP, $imgFilename, $dateAdded, $userID);
  unset($_POST);
  if ($addBook) {
    // Book Add Success
    echo "<div class='alert alert-success form-user'>" .
    "Addition of '$title' book was successful.<br />" .
    "</div>";
  } else {
    // Book Add Failure
    echo "<div class='alert alert-danger form-user'>" .
    "Sorry - Addition of '$title' book failed." .
    "</div>";
  }
  */
}
?>