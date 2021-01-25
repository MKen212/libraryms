<?php
/**
 * BookRow Class - Used to extend the RecursiveIteratorIterator to display each row
 * of a Book/getList query in table format
 */
class BookRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }

  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION & skip output
      $_SESSION["curBookID"] = $parentValue;
      return;
    } elseif ($parentKey == "Title") {
      // For Title output edit hyperlink
      $returnValue = "<a href='dashboard.php?p=bookDetails&id={$_SESSION["curBookID"]}'>{$parentValue}</a>";
    } elseif ($parentKey == "AddedTimestamp") {
      // For Date/Time Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "RecordStatus") {
      // For Status Codes output texts with update hyperlinks
      $returnValue = statusOutput("RecordStatus", $parentValue,"dashboard.php?p=booksList&id={$_SESSION["curBookID"]}&cur={$parentValue}&updRecordStatus");
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
    unset ($_SESSION["curBookID"]);
  }
}
