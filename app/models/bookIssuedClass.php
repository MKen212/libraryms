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
      echo "Database Connection Failed: " . $err->getMessage() . "<br />";
    }
  }

  /**
   * addBookIssued function - Add record showing Book Issued to User
   * @param int $bookID          Book ID
   * @param int $userID          User ID
   * @param date $issuedDate     Date Book Issued to User
   * @param data $returnDueDate  Date Book Due to be returned
   * @return int                 True if Function success
   */
  public function addBookIssued($bookID, $userID, $issuedDate, $returnDueDate) {
    $sqlAddBookIssued = "INSERT INTO books_issued
    (BookID, UserID, IssuedDate, ReturnDueDate) VALUES
    ('$bookID', '$userID', '$issuedDate', '$returnDueDate')";
    $resAddBookIssued = $this->conn->exec($sqlAddBookIssued);
    return $resAddBookIssued;
  }

  /**
   * getBooksIssuedByUserID function - Retrieve books issued records based on User ID
   * @param int $userID                   User ID
   * @return array $resGetBksIssByUserID  Returns all books issued records for $userID
   */
  public function getBooksIssuedByUserID($userID) {
    $sqlGetBksIssByUserID = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued INNER JOIN books ON books_issued.BookID = books.BookID INNER JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.UserID = '$userID' ORDER BY books_issued.IssuedID DESC";
    $stmtGetBksIssByUserID = $this->conn->query($sqlGetBksIssByUserID, PDO::FETCH_ASSOC);
    $resGetBksIssByUserID = $stmtGetBksIssByUserID->fetchAll();
    return $resGetBksIssByUserID;
  }

  /**
   * getBooksOSByUserID function - Retrieve outstanding books issued records based on User ID
   * @param int $userID                  User ID
   * @return array $resGetBksOSByUserID  Returns all outstanding books issued records for $userID
   */
  public function getBooksOSByUserID($userID) {
    $sqlGetBksOSByUserID = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued INNER JOIN books ON books_issued.BookID = books.BookID INNER JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.UserID = '$userID' AND books_issued.ReturnedDate IS NULL ORDER BY books.Title";
    $stmtGetBksOSByUserID = $this->conn->query($sqlGetBksOSByUserID, PDO::FETCH_ASSOC);
    $resGetBksOSByUserID = $stmtGetBksOSByUserID->fetchAll();
    return $resGetBksOSByUserID;
  }

  /**
   * returnBookIssued function - Return issued book
   * @param int $issuedID       Issued ID
   * @param date $returnedDate  Date Book Returned
   * @return bool               True if function success
   */
  public function returnBookIssued($issuedID, $returnedDate) {
    $sqlReturnBookIssued = "UPDATE books_issued SET ReturnedDate = '$returnedDate' WHERE IssuedID = '$issuedID'";
    $resReturnBookIssued = $this->conn->exec($sqlReturnBookIssued);
    return $resReturnBookIssued; 
  }
}
?>