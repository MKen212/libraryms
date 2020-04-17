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
   * @return bool               True if Function success
   */
  public function registerUser($username, $password, $firstName, $lastName, $email, $contactNo) {
    $sqlChkUser = "SELECT UserID FROM users WHERE UserName = '$username'";
    $stmtChkUser = $this->conn->query($sqlChkUser, PDO::FETCH_ASSOC);
    $countChkUser = $stmtChkUser->rowCount();
    if ($countChkUser == 0) {
      $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
      $sqlInsUser = "INSERT INTO users
        (UserName, UserPassword, FirstName, LastName, Email, ContactNo) VALUES
        ('$username', '$passwordHash', '$firstName', '$lastName', '$email', '$contactNo')";
      $resultInsUser = $this->conn->exec($sqlInsUser);
      return $resultInsUser;
    } else {
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
    $sqlChkLogin = "SELECT UserID, UserPassword, IsAdmin, UserStatus FROM users WHERE UserName = '$username'";
    $stmtChkLogin = $this->conn->query($sqlChkLogin, PDO::FETCH_ASSOC);
    $countChkLogin = $stmtChkLogin->rowCount();
    if ($countChkLogin != 1) {
      // Username not found
      $_SESSION["message"] = "Incorrect User Name or Password entered!";
      return false;
    } else {
      $resultChkLogin = $stmtChkLogin->fetch();
      $passwordStatus = password_verify($password, $resultChkLogin["UserPassword"]);
      $userID = $resultChkLogin["UserID"];
      $userIsAdmin = $resultChkLogin["IsAdmin"];
      $userStatus = $resultChkLogin["UserStatus"];
      $resultChkLogin = null;
      if ($passwordStatus == true) {
        if ($userStatus == true) {
          $_SESSION["userLogin"] = true;
          $_SESSION["userIsAdmin"] = $userIsAdmin;
          $_SESSION["userID"] = $userID;
          $_SESSION["userName"] = $username;
          return true;
        } else {
          // User Status False
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
    $_SESSION["message"] = "Thanks for using privnet.";
    $_SESSION["userLogin"] = false;
    return true;
  }

  /**
   * getUsers function - Retrieve all user records
   * @return array  $resultGetUsers   Returns all user records
   */
  public function getUsers() {
    $sqlGetUsers = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo, IsAdmin, UserStatus FROM users";
    $stmtGetUsers = $this->conn->query($sqlGetUsers, PDO::FETCH_ASSOC);
    $resultGetUsers = $stmtGetUsers->fetchAll();
    return $resultGetUsers;
  }

  /**
   * updateStatus function - Updates the UserStatus of a user
   * @param int $userID       User ID
   * @param bool $userStatus  True if User Approved / False if User Unapproved
   * @return bool             True if function success
   */
  public function updateStatus($userID, $userStatus) {
    $sqlUpdateStatus = "UPDATE users SET UserStatus = '$userStatus' WHERE UserID = '$userID'";
    $resultUpdateStatus = $this->conn->exec($sqlUpdateStatus);
    return $resultUpdateStatus;
  }

}
?>