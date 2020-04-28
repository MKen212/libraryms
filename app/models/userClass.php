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
    $cntChkUser = $stmtChkUser->rowCount();
    if ($cntChkUser == 0) {
      $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
      $sqlInsUser = "INSERT INTO users
        (UserName, UserPassword, FirstName, LastName, Email, ContactNo) VALUES
        ('$username', '$passwordHash', '$firstName', '$lastName', '$email', '$contactNo')";
      $resInsUser = $this->conn->exec($sqlInsUser);
      return $resInsUser;
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
    $cntChkLogin = $stmtChkLogin->rowCount();
    if ($cntChkLogin != 1) {
      // Username not found
      $_SESSION["message"] = "Incorrect User Name or Password entered!";
      return false;
    } else {
      $resChkLogin = $stmtChkLogin->fetch();
      $passwordStatus = password_verify($password, $resChkLogin["UserPassword"]);
      $userID = $resChkLogin["UserID"];
      $userIsAdmin = $resChkLogin["IsAdmin"];
      $userStatus = $resChkLogin["UserStatus"];
      $resChkLogin = NULL;
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
    $_SESSION["message"] = "Thanks for using the LibraryMS.";
    $_SESSION["userLogin"] = false;
    return true;
  }

  /**
   * getUsersAll function - Retrieve all user records
   * @return array $resultGetUsersAll  Returns all user records
   */
  public function getUsersAll() {
    $sqlGetUsersAll = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo, IsAdmin, UserStatus FROM users";
    $stmtGetUsersAll = $this->conn->query($sqlGetUsersAll, PDO::FETCH_ASSOC);
    $resGetUsersAll = $stmtGetUsersAll->fetchAll();
    return $resGetUsersAll;
  }

  /**
   * getUserIDs function - Retrieve all user IDs (with Username)
   * @return array $resultGetUserIDs  Returns all UserIDs (with Username)
   */
  public function getUserIDs() {
    $sqlGetUserIDs = "SELECT UserID, UserName FROM users ORDER BY UserName";
    $stmtGetUserIDs = $this->conn->query($sqlGetUserIDs, PDO::FETCH_ASSOC);
    $resGetUserIDs = $stmtGetUserIDs->fetchAll();
    return $resGetUserIDs;
  }

  /**
   * getUserByID function - Retrieve user record based on ID
   * @param int    $userID             User ID
   * @return array $resultGetUserByID  Returns user record for $userID
   */
  public function getUserByID($userID) {
    $sqlGetUserByID = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo FROM users WHERE UserID = '$userID'";
    $stmtGetUserByID = $this->conn->query($sqlGetUserByID, PDO::FETCH_ASSOC);
    $resGetUserByID = $stmtGetUserByID->fetch();
    return $resGetUserByID;
  }

  /**
   * updateStatus function - Updates the UserStatus of a user
   * @param int $userID       User ID
   * @param bool $userStatus  True if User Approved / False if User Unapproved
   * @return bool             True if function success
   */
  public function updateStatus($userID, $userStatus) {
    $sqlUpdateStatus = "UPDATE users SET UserStatus = '$userStatus' WHERE UserID = '$userID'";
    $resUpdateStatus = $this->conn->exec($sqlUpdateStatus);
    return $resUpdateStatus;
  }
}
?>