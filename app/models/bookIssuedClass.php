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
}
?>