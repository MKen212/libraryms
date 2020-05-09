<?php  // Enter Message Content Once Recipient Selected
if (isset($_POST["selectUser"]) || isset($_POST["sendMessage"])) {
  // Message Subject
  echo "<label class='col-form-label labFixed' for='subject'>Subject:</label>
    <div class='inpFixed'>
      <input class='form-control inpFixed' type='text' name='subject' id='subject' placeholder='Enter Subject' maxlength='40' autocomplete='off' required />
    </div>";
  // Separator
  echo "</div>
    <div class='form-group row'>";
  // Message Body
  echo "<label class='col-form-label labFixed' for='body'>Message:</label>
    <div class='inpFixed'>
      <textarea class='form-control' name='body' id='body' rows='4' placeholder='Enter Message' maxlength='500' autocomplete='off' required /></textarea>
    </div>";
  // Separator with Line
  echo "</div>
    <hr />
    <div class='form-group row'>";
  // Submit Button
  echo "<div class='col-form-label labFixed'>
      <button class='btn btn-primary' type='submit' name='sendMessage' id = 'sendMessage'>Send Message</button>
    </div>";
  // Results section
  echo"<div class='inpFixed'>";
}
?>
