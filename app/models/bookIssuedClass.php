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
   * getList function - Retrieve list of ALL books_issued records (optionally based on UserID and/or BookID and/or if Outstanding) from books_issued_view
   * @param int $userID        User ID (Optional)
   * @param int $bookID        Book ID (Optional)
   * @param book $outstanding  True/False if only include outstanding records (Optional)
   * @return array $result     Returns all/selected books_issued records (Descending ReturnDueDate Order) or False
   */
  public function getList($userID = null, $bookID = null, $outstanding = false) {
    try {
      if ($userID == null && $bookID == null && $outstanding == false) {  // Select ALL records
        $sql = "SELECT * FROM `books_issued_view` ORDER BY `ReturnDueDate` DESC";
      } else {
        // Build WHERE clause
        $whereClause = "";
        if (!empty($userID)) $whereClause .= "(`UserID` = '{$userID}')";
        if (!empty($bookID)) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`BookID` = '{$bookID}')";
        }
        if ($outstanding == true) {
          if (!empty($whereClause)) $whereClause .= " AND ";
          $whereClause .= "(`ReturnActualDate` IS NULL) AND (`RecordStatus` = '1')";
        }
        $sql = "SELECT * FROM `books_issued_view` WHERE {$whereClause} ORDER BY `ReturnDueDate` DESC";
      }
      //$stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      //$result = $stmt->fetchAll();
      //return $result;
      return $sql;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - BookIssued/getList Failed: {$err->getMessage()}");
      return false;
    }
  }

  

  // /**
  //  * getBooksIssuedByUserID function - List books issued records for User ID
  //  * @param int $userID     User ID (Optional)
  //  * @param int $bookID     Book ID (Optional)
  //  * @return array $result  Returns all/selected books_issued records (ReturnDueDate Order) or False
  //  */
  // public function getBooksIssuedByUserID($userID) {
  //   $sql = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.UserID = '$userID' ORDER BY books_issued.IssuedID DESC";
  //   $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
  //   $result = $statement->fetchAll();
  //   return $result;
  // }

  // /**
  //  * getBooksIssuedByBookID function - List books issued records for Book ID
  //  * @param int $bookID     Book ID
  //  * @return array $result  Returns all books issued records for $bookID
  //  */
  // public function getBooksIssuedByBookID($bookID) {
  //   $sql = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.BookID = '$bookID' ORDER BY books_issued.ReturnDueDate";
  //   $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
  //   $result = $statement->fetchAll();
  //   return $result;
  // }

  /**
   * getBooksOSByUserID function - List outstanding books issued for User ID
   * @param int $userID     User ID
   * @return array $result  Returns all outstanding books issued records for $userID
   */
  public function getBooksOSByUserID($userID) {
    $sql = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.UserID = '$userID' AND books_issued.ReturnedDate IS NULL ORDER BY books.Title, books_issued.IssuedID";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBooksOSByBookID function - List outstanding books issued for Book ID
   * @param int $bookID     Book ID
   * @return array $result  Returns all outstanding books issued records for $bookID
   */
  public function getBooksOSByBookID($bookID) {
    $sql = "SELECT books_issued.IssuedID, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.BookID = '$bookID' AND books_issued.ReturnedDate IS NULL ORDER BY books_issued.ReturnDueDate";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * returnBookIssued function - Return issued book
   * @param int $issuedID       Issued ID
   * @param date $returnedDate  Date Book Returned
   * @return bool $result       True if function success
   */
  public function returnBookIssued($issuedID, $returnedDate) {
    $sql = "UPDATE books_issued SET ReturnedDate = '$returnedDate' WHERE IssuedID = '$issuedID'";
    $result = $this->conn->exec($sql);
    return $result; 
  }
}
?>