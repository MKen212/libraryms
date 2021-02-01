<?php
/**
 * Book class - Used to access the books table and process SQL queries
 */

namespace LibraryMS;

use PDO, PDOException;

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
   * @return int|null      Book ID of record with selected Title or null
   */
  public function exists($title) {
    try {
      $sql = "SELECT `BookID`
              FROM `books`
              WHERE `Title` = '{$title}'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $bookID = $stmt->fetchColumn();
      return $bookID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/exists Failed: {$err->getMessage()}");
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
   * @return int|null            Book ID of added record or null
   */
  public function add($title, $author, $publisher, $ISBN, $price, $quantity, $imgFilename) {
    try {
      // Check Book Title does not already exist
      $exists = $this->exists($title);
      if (!empty($exists)) {  // Title is not unique
        $_SESSION["message"] = msgPrep("danger", "Error - Book Title '{$title}' is already in use! Please try again.");
        return null;
      } else {  // Insert Book Record
        $addedUserID = $_SESSION["userID"];
        $sql = "INSERT INTO `books` (`Title`, `Author`, `Publisher`, `ISBN`, `Price`,
                            `QtyTotal`, `QtyAvail`, `ImgFilename`, `AddedUserID`)
                VALUES ('{$title}', '{$author}', '{$publisher}', '{$ISBN}', {$price},
                         {$quantity}, {$quantity}, '{$imgFilename}', {$addedUserID})";
        $this->conn->exec($sql);
        $newBookID = $this->conn->lastInsertId();
        $_SESSION["message"] = "Book '{$title}' added successfully as Book ID '{$newBookID}'.";
        return $newBookID;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/add Failed: {$err->getMessage()}");
    }
  }

  /**
   * getDisplay function - Retrieve list of ACTIVE book records (optionally based on title)
   * @param string $title  Book Title (Optional)
   * @return array|null    Returns all/selected ACTIVE book records (Title order) or null
   */
  public function getDisplay($title = null) {
    try {
      // Build WHERE clause
      $whereClause = "WHERE `RecordStatus` = 1 ";
      if (!empty($title)) {
        $whereClause .= "AND `Title` LIKE '%{$title}%' ";
      }
      // Build SQL & Execute
      $sql = "SELECT `BookID`, `ImgFilename`, `Title`, `Author`, `Publisher`, `ISBN`,
                     `Price`, `QtyTotal`, `QtyAvail`
              FROM `books`
              {$whereClause}
              ORDER BY `Title`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/getDisplay Failed: {$err->getMessage()}");
    }
  }

  /**
   * getList function - Retrieve list of ALL book records (optionally based on title)
   * @param string $title  Book Title (Optional)
   * @return array|null    Returns all/selected book records (Title order) or null
   */
  public function getList($title = null) {
    try {
      // Build WHERE clause
      $whereClause = null;
      if (!empty($title)) {
        $whereClause = "WHERE `Title` LIKE '%{$title}%' ";
      }
      // Build SQL & Execute
      $sql = "SELECT `BookID`, `Title`, `Author`, `Publisher`, `ISBN`, `Price`,
                     `QtyTotal`, `QtyAvail`, `RecordStatus`
              FROM `books`
              {$whereClause}
              ORDER BY `Title`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/getList Failed: {$err->getMessage()}");
    }
  }

  /**
   * getBookIDs function - Retrieve all Active Book IDs with Title
   * @return array|null  Returns BookID and Title of all Active records or null
   */
  public function getBookIDs() {
    try {
      $sql = "SELECT `BookID`, `Title`
              FROM `books`
              WHERE `RecordStatus` = 1
              ORDER BY `Title`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/getBookIDs Failed: {$err->getMessage()}");
    }
  }

  /**
   * getRecord function - Retrieve book record based on ID
   * @param int $bookID  Book ID of required record
   * @return array|null  Returns book record for $bookID or null
   */
  public function getRecord($bookID) {
    try {
      $sql = "SELECT *
              FROM `books`
              WHERE `BookID` = {$bookID}";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetch();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/getRecord Failed: {$err->getMessage()}");
    }
  }

  /**
   * updateRecord function - Updates an existing Book record
   * @param int $bookID          Book ID of record to update
   * @param string $title        Book Title
   * @param string $author       Book Author
   * @param string $publisher    Book Publisher
   * @param string $ISBN         Book ISBN Code
   * @param string $price        Book Price
   * @param int $qtyTotal        Total Quantity
   * @param int $qtyAvail        Available Quantity
   * @param string $imgFilename  Filename for Book Image
   * @return int|null            Number of records updated (=1) or null
   */
  public function updateRecord ($bookID, $title, $author, $publisher, $ISBN, $price, $qtyTotal, $qtyAvail, $imgFilename) {
    try {
      // Check update title does not already exist (other than in current record)
      $exists = $this->exists($title);
      if (!empty($exists) && $exists != $bookID) {  // Book Title is NOT unique
        $_SESSION["message"] = msgPrep("danger", "Error - Book Title '{$title}' is already in use! Please try again.");
        return null;
      } else {  // Update Book Record
        $sql = "UPDATE `books`
                SET `Title` = '{$title}',
                    `Author` = '{$author}',
                    `Publisher` = '{$publisher}',
                    `ISBN` = '{$ISBN}',
                    `Price` = {$price},
                    `QtyTotal` = {$qtyTotal},
                    `QtyAvail` = {$qtyAvail},
                    `ImgFilename` = '{$imgFilename}'
                WHERE `BookID` = {$bookID}";
        $result = $this->conn->exec($sql);
        if ($result == 0) {  // No Changes made
          $_SESSION["message"] = msgPrep("warning", "Warning - No changes made to Book ID '{$bookID}'.");
        } elseif ($result == 1) {  // Only 1 record should have been updated
          $_SESSION["message"] = "Update of Book ID: '{$bookID}' was successful.";
        } else {
          throw new PDOException("Update unsuccessful or multiple records updated.");
        }
        return $result;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/updateRecord Failed: {$err->getMessage()}");
    }
  }

  /**
   * updateBookQtyAvail function - Update QtyAvail for an existing book
   * @param int $bookID       Book ID of record to update
   * @param int $qtyAvailChg  (+/-)Quantity to change
   * @return int|null         Number of records updated (=1) or null
   */
  public function updateBookQtyAvail($bookID, $qtyAvailChg) {
    try {
      $sql = "UPDATE `books`
              SET `QtyAvail` = `QtyAvail` + {$qtyAvailChg}
              WHERE `BookID` = {$bookID}";
      $result = $this->conn->exec($sql);
      if ($result == 0) {  // No Changes made
        $_SESSION["message"] = msgPrep("warning", "Warning - No changes made to QtyAvail for Book ID '{$bookID}'.");
      } elseif ($result != 1) {  // Only 1 record should have been updated
        throw new PDOException("Update unsuccessful or multiple records updated.");
      }
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/updateBookQtyAvail Failed: {$err->getMessage()}");
    }
  }

  /**
   * updateRecordStatus function - Update the RecordStatus for an existing book
   * @param int $bookID        Book ID of record to update
   * @param int $recordStatus  New RecordStatus for Book
   * @return int|null          Number of records updated (=1) or null
   */
  public function updateRecordStatus($bookID, $recordStatus) {
    try {
      $sql = "UPDATE `books`
              SET `RecordStatus` = {$recordStatus}
              WHERE `BookID` = {$bookID}";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Book/updateRecordStatus Failed: {$err->getMessage()}");
    }
  }
}
