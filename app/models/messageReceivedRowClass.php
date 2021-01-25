<?php
/**
 * MessageReceivedRow Class - Used to extend the RecursiveIteratorIterator to display each
 * row of a Message/getListReceived query in table format
 */
class MessageReceivedRow extends RecursiveIteratorIterator {
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
