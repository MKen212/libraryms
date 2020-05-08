<?php  // Welcome UserName & Unread Message Icon in Side-bar
include_once("../models/messageClass.php");
$message = new Message();

// UserName
echo $_SESSION["userName"];

// Check Unread Message
$unreadCount = $message->cntUnreadByUserID($_SESSION["userID"]);
if ($unreadCount > 0) {
  echo " <a class='badge badge-info' href='../views/main-messagesDisplay.php'><span data-feather='mail'></span> $unreadCount</a>";
}
?>
