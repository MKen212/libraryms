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
      $_SESSION["message"] = msgPrep("danger", "Error - Book/DB Connection Failed: {$err->getMessage()}");
    }
  }

  /**
   * exists function - Check if Book Title already exists in DB
   * @param string $title  Book Title
   * @return int $bookID   Book ID of record with selected Title or False
   */
  public function exists($title) {
    try {
      $sql = "SELECT `BookID` FROM `books` WHERE `Title` = '{$title}'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $bookID = $stmt->fetchColumn();
      return $bookID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/exists Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * add function - Add book record
   * @param string $title        Book Title
   * @param string $author       Book Author
   * @param string $publisher    Book Publisher
   * @param string $ISBN         Book ISBN Code
   * @param string $price        Book Price
   * @param int $quantity        Quantity of the Book Added
   * @param string $imgFilename  Filename for Book Image
   * @return int newBookID       Book ID of added book or False
   */
  public function add($title, $author, $publisher, $ISBN, $price, $quantity, $imgFilename) {
    try {
      // Check Book Title does not already exist
      $exists = $this->exists($title);
      if (!empty($exists)) {  // Title is not unique
        $_SESSION["message"] = msgPrep("danger", "Error - Book Title '{$title}' is already in use! Please try again.");
        return false;
      } else {  // Insert Book Record
        $addedUserID = $_SESSION["userID"];
        $sql = "INSERT INTO `books` (`Title`, `Author`, `Publisher`, `ISBN`, `Price`, `QtyTotal`, `QtyAvail`, `ImgFilename`, `AddedUserID`) VALUES ('{$title}', '{$author}', '{$publisher}', '{$ISBN}', '{$price}', '{$quantity}','{$quantity}', '{$imgFilename}', '{$addedUserID}')";
        $this->conn->exec($sql);
        $newBookID = $this->conn->lastInsertId();
        $_SESSION["message"] = "Book Title '{$title}' added successfully as Book ID '{$newBookID}'.";
        return $newBookID;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/add Failed: {$err->getMessage()}");
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