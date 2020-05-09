<?php  // List all messages to User
include_once("../models/messageClass.php");
$message = new Message();

// Extend the RecursiveIteratorIterator with table tags
class MsgListRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "MessageID") {
      // For MesssageID save the current value to $_SESSION
      $_SESSION["curMessageID"] = $parentValue;
    }
    if ($parentKey == "MsgTimestamp") {
      $returnValue = date("d/m/Y H:i T", strtotime($parentValue));
    } else if ($parentKey == "MsgRead") {
      // For MsgRead output Unread/Read + Change Link
      if ($parentValue == 0) {
        $returnValue = "<a class='badge badge-info' href='../controllers/messagesUpdateStatus.php?updateID=" . $_SESSION["curMessageID"] . "&newStatus=1'>Unread</a>";
      } else {
        $returnValue = "<a class='badge badge-light' href='../controllers/messagesUpdateStatus.php?updateID=" . $_SESSION["curMessageID"] . "&newStatus=0'>Read</a>";
      }
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
    echo "<td><a class='badge badge-success' href='../views/main.php?'>Reply</a></td>";
    echo "</tr>";
    unset ($_SESSION["curMessageID"]);
  }
}

// Loop through the Messages and output the values for the logged-in user
foreach (new MsgListRows(new RecursiveArrayIterator($message->getMsgsByUserID($_SESSION["userID"]))) as $value) {
  echo $value;
}
?>