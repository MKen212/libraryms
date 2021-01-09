<?php  // DASHBOARD - List all messages RECEIVED & SENT for Logged-in User
include_once "../app/models/messageClass.php";
$message = new Message();

// Extend the RecursiveIteratorIterator with table tags
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
    } else if ($parentKey == "SenderID") {
      // For SenderID save the current value to $_SESSION but dont output
      $_SESSION["curSenderID"] = $parentValue;
      return;
    } else if ($parentKey == "Subject") {
      // For Subject save the current value to $_SESSION and DO output
      $_SESSION["curSubject"] = $parentValue;
      $returnValue = $parentValue;
    } else if ($parentKey == "AddedTimestamp") {
      // For Date Fields modify date format
      $returnValue = date("d/m/Y H:i T", strtotime($parentValue));
    } else if ($parentKey == "MessageStatus") {
      // For Status Codes output texts with update hyperlinks
      $returnValue = statusOutput("MessageStatus", $parentValue, "dashboard.php?p=myMessages&id={$_SESSION["curMessageID"]}&cur={$parentValue}&updMessageStatus");
    } else if ($parentKey == "RecordStatus") {
      $returnValue = statusOutput("RecordStatus", $parentValue, "dashboard.php?p=myMessages&id={$_SESSION["curMessageID"]}&cur={$parentValue}&updRecordStatus");
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>" . $returnValue . "</td>";
  }
  public function beginChildren() {
    echo "<tr>";
  }
  public function endChildren() {
    // Add Reply Column
    echo "<td><a class='badge badge-success' href='dashboard.php?p=messageSend.php?r=" . $_SESSION["curSenderID"] . "&s=" . $_SESSION["curSubject"] . "'>Reply</a></td>";
    echo "</tr>";
    unset ($_SESSION["curMessageID"], $_SESSION["curSenderID"], $_SESSION["curSubject"]);
  }
}

// UP TO HERE - NEED TO ADD SENT ROWS CLASS

// Loop through the Messages and output the values for the logged-in user
foreach (new ReceivedMessagesRow(new RecursiveArrayIterator($message->getListReceived($_SESSION["userID"], 1))) as $value) {
  echo $value;
}
?>