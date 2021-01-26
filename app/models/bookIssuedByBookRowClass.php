<?php
/**
 * BookIssuedByBookRow Class - Used to extend the RecursiveIteratorIterator to display
 * each row of a BookIssued/getListByBook query in table format
 */

class BookIssuedByBookRow extends RecursiveIteratorIterator {
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
    } else {
      // For all others output original value
      $returnValue = $parentValue;
    }
    return "<td>{$returnValue}</td>";
  }

  public function beginIteration() {
    $_SESSION["countIssued"] = 0;
  }

  public function beginChildren() {
    $_SESSION["countIssued"] += 1;
    echo "<tr>";
  }

  public function endChildren() {
    echo "</tr>";
  }

  public function endIteration() {
    // Add final summary row of total currently issued
    echo "<tr class='table-info'><td colspan='3'>"
       . "<b>Total currently issued: {$_SESSION["countIssued"]}</b>"
       . "</td></tr>";
    unset($_SESSION["countIssued"]);
  }
}
