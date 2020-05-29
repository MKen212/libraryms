<?php  // Welcome UserName & Unread Message Icon in Side-bar
include_once("../models/messageClass.php");
$message = new Message();

// UserName
echo $_SESSION["userName"];

// Check Unread Message
$unreadCount = $message->cntUnreadByUserID($_SESSION["userID"]);
$unreadCount == 0 ?
  $linkClass = "badge badge-light" :
  $linkClass = "badge badge-info";
echo " <a class='$linkClass' href='../views/main-messages.php'><span data-feather='mail'></span> $unreadCount</a>";
?>
