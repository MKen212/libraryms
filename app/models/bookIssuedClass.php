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
   * @return bool $result        True if Function success
   */
  public function addBookIssued($bookID, $userID, $issuedDate, $returnDueDate) {
    $sql = "INSERT INTO books_issued
    (BookID, UserID, IssuedDate, ReturnDueDate) VALUES
    ('$bookID', '$userID', '$issuedDate', '$returnDueDate')";
    $result = $this->conn->exec($sql);
    return $result;
  }

  /**
   * getBooksIssuedByUserID function - Retrieve books issued records based on User ID
   * @param int $userID     User ID
   * @return array $result  Returns all books issued records for $userID
   */
  public function getBooksIssuedByUserID($userID) {
    $sql = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.UserID = '$userID' ORDER BY books_issued.IssuedID DESC";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBooksIssuedByBookID function - Retrieve books issued records based on Book ID
   * @param int $bookID     Book ID
   * @return array $result  Returns all books issued records for $bookID
   */
  public function getBooksIssuedByBookID($bookID) {
    $sql = "SELECT books_issued.IssuedID, books_issued.BookID, books.Title, books_issued.UserID, users.UserName, books_issued.IssuedDate, books_issued.ReturnDueDate, books_issued.ReturnedDate FROM books_issued LEFT JOIN books ON books_issued.BookID = books.BookID LEFT JOIN users ON books_issued.UserID = users.UserID WHERE books_issued.BookID = '$bookID' ORDER BY books_issued.ReturnDueDate";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBooksOSByUserID function - Retrieve outstanding books issued records based on User ID
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
   * getBooksOSByBookID function - Retrieve outstanding books issued records based on Book ID
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