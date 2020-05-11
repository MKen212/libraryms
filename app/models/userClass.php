<?php  // User Class
class User {
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
   * registerUser function - Register a new user
   * @param string $username    User Name
   * @param string $password    User Password
   * @param string $firstName   User First Name
   * @param string $lastName    User Last Name
   * @param string $email       User Email Address
   * @param string $contactNo   User Contact Number
   * @return int lastInsertID   User ID of new user or False
   */
  public function registerUser($username, $password, $firstName, $lastName, $email, $contactNo) {
    // Check Username does not exist
    $sql = "SELECT UserID FROM users WHERE UserName = '$username'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $count = $statement->rowCount();
    if ($count == 0) {  // Username is unique
      $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
      $sqlInsUser = "INSERT INTO users
        (UserName, UserPassword, FirstName, LastName, Email, ContactNo) VALUES
        ('$username', '$passwordHash', '$firstName', '$lastName', '$email', '$contactNo')";
      $result = $this->conn->exec($sqlInsUser);
      return ($this->conn->lastInsertId());
    } else {  // Username is not unique
      $_SESSION["message"] = "User Name is already taken! Please try again.";
      return false;
    }
  }

  /**
   * login function - Check username & password & set Session
   * @param string $name      User Name
   * @param string $password  User Password
   * @return bool             True if Function success
   */
  public function login($username, $password) {
    $sql = "SELECT UserID, UserPassword, IsAdmin, UserStatus FROM users WHERE UserName = '$username'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $count = $statement->rowCount();
    if ($count != 1) {  // Username not found
      $_SESSION["message"] = "Incorrect User Name or Password entered!";
      return false;
    } else {
      $result = $statement->fetch();
      $passwordStatus = password_verify($password, $result["UserPassword"]);
      $userID = $result["UserID"];
      $userIsAdmin = $result["IsAdmin"];
      $userStatus = $result["UserStatus"];
      $result = NULL;
      if ($passwordStatus == true) {  // Correct Password Entered
        if ($userStatus == true) {  // User is approved
          $_SESSION["userLogin"] = true;
          $_SESSION["userIsAdmin"] = $userIsAdmin;
          $_SESSION["userID"] = $userID;
          $_SESSION["userName"] = $username;
          return true;
        } else {
          // User is unapproved
          $_SESSION["message"] = "Sorry - User not yet approved!";
          return false;
        }
      } else {
        // Password invalid
        $_SESSION["message"] = "Incorrect User Name or Password entered!";
        return false;
      }
    }
  }

  /**
   * logout function - Logout user
   * @return bool  True if function success
   */
  public function logout() {
    $_SESSION["message"] = "Thanks for using the LibraryMS.";
    $_SESSION["userLogin"] = false;
    return true;
  }

  /**
   * getUsersAll function - Retrieve ALL user records
   * @return array $result  Returns all user records
   */
  public function getUsersAll() {
    $sql = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo, IsAdmin, UserStatus FROM users";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getUserIDs function - Retrieve all Approved user IDs (with Username)
   * @return array $result  Returns all Approved UserIDs (with Username)
   */
  public function getUserIDs() {
    $sql = "SELECT UserID, UserName FROM users WHERE UserStatus = '1' ORDER BY UserName";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
    return $result;
  }

  /**
   * getUserByID function - Retrieve user record based on ID
   * @param int    $userID  User ID
   * @return array $result  Returns user record for $userID
   */
  public function getUserByID($userID) {
    $sql = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo FROM users WHERE UserID = '$userID'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetch();
    return $result;
  }

  /**
   * updateStatus function - Updates the UserStatus of a user
   * @param int $userID       User ID
   * @param bool $userStatus  User Status Flag (0=Unapproved /  1=Approved)
   * @return bool             True if function success
   */
  public function updateStatus($userID, $userStatus) {
    $sql = "UPDATE users SET UserStatus = '$userStatus' WHERE UserID = '$userID'";
    $result = $this->conn->exec($sql);
    return $result;
  }
}
?>