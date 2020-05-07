<?php  // Select Book ID
include_once("../models/bookClass.php");
$book = new Book();

// Extend the RecursiveIteratorIterator with option tags
class BookIDRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "BookID") {
      echo "<option value='$parentValue'";
      if (isset($_POST["bookIDSelected"])) {
        // If bookIDSelected then make this the selected value in the option list
        if ($parentValue == $_POST["bookIDSelected"]) echo " selected";
      }
      echo ">$parentValue > ";
    } else if ($parentKey == "Title") {
      echo "$parentValue</option>";
    }
  }
}

// Show Book ID Choice section if User already selected
if (isset($_POST["selectUser"]) || isset($_POST["selectBook"]) || isset($_POST["issueBook"])) {
  echo "<label class='col-form-label labFixed' for='bookSelect'>Select Book:</label>
    <div class='input-group inpFixed'>
      <select class='form-control' id='bookSelect' name='bookIDSelected'>";
      // Loop through the Books and output "BookID > Title" for each
      foreach (new BookIDRows(new RecursiveArrayIterator($book->getBookIDs())) as $value) {
        echo $value;
      }
      echo "</select>
      <div class='input-group-append'>
        <button class='btn btn-primary' type='submit' name='selectBook'>Select</button>
      </div>
    </div>";
}
?>