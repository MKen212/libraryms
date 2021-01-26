<?php
/**
 * BookIssuedRow Class - Used to extend the RecursiveIteratorIterator to display each
 * row of a BookIssued/getList query in table format
 */

class BookIssuedRow extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }

  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if ($parentKey == "IssuedID") {
      // For IssuedID save the current value to $_SESSION & skip output
      $_SESSION["curIssuedID"] = $parentValue;
      return;
    } elseif ($parentKey == "BookID") {
      // For BookID save the current value to $_SESSION & skip output
      $_SESSION["curBookID"] = $parentValue;
      return;
    } elseif ($parentKey == "UserID") {
      // For UserID skip output
      return;
    } elseif (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "ReturnActualDate") {
      // For ReturnActualDate, if NULL provide Return hyperlink, or return ReturnDate
      if (empty($parentValue)){
        $href = "dashboard.php?p=booksIssuedList&id="
              . $_SESSION["curIssuedID"]
              . "&bookID="
              . $_SESSION["curBookID"]
              . "&updReturn";
        $returnValue = "<a class='badge badge-primary' href='{$href}'>Return</a>";
        $_SESSION["countOutstanding"] += 1;
      } else {
        $returnValue = date("d/m/Y", strtotime($parentValue));
      }
    } elseif ($parentKey == "RecordStatus") {
      // For RecordStatus output value with update hyperlink
      $href = "dashboard.php?p=booksIssuedList&id="
            . $_SESSION["curIssuedID"]
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

  public function beginIteration() {
    $_SESSION["countIssued"] = 0;
    $_SESSION["countOutstanding"] = 0;
  }

  public function beginChildren() {
    $_SESSION["countIssued"] += 1;
    echo "<tr>";
  }

  public function endChildren() {
    echo "</tr>";
    unset ($_SESSION["curIssuedID"], $_SESSION["curBookID"]);
  }

  public function endIteration() {
    // Add final summary row of total currently issued & total outstanding
    echo "<tr class='table-info'><td colspan='6'>"
       . "<b>Total issued: {$_SESSION["countIssued"]} "
       . "/ Outstanding: {$_SESSION["countOutstanding"]}</b>"
       . "</td></tr>";
    unset($_SESSION["countIssued"], $_SESSION["countOutstanding"]);
  }
}
