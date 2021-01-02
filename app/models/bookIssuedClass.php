<?php  // Book Issued Class
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
   * @return int $newIssuedID    Issued ID of added record or False
   */
  public function add($bookID, $userID, $issuedDate, $returnDueDate) {
    try {
      $sql = "INSERT INTO `books_issued` (`BookID`, `UserID`, `IssuedDate`, `ReturnDueDate`) VALUES ('{$bookID}', '{$userID}', '{$issuedDate}', '{$returnDueDate}')";
      $this->conn->exec($sql);
      $newIssuedID = $this->conn->lastInsertId();
      $_SESSION["message"] = msgPrep("success", "Book ID '{$bookID}' successfully issued to User ID '{$userID}'.");
      return $newIssuedID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/add Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getListByUser function - Retrieve list of books_issued records for UserID (optionally by RecordStatus and/or if Outstanding) from books_issued_view
   * @param int $userID        User ID
   * @param int $recordStatus  Record Status (Optional)
   * @param bool $outstanding  True/False if only include outstanding records (Optional)
   * @return array $result     Returns all/selected books_issued records (IssuedDate Descending Order) or False
   */
  public function getListByUser($userID, $recordStatus = null, $outstanding = false) {
    try {
      if ($recordStatus == null && $outstanding == false) {  // Select ALL records
        $sql = "SELECT `IssuedID`, `BookID`, `Title`, `IssuedDate`, `ReturnDueDate`, `ReturnActualDate`, `RecordStatus` FROM `books_issued_view` WHERE (`UserID` = '{$userID}') ORDER BY `IssuedDate` DESC";
      } else {
        // Build WHERE clause
        $whereClause = "(`UserID` = '{$userID}')";
        if (!empty($recordStatus)) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`RecordStatus` = '{$recordStatus}')";
        }
        if ($outstanding == true) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`ReturnActualDate` IS NULL)";
        }
        $sql = "SELECT `IssuedID`, `BookID`, `Title`, `IssuedDate`, `ReturnDueDate`, `ReturnActualDate`, `RecordStatus` FROM `books_issued_view` WHERE {$whereClause} ORDER BY `IssuedDate` DESC";
      }
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getListByUser Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getListByBook function - Retrieve list of books_issued records for BookID (optionally by RecordStatus and/or if Outstanding) from books_issued_view
   * @param int $bookID        Book ID
   * @param int $recordStatus  Record Status (Optional)
   * @param bool $outstanding  True/False if only include outstanding records (Optional)
   * @return array $result     Returns all/selected books_issued records (ReturnDueDate Order) or False
   */
  public function getListByBook($bookID, $recordStatus = null, $outstanding = false) {
    try {
      if ($recordStatus == null && $outstanding == false) {  // Select ALL records
        $sql = "SELECT `IssuedID`, `UserID`, `Username`, `IssuedDate`, `ReturnDueDate` FROM `books_issued_view` WHERE (`BookID` = '{$bookID}') ORDER BY `ReturnDueDate`";
      } else {
        // Build WHERE clause
        $whereClause = "(`BookID` = '{$bookID}')";
        if (!empty($recordStatus)) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`RecordStatus` = '{$recordStatus}')";
        }
        if ($outstanding == true) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`ReturnActualDate` IS NULL)";
        }
        $sql = "SELECT `IssuedID`, `UserID`, `Username`, `IssuedDate`, `ReturnDueDate` FROM `books_issued_view` WHERE {$whereClause} ORDER BY `ReturnDueDate`";
      }
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getListByBook Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * returnBook function - Return issued book
   * @param int $issuedID       Issued ID
   * @param date $returnedDate  Date Book Returned
   * @return int $result        Number of records updated (=1) or False
   */
  public function returnBook($issuedID, $returnedDate) {
    try {
      $sql = "UPDATE `books_issued` SET `ReturnActualDate` = '{$returnedDate}' WHERE `IssuedID` = '{$issuedID}'";
      $result = $this->conn->exec($sql);
      return $result; 
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/returnBook Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * updateRecordStatus function - Update the RecordStatus of a books_issued record
   * @param int $issuedID      Issued ID
   * @param int $recordStatus  New RecordStatus for Book
   * @return int $result       Number of records updated (=1) or False
   */
  public function updateRecordStatus($issuedID, $recordStatus) {
    try {
      $sql = "UPDATE `books_issued` SET `RecordStatus` = '{$recordStatus}' WHERE `IssuedID` = '{$issuedID}'";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/updateRecordStatus Failed: {$err->getMessage()}");
    }
  }
}
?>