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

  public function addBook($title, $author, $publisher, $ISBN, $priceGBP, $imgFilename, $dateAdded, $userID) {
    $sqlAddBook = "INSERT INTO books
    (Title, Author, Publisher, ISBN, PriceGBP, ImgFilename, DateAdded, UserID) VALUES
    ('$title', '$author', '$publisher', '$ISBN', '$priceGBP', '$imgFilename', '$dateAdded', '$userID')";
    $resAddBook = $this->conn->exec($sqlAddBook);
    return $resAddBook;
  }
}

?>