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
   * @param string $title      Book Title
   * @param string $author     Book Author
   * @param string $publisher  Book Publisher
   * @param string $ISBN       Book ISBN Code
   * @param string $priceGBP   Book Price in GBP
   * @param int $quantity      Quantity of the Book Added
   * @param date $addedDate    Date Book Added
   * @param int $userID        User ID who added book
   * @return int               Book ID of added book
   */
  public function addBook($title, $author, $publisher, $ISBN, $priceGBP, $quantity, $imgFilename, $addedDate, $userID) {
    $sql = "INSERT INTO books
    (Title, Author, Publisher, ISBN, PriceGBP, QtyTotal, QtyAvail, ImgFilename, AddedDate, UserID) VALUES
    ('$title', '$author', '$publisher', '$ISBN', '$priceGBP', '$quantity','$quantity', '$imgFilename', '$addedDate', '$userID')";
    $result = $this->conn->exec($sql);
    if ($result) {
      return ($this->conn->lastInsertId());
    } else {
      return $result;
    }
  }

  /**
   * getBooksAll function - Retrieve ALL book records
   * @return array $resGetBooksAll  Returns all book records
   */
  public function getBooksAll() {
    $sqlGetBooksAll = "SELECT books.BookID, books.ImgFilename, books.Title, books.Author, books.Publisher, books.ISBN, books.PriceGBP, books.QtyTotal, books.QtyAvail, books.AddedDate, users.Username, books.BookStatus FROM books LEFT JOIN users ON books.UserID = users.UserID";
    $stmtGetBooksAll = $this->conn->query($sqlGetBooksAll, PDO::FETCH_ASSOC);
    $resGetBooksAll = $stmtGetBooksAll->fetchAll();
    return $resGetBooksAll;
  }

  /**
   * getBookIDs function - Retrieve all active book IDs (with Title)
   * @return array $resGetBookIDs  Returns all active BookIDs (with Title)
   */
  public function getBookIDs() {
    $sqlGetBookIDs = "SELECT BookID, Title FROM books WHERE BookStatus = '0' ORDER BY Title";
    $stmtGetBookIDs = $this->conn->query($sqlGetBookIDs, PDO::FETCH_ASSOC);
    $resGetBookIDs = $stmtGetBookIDs->fetchAll();
    return $resGetBookIDs;
  }

  /**
   * getBookByID function - Retrieve book record based on ID
   * @param int    $bookID          Book ID
   * @return array $resGetBookByID  Returns book record for $bookID
   */
  public function getBookByID($bookID) {
    $sqlGetBookByID = "SELECT BookID, ImgFilename, Title, Author, Publisher, ISBN, QtyAvail FROM books WHERE BookID = '$bookID'";
    $stmtGetBookByID = $this->conn->query($sqlGetBookByID, PDO::FETCH_ASSOC);
    $resGetBookByID = $stmtGetBookByID->fetch();
    return $resGetBookByID;
  }

  /**
   * getBooksByTitle function - Retrieve book records based on Title
   * @param string $title               Book Title
   * @return array $resGetBooksByTitle  Returns all book records with $title
   */
  public function getBooksByTitle($title) {
    $sqlGetBooksByTitle = "SELECT books.BookID, books.ImgFilename, books.Title, books.Author, books.Publisher, books.ISBN, books.PriceGBP, books.QtyTotal, books.QtyAvail, books.AddedDate, users.Username, books.BookStatus FROM books LEFT JOIN users ON books.UserID = users.UserID WHERE Title LIKE '%$title%'";
    $stmtGetBooksByTitle = $this->conn->query($sqlGetBooksByTitle, PDO::FETCH_ASSOC);
    $resGetBooksByTitle = $stmtGetBooksByTitle->fetchAll();
    return $resGetBooksByTitle;
  }

  /**
   * updateBookQtyAvail function - Update QtyAvail for $bookID
   * @param int $bookID       Book ID
   * @param int $qtyAvailChg  (+/-)Quantity to change in $QtyAvail
   * @return bool             True if function success
   */
  public function updateBookQtyAvail($bookID, $qtyAvailChg) {
    $sqlUpdBookQtyAvail = "UPDATE books SET QtyAvail = QtyAvail + $qtyAvailChg WHERE BookID = $bookID";
    $resUpdBookQtyAvail = $this->conn->exec($sqlUpdBookQtyAvail);
    return $resUpdBookQtyAvail;
  }

  /**
   * updateBookStatus function - Update the BookStatus of a book
   * @param int $bookID      Book ID
   * @param int $bookStatus  Book Status Flag (0=Active / 1=Deleted)
   * @return bool $result    True if function success
   */
  public function updateBookStatus($bookID, $bookStatus) {
    $sql = "UPDATE books SET BookStatus = '$bookStatus' WHERE BookID = '$bookID'";
    $result = $this->conn->exec($sql);
    return $result;
  }
}
?>