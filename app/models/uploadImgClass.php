<?php  // Upload Image Class
class UploadImg {
  /**
   * initialChecks function - Performs initial checks on temporary uploaded file
   * @return bool  True if success or False
   */
  public function initialChecks() {
    try {
      if ($_FILES["imgFilename"]["error"] === UPLOAD_ERR_OK) {  // Temp Upload OK
        // Check File Type to ensure it's an image
        $tmpFile = $_FILES["imgFilename"]["tmp_name"];
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $fileType = $finfo->file($tmpFile);
        if (strpos($fileType, "image") === false) {  // Not an image file
          throw new UploadException("11");     
        } else {
          return true;
        }
      } else {  // Temp Upload Failed
        throw new UploadException($_FILES["imgFilename"]["error"]);
      }
    } catch (UploadException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - UploadImg/initialChecks Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * addBookImg function - Add Book Image File to Server
   * @param int    $bookID       Book ID for Image File
   * @param string $imgFilename  Filename for Image File
   * @return bool                True if success or False
   */
  public function addBookImg($bookID, $imgFilename) {
    try {
      $tmpFile = $_FILES["imgFilename"]["tmp_name"];
      $targetDir = DEFAULTS["booksImgPath"] . $bookID . "/";
      $targetFile = $targetDir . $imgFilename;

      // Create Path if not exists
      if (!file_exists($targetDir)) mkdir($targetDir, 0750);

      // Move Temp File to Upload Path
      if (move_uploaded_file($tmpFile, $targetFile)) {
        // File Upload Success
        $_SESSION["message"] = msgPrep("success", ($_SESSION["message"] . " Image successfully uploaded."));
      } else {
        // File Upload Failure
        $_SESSION["message"] = msgPrep("warning", ($_SESSION["message"] . " Warning: Image upload failed."));
      }
      return true;
    } catch (Exception $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - UploadImg/addBookImg Failed: {$err->getMessage()}");
      return false;
    }
  }
}

// Upload Exception Class
class UploadException extends Exception {
  /**
   * Construct function - Create the Exception object
   */
  public function __construct($code) {
    $message = $this->codeToMessage($code);
    parent::__construct($message, $code);
  }

  /**
   * codeToMessage function - Creates the Error Message from the Code
   * @param int $code         Upload Error Code
   * @return string $message  Error Message for the specific error code
   */
  private function codeToMessage($code) {
    switch($code){
      case UPLOAD_ERR_INI_SIZE :  // 1
        $message = "Uploaded File Size exceeds maximum set in php.ini.";
        break;
      case UPLOAD_ERR_FORM_SIZE :  // 2
        $message = "Uploaded File Size exceeds " . (DEFAULTS["maxUploadSize"] / 1000000) . " Mbyte(s).";
        break;
      case UPLOAD_ERR_PARTIAL :  // 3
        $message = "Uploaded File was only partially uploaded.";
        break;
      case UPLOAD_ERR_NO_FILE :  // 4
        $message = "No File was uploaded.";
        break;
      case UPLOAD_ERR_NO_TMP_DIR : //6 (No 5!)
        $message = "Missing Temporary Folder.";
        break;
      case UPLOAD_ERR_CANT_WRITE : // 7
        $message = "Failed to write to disk.";
        break;
      case UPLOAD_ERR_EXTENSION :  // 8
        $message = "A PHP extension stopped the File Upload.";
        break;
      case 11 :  // User Addition for Checking Image Files
        $message = "Chosen File is not an image file.";
        break;
      default :
        $message = "Unknown File Upload error.";
        break;
    }
    return $message;
  }
}
?>