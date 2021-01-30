<?php
/**
 * DASHBOARD/myMessages controller - List all messages RECEIVED & SENT for
 * Logged-in User
 */

require_once "../app/models/messageClass.php";
$message = new Message();

// Get recordID if provided and process Status changes if hyperlinks clicked
$messageID = 0;
if (isset($_GET["id"])) {
  $messageID = cleanInput($_GET["id"], "int");

  if (isset($_GET["updMessageStatus"])) {  // MessageStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("MessageStatus", $curStatus);
    // Update Message MessageStatus
    $updateStatus = $message->updateStatus("MessageStatus", $messageID, $newStatus);
  } elseif (isset($_GET["updRecordStatus"])) {  // RecordStatus link was clicked
    $curStatus = cleanInput($_GET["cur"], "int");
    $newStatus = statusCycle("RecordStatus", $curStatus);
    // Update Message RecordStatus
    $updateStatus = $message->updateStatus("RecordStatus", $messageID, $newStatus);
  }
  // Update Unread Message Link
  $unreadClass = "badge badge-info";
  $unreadCount = $message->countUnreadByUserID($_SESSION["userID"]);
  // Update Badge if no unread
  if ($unreadCount == 0) {
    $unreadClass = "badge badge-light";
  }
  $msgsUnreadLink = "<a class='{$unreadClass}' href='dashboard.php?p=myMessages'><span data-feather='mail'></span> {$unreadCount}</a>";?>
  <script>
    document.getElementById("msgsUnread").innerHTML = "<?= $msgsUnreadLink ?>";
  </script><?php
}
$_GET = [];

// Get List of ACTIVE RECEIVED messages for current user
$userID = $_SESSION["userID"];
$receivedMessageList = $message->getListReceived($userID, 1);

// Get List of ALL SENT messages for current user
$sentMessageList = $message->getListSent($userID, null);

// Show My Messages View
include "../app/views/dashboard/messagesList.php";
