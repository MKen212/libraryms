<?php  // List all messages SENT from User
include_once("../models/messageClass.php");
$message = new Message();

// Extend the RecursiveIteratorIterator with table tags
class MsgListSentRows extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }
  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    if ($parentKey == "MessageID") {
      // For MesssageID save the current value to $_SESSION but don't output
      $_SESSION["curMessageID"] = $parentValue;
      return;
    }
    if ($parentKey == "MsgTimestamp") {
      $returnValue = date("d/m/Y H:i T", strtotime($parentValue));
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
    echo "</tr>";
    unset ($_SESSION["curMessageID"]);
  }
}

// Loop through the Messages and output the values for the logged-in user
foreach (new MsgListSentRows(new RecursiveArrayIterator($message->getMsgsFromUserID($_SESSION["userID"]))) as $value) {
  echo $value;
}
?>