<?php  // DASHBOARD - Send Message
include_once "../app/models/messageClass.php";
$message = new Message();


// TO HERE

// Create New issued_books Record once Submit button selected
if (isset($_POST["sendMessage"])) {
  // Check that user not sending message to themselves!
  if ($_SESSION["userID"] == $_POST["userIDSelected"]) {
    echo "<div class='alert alert-danger form-user'>
      Error: Sorry, you cannot send a message to yourself.
    </div>";
    unset($_POST);
    return;
  }
  $senderID = $_SESSION["userID"];
  $receiverID = htmlspecialchars($_POST["userIDSelected"]);
  $subject = htmlspecialchars($_POST["subject"]);
  $body = htmlspecialchars($_POST["body"]);
  $sendMessage = $message->addMessage($senderID, $receiverID, $subject, $body);
  unset($_POST);
  if ($sendMessage) {
    // Add Message Success
    echo "<div class='alert alert-success form-user'>
        Issue of Message to User '$receiverID' was successful.
      </div>";
  } else {
    // Add Message Failure
    echo "<div class='alert alert-danger form-user'>
      Sorry - Issue of Message to User '$receiverID' failed.
    </div>";
  }
}
echo "</div>"; // Close-out results section
?>