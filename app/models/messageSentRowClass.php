<?php
/**
 * MessageSentRow Class - Used to extend the RecursiveIteratorIterator to display each
 * row of a Message/getListSent query in table format
 */

class MessageSentRow extends RecursiveIteratorIterator {
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
      $href = "dashboard.php?p=myMessages&id="
            . $_SESSION["curMessageID"]
            . "&cur="
            . $parentValue
            . "&updRecordStatus";
      $returnValue = statusOutput("RecordStatus", $parentValue, $href);
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
