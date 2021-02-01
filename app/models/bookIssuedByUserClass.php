<?php
/**
 * BookIssuedByUser Class - Used to extend the RecursiveIteratorIterator
 * to display each row of a BookIssued/getListByUser query in table format
 */

namespace LibraryMS;

use RecursiveIteratorIterator;

class BookIssuedByUser extends RecursiveIteratorIterator {
  public function __construct($result) {
    parent::__construct($result, self::LEAVES_ONLY);
  }

  public function current() {
    $parentKey = parent::key();
    $parentValue = parent::current();
    $returnValue = "";
    if (($parentKey == "IssuedDate" || $parentKey == "ReturnDueDate") && (!empty($parentValue))) {
      // For Non-Empty Date Fields modify date format
      $returnValue = date("d/m/Y", strtotime($parentValue));
    } elseif ($parentKey == "ReturnActualDate") {
      // For ReturnActualDate, if NULL return NULL, or return ReturnDate
      if (empty($parentValue)){
        $returnValue = $parentValue;
        $_SESSION["countOutstanding"] += 1;
      } else {
        $returnValue = date("d/m/Y", strtotime($parentValue));
      }
    } elseif ($parentKey == "RecordStatus") {
      // For RecordStatus skip output
      return;
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
  }

  public function endIteration() {
    // Add final summary row of total currently issued & total outstanding
    echo "<tr class='table-info'><td colspan='5'>"
        . "<b>Total issued to me: {$_SESSION["countIssued"]} "
        . "/ Outstanding: {$_SESSION["countOutstanding"]}</b>"
        . "</td></tr>";
    unset($_SESSION["countIssued"], $_SESSION["countOutstanding"]);
  }
}
