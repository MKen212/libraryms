<?php  // DASHBOARD - Send Message
include_once "../app/models/messageClass.php";
$message = new Message();
include_once "../app/models/userClass.php";
$user = new User();

// Get recipient details if passed from MyMessages
if (isset($_GET["reply"])) {
  $originalMsgID = cleanInput($_GET["id"], "int");
  $_POST["userIDSelected"] = cleanInput($_GET["recID"], "int");
  $_POST["subject"] = cleanInput($_GET["sub"], "string");
  // Mark original message as Read
  $updateStatus = $message->updateStatus("MessageStatus", $originalMsgID, 1);
  // Update Unread Message Link
  $unreadClass = "badge badge-info";
  $unreadCount = $message->countUnreadByUserID($_SESSION["userID"]);
  if ($unreadCount == 0) $unreadClass = "badge badge-light";  // Update Badge if no unread
  $msgsUnreadLink = "<a class='{$unreadClass}' href='dashboard.php?p=myMessages'><span data-feather='mail'></span> {$unreadCount}</a>";?>
  <script>
    document.getElementById("msgsUnread").innerHTML = "<?= $msgsUnreadLink ?>";
  </script><?php
}
$_GET = [];

// Create New messages record if Send POSTed
if (isset($_POST["sendMessage"])) {
  if ($_SESSION["userID"] == $_POST["userIDSelected"]) {
    // Check that user is not sending a message to themselves!
    $_SESSION["message"] = msgPrep("danger", "Error - You cannot send a message to yourself!");
  } else {
    $senderID = $_SESSION["userID"];
    $receiverID = cleanInput($_POST["userIDSelected"], "int");
    $subject = cleanInput($_POST["subject"], "string");
    $body = cleanInput($_POST["body"], "string");
    // Create messages Database Entry
    $newMsgID = $message->add($senderID, $receiverID, $subject, $body);
    if ($newMsgID) {  // Add Message Success
      $_POST = [];
      $_SESSION["message"] = msgPrep("success", "Issue of Message to User '{$receiverID}' was successful.");
    }
  }
}

// Initialise Message Record
$messageRecord = [
  "ReceiverID" => postValue("userIDSelected", 0),
  "Subject" => postValue("subject"),
  "Body" => postValue("body"),
];

// Get User Record for Selected Receiver ID
$userRecord = [];
if (isset($messageRecord["ReceiverID"])) {
  $selectedUserID = cleanInput($messageRecord["ReceiverID"], "int");
  $userRecord = $user->getRecord($selectedUserID);
}

// Show Message Form
include "../app/views/dashboard/messageForm.php";
?>