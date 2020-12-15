<?php  // Book Class
class Book {
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
   * addBook function - Add book record
   * @param string $title        Book Title
   * @param string $author       Book Author
   * @param string $publisher    Book Publisher
   * @param string $ISBN         Book ISBN Code
   * @param string $priceGBP     Book Price in GBP
   * @param int $quantity        Quantity of the Book Added
   * @param string $imgFilename  Filename for Book Image
   * @param date $addedDate      Date Book Added
   * @param int $userID          User ID who added book
   * @return int lastInsertID    Book ID of added book or False
   */
  public function addBook($title, $author, $publisher, $ISBN, $priceGBP, $quantity, $imgFilename, $addedDate, $userID) {
    $sql = "INSERT INTO books
    (Title, Author, Publisher, ISBN, PriceGBP, QtyTotal, QtyAvail, ImgFilename, AddedDate, UserID) VALUES
    ('$title', '$author', '$publisher', '$ISBN', '$priceGBP', '$quantity','$quantity', '$imgFilename', '$addedDate', '$userID')";
    $result = $this->conn->exec($sql);
    if ($result) {
      return ($this->conn->lastInsertId());
    } else {
      return false;
    }
  }

  /**
   * getBooksAll function - Retrieve ALL book records
   * @return array $result  Returns all book records
   */
  public function getBooksAll() {
    $sql = "SELECT books.BookID, books.ImgFilename, books.Title, books.Author, books.Publisher, books.ISBN, books.PriceGBP, books.QtyTotal, books.QtyAvail, books.AddedDate, users.Username, books.BookStatus FROM books LEFT JOIN users ON books.UserID = users.UserID";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBooksActive function - Retrieve all ACTIVE book records
   * @return array $result  Returns all active book records
   */
  public function getBooksActive() {
    $sql = "SELECT books.BookID, books.ImgFilename, books.Title, books.Author, books.Publisher, books.ISBN, books.PriceGBP, books.QtyTotal, books.QtyAvail, books.AddedDate, users.Username FROM books LEFT JOIN users ON books.UserID = users.UserID WHERE BookStatus = '1'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBooksByTitle function - Retrieve ACTIVE book records based on Title
   * @param string $title   Book Title
   * @return array $result  Returns ACTIVE book records with $title
   */
  public function getBooksByTitle($title) {
    $sql = "SELECT books.BookID, books.ImgFilename, books.Title, books.Author, books.Publisher, books.ISBN, books.PriceGBP, books.QtyTotal, books.QtyAvail, books.AddedDate, users.Username, books.BookStatus FROM books LEFT JOIN users ON books.UserID = users.UserID WHERE Title LIKE '%$title%' AND BookStatus = '1'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBookIDs function - Retrieve all ACTIVE book IDs (with Title)
   * @return array $result  Returns all active BookIDs (with Title)
   */
  public function getBookIDs() {
    $sql = "SELECT BookID, Title FROM books WHERE BookStatus = '1' ORDER BY Title";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getBookByID function - Retrieve book record based on ID
   * @param int    $bookID  Book ID
   * @return array $result  Returns book record for $bookID
   */
  public function getBookByID($bookID) {
    $sql = "SELECT BookID, ImgFilename, Title, Author, Publisher, ISBN, QtyAvail FROM books WHERE BookID = '$bookID'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetch();
    return $result;
  }

  /**
   * updateBookQtyAvail function - Update QtyAvail for $bookID
   * @param int $bookID       Book ID
   * @param int $qtyAvailChg  (+/-)Quantity to change in $QtyAvail
   * @return bool $result     Number of affected records if function success
   */
  public function updateBookQtyAvail($bookID, $qtyAvailChg) {
    $sql = "UPDATE books SET QtyAvail = QtyAvail + $qtyAvailChg WHERE BookID = $bookID";
    $result = $this->conn->exec($sql);
    return $result;
  }

  /**
   * updateBookStatus function - Update the BookStatus of a book
   * @param int $bookID      Book ID
   * @param int $bookStatus  Book Status Flag (0=Deleted / 1=Active)
   * @return bool $result    Number of affected records if function success
   */
  public function updateBookStatus($bookID, $bookStatus) {
    $sql = "UPDATE books SET BookStatus = '$bookStatus' WHERE BookID = '$bookID'";
    $result = $this->conn->exec($sql);
    return $result;
  }
}
?>