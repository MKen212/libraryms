<?php  // Confirm Issue Date & Return Due Date
if (isset($_POST["selectBook"]) || isset($_POST["issueBook"])) {
  // Issue Date
  isset($_POST["issueDate"]) ? 
    $issueDate = $_POST["issueDate"] :
    $issueDate = date("Y-m-d");
  echo "<label class='col-form-label labFixed' for='issueDate'>Issued Date:</label>
    <div class='input-group inpFixed'>
      <input class='form-control' type='date' name='issueDate' id='issueDate' min='" . date("Y-m-d", strtotime("-" . DEFAULTS["returnDuration"] . " days")) . "' value='" . $issueDate . "' required />
      <div class='input-group-append'>
        <button class='btn btn-primary' type='button' name='selectIssueDate'>Select</button>
      </div>
    </div>";
  // Separator
  echo "</div>
    <div class='form-group row'>";
  // Return Due Date
  isset($_POST["returnDate"]) ?
    $returnDueDate = $_POST["returnDate"] :
    $returnDueDate = date("Y-m-d", strtotime("+" . DEFAULTS["returnDuration"] . " days"));
  echo "<label class='col-form-label labFixed' for='returnDate'>Return Due Date:</label>
    <div class='input-group inpFixed'>
      <input class='form-control' type='date' name='returnDate' id='returnDate' min='" . date("Y-m-d") . "' value='" . $returnDueDate . "' required />
      <div class='input-group-append'>
        <button class='btn btn-primary' type='button' name='selectReturnDate'>Select</button>
      </div>
    </div>";
  // Separator with Line
  echo "</div>
    <hr />
  <div class='form-group row'>";
  // Submit Button
  echo "<div class='col-form-label labFixed'>
      <button class='btn btn-primary' type='submit' name='issueBook' id = 'issueBook'>Issue Book</button>
    </div>";
  // Results section
  echo"<div class='inpFixed'>";
}
?>
