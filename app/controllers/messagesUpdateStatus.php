<?php  // Update Message Read/UnRead Status
include("../config/_config.php");
include_once("../models/messageClass.php");
$message = new Message();

if (isset($_GET["updateID"])) {
  $messageID = $_GET["updateID"];
  $newStatus = $_GET["newStatus"];
  $update = $message->UpdateMsgRead($messageID, $newStatus);
  unset($_GET);
  if ($update) {
    // Update Success
    header("location:../views/main-messagesDisplay.php");
  } else {
    // Update Failure
    print_r($update);
  }
}
?>