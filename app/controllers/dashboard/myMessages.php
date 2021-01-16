<?php  // DASHBOARD - List all messages RECEIVED & SENT for Logged-in User
include_once "../app/models/messageClass.php";
$message = new Message();

// Extend the RecursiveIteratorIterator with table tags for RECEIVED message list
class ReceivedMessagesRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "MessageID") {
      // For MesssageID save the current value to $_SESSION but dont output
      $_SESSION["curMessageID"] = $parentValue;
      return;
    } elseif ($parentKey == "SenderID") {
      // For SenderID save the current value to $_SESSION but dont output
      $_SESSION["curSenderID"] = $parentValue;
      return;
    } elseif ($parentKey == "Subject") {
      // For Subject save the current value to $_SESSION and DO output
      $_SESSION["curSubject"] = $parentValue;
      $returnValue = $parentValue;
    } elseif ($parentKey == "AddedTimestamp") {
      // For Date Fields modify date format
      $returnValue = date("d/m/Y H:i T", strtotime($parentValue));
    } elseif ($parentKey == "MessageStatus") {
      // For MessageStatus Codes output texts with update hyperlinks
      $returnValue = statusOutput("MessageStatus", $parentValue, "dashboard.php?p=myMessages&id={$_SESSION["curMessageID"]}&cur={$parentValue}&updMessageStatus");
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    // Add Reply Column
    echo "<td><a class='badge badge-primary' href='dashboard.php?p=messageSend&id=" . $_SESSION["curMessageID"] . "&recID=" . $_SESSION["curSenderID"] . "&sub=" . $_SESSION["curSubject"] . "&reply'>Reply</a></td>";
    echo "</tr>";
    unset ($_SESSION["curMessageID"], $_SESSION["curSenderID"], $_SESSION["curSubject"]);
  }
}

// Extend the RecursiveIteratorIterator with table tags for SENT message list
class SentMessagesRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "MessageID") {
      // For MesssageID save the current value to $_SESSION but don't output
      $_SESSION["curMessageID"] = $parentValue;
      return;
    } elseif ($parentKey == "AddedTimestamp") {
      // For Date Fields modify date format
      $returnValue = date("d/m/Y H:i T", strtotime($parentValue));
    } elseif ($parentKey == "MessageStatus") {
      // For MessageStatus Codes output texts with NO update hyperlinks
      $returnValue = statusOutput("MessageStatus", $parentValue, null);
    } elseif ($parentKey == "RecordStatus") {
      // For RecordStatus Codes output texts with update hyperlinks
      $returnValue = statusOutput("RecordStatus", $parentValue, "dashboard.php?p=myMessages&id={$_SESSION["curMessageID"]}&cur={$parentValue}&updRecordStatus");
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    echo "</tr>";
    unset ($_SESSION["curMessageID"]);
  }
}

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
  if ($unreadCount == 0) $unreadClass = "badge badge-light";  // Update Badge if no unread
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

// Display My Messages View
include "../app/views/dashboard/myMessages.php";
?>