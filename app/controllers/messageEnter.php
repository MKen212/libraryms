<?php  // Enter Message Content Once Recipient Selected
if (isset($_POST["selectUser"])) {

  // UPDATE FOLLOWING FOR ENTRY OF SUBJECT/BODY


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
}
?>
