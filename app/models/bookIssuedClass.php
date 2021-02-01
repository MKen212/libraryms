<?php
/**
 * BookIssued Class - Used to access the books_issued table and process SQL
 * queries
 */

namespace LibraryMS;

use PDO, PDOException;

class BookIssued {
  private $conn;  // PDO database connection object

  /**
   * Construct function - Create the database connection object
   */
  public function __construct() {
    try {
      $connString = "mysql:host=" . DBSERVER["servername"] . ";dbname=" . DBSERVER["database"];
      $this->conn = new PDO($connString, DBSERVER["username"], DBSERVER["password"]);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/DB Connection Failed: {$err->getMessage()}");
    }
  }

  /**
   * add function - Add record showing Book Issued to User
   * @param int $bookID          Book ID
   * @param int $userID          User ID
   * @param date $issuedDate     Date Book Issued to User
   * @param date $returnDueDate  Date Book Due to be returned
   * @return int|null            Issued ID of added record or null
   */
  public function add($bookID, $userID, $issuedDate, $returnDueDate) {
    try {
      $sql = "INSERT INTO `books_issued` (`BookID`, `UserID`, `IssuedDate`,
                          `ReturnDueDate`)
              VALUES ({$bookID}, {$userID}, '{$issuedDate}', '{$returnDueDate}')";
      $this->conn->exec($sql);
      $newIssuedID = $this->conn->lastInsertId();
      $_SESSION["message"] = msgPrep("success", "Book ID '{$bookID}' successfully issued to User ID '{$userID}'.");
      return $newIssuedID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/add Failed: {$err->getMessage()}");
    }
  }

  /**
   * getList function - Retrieve list of ALL books_issued records (optionally based on
   *                    specific username or title) from books_issued_view
   * @param string $schString  Book Title or Username (Optional)
   * @return array|null        Returns all/selected books_issued records (ReturnDueDate
   *                           Descending Order) or null
   */
  public function getList($schString = null) {
    try {
      // Build WHERE clause
      $whereClause = null;
      if (!empty($schString)) {
        $whereClause = "WHERE `Title` LIKE '%{$schString}%' "
                     . "OR `Username` LIKE '%{$schString}%'";
      }
      // Build SQL & Execute
      $sql = "SELECT *
              FROM `books_issued_view`
              {$whereClause}
              ORDER BY `ReturnDueDate` DESC";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getList Failed: {$err->getMessage()}");
    }
  }

  /**
   * getListByUser function - Retrieve list of books_issued records for UserID
   * (optionally by RecordStatus and/or if Outstanding) from books_issued_view
   * @param int $userID        User ID
   * @param int $recordStatus  Record Status (Optional)
   * @param bool $outstanding  True/False to only include outstanding records (Optional)
   * @return array|null        Returns all/selected books_issued records (ReturnDueDate
   *                           Descending Order) or null
   */
  public function getListByUser($userID, $recordStatus = null, $outstanding = false) {
    try {
      // Build WHERE clause
      $whereClause = "WHERE `UserID` = {$userID} ";
      if (!empty($recordStatus)) {
        $whereClause .= "AND `RecordStatus` = {$recordStatus} ";
      }
      if ($outstanding == true) {
        $whereClause .= "AND `ReturnActualDate` IS NULL ";
      }
      // Build SQL & Execute
      $sql = "SELECT `ReturnDueDate`, `ReturnActualDate`, `IssuedDate`, `Title`
              FROM `books_issued_view`
              {$whereClause}
              ORDER BY `ReturnDueDate` DESC";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getListByUser Failed: {$err->getMessage()}");
    }
  }

  /**
   * getListByBook function - Retrieve list of books_issued records for BookID
   * (optionally by RecordStatus and/or if Outstanding) from books_issued_view
   * @param int $bookID        Book ID
   * @param int $recordStatus  Record Status (Optional)
   * @param bool $outstanding  True/False if only include outstanding records (Optional)
   * @return array|null        Returns all/selected books_issued records (ReturnDueDate
   *                           Descending Order) or null
   */
  public function getListByBook($bookID, $recordStatus = null, $outstanding = false) {
    try {
      // Build WHERE clause
      $whereClause = "WHERE `BookID` = {$bookID} ";
      if (!empty($recordStatus)) {
        $whereClause .= "AND `RecordStatus` = {$recordStatus} ";
      }
      if ($outstanding == true) {
        $whereClause .= "AND `ReturnActualDate` IS NULL ";
      }
      // Build SQL & Execute
      $sql = "SELECT `ReturnDueDate`, `IssuedDate`, `Username`
              FROM `books_issued_view`
              {$whereClause}
              ORDER BY `ReturnDueDate`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getListByBook Failed: {$err->getMessage()}");
    }
  }

  /**
   * returnBook function - Return issued book
   * @param int $issuedID       Issued ID of record to return
   * @param date $returnedDate  Date Book Returned
   * @return int|null           Number of records updated (=1) or null
   */
  public function returnBook($issuedID, $returnedDate) {
    try {
      $sql = "UPDATE `books_issued`
              SET `ReturnActualDate` = '{$returnedDate}'
              WHERE `IssuedID` = {$issuedID}";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/returnBook Failed: {$err->getMessage()}");
    }
  }

  /**
   * updateRecordStatus function - Update the RecordStatus of a books_issued record
   * @param int $issuedID      Issued ID of record to update
   * @param int $recordStatus  New RecordStatus for Book
   * @return int|null          Number of records updated (=1) or null
   */
  public function updateRecordStatus($issuedID, $recordStatus) {
    try {
      $sql = "UPDATE `books_issued`
              SET `RecordStatus` = {$recordStatus}
              WHERE `IssuedID` = {$issuedID}";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/updateRecordStatus Failed: {$err->getMessage()}");
    }
  }
}
