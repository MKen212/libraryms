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
      $_SESSION["message"] = msgPrep("danger", "Error - User/DB Connection Failed: {$err->getMessage()}");
    }
  }

  /**
   * exists function - Check if Username already exists in DB
   * @param string $username  Username
   * @return int $userID      User ID of record with selected Name or False
   */
  public function exists($username) {
    try {
      $sql = "SELECT `UserID` FROM `users` WHERE `Username` = '{$username}'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $userID = $stmt->fetchColumn();
      return $userID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/exists Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * register function - Register a new user
   * @param string $username   Username
   * @param string $password   User Password
   * @param string $firstName  User First Name
   * @param string $lastName   User Last Name
   * @param string $email      User Email Address
   * @param string $contactNo  User Contact Number
   * @param int $isAdmin       User is Admin (Optional)
   * @param int $userStatus    User Status (Optional)
   * @param int $recordStatus  Record Status (Optional)
   * @return int $newUserID    User ID of new user or False
   */
  public function register($username, $password, $firstName, $lastName, $email, $contactNo, $isAdmin = 0, $userStatus = 0, $recordStatus = 1) {
    try {
      // Check Username does not already exist
      $exists = $this->exists($username);
      if (!empty($exists)) {  // Username is not unique
        $_SESSION["message"] = msgPrep("danger", "Error - Username '{$username}' is already in use! Please try again.");
        return false;
      } else {  // Insert User Record
        $passwordHash = password_hash($password, PASSWORD_ARGON2ID);
        $sql = "INSERT INTO `users` (`Username`, `Password`, `FirstName`, `LastName`, `Email`, `ContactNo`, `IsAdmin`, `UserStatus`, `RecordStatus`) VALUES ('{$username}', '{$passwordHash}', '{$firstName}', '{$lastName}', '{$email}', '{$contactNo}', '{$isAdmin}', '{$userStatus}', '{$recordStatus}')";
        $this->conn->exec($sql);
        $newUserID = $this->conn->lastInsertId();
        $_SESSION["message"] = msgPrep("success", "Registration of '{$username}' was successful.<br>They will receive an email once their account is approved.");
        return $newUserID;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/register Failed: {$err->getMessage()}");
      return false;      
    }
  }

  /**
   * login function - Check username & password & set Session
   * @param string $username  Username
   * @param string $password  User Password
   * @return bool             True if Function success
   */
  public function login($username, $password) {
    try {
      // Check User exists
      $exists = $this->exists($username);
      if (empty($exists)) {  // User does not exist
        $_SESSION["message"] = msgPrep("danger", "Incorrect Username or Password entered!");
        return false;
      } else {  // Confirm Password
        $sql = "SELECT `UserID`, `Password`, `IsAdmin`, `UserStatus`, `RecordStatus` FROM `users` WHERE `Username` = '{$username}'";
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        $passwordStatus = password_verify($password, $result["Password"]);
        $userID = $result["UserID"];
        $userIsAdmin = $result["IsAdmin"];
        $userStatus = $result["UserStatus"];
        $recordStatus = $result["RecordStatus"];
        $result = null;
        if ($passwordStatus == true) {  // Correct Password Entered
          if ($userStatus == 1) {  // User is approved
            if ($recordStatus == 1) {  // User is active
              $_SESSION["userLogin"] = true;
              $_SESSION["userIsAdmin"] = $userIsAdmin;
              $_SESSION["userID"] = $userID;
              $_SESSION["username"] = $username;
              return true;
            } else {
              // User is inactive
              $_SESSION["message"] = msgPrep("danger", "Error - User Account Inactive!");
              return false;
            }
          } else {
            // User is unapproved
            $_SESSION["message"] = msgPrep("warning", "Sorry - User has not yet been approved!");
            return false;
          }
        } else {
          // Password invalid
          $_SESSION["message"] = msgPrep("danger", "Incorrect Username or Password entered!");
          return false;
        }
      }      
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/Login Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * logout function - Logout user
   * @return bool  True if function success
   */
  public function logout() {
    unset($_SESSION["userLogin"], $_SESSION["userIsAdmin"], $_SESSION["userID"], $_SESSION["username"]);
    $_SESSION["message"] = msgPrep("success", "You are successfully logged out. Thanks for using the LibraryMS.");
    return true;
  }

  /**
   * getList function - Retrieve list of user records
   * @return array $result  Returns all user records
   */
  public function getUsersAll() {
    $sql = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo, IsAdmin, UserStatus FROM users";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * getUserIDs function - Retrieve all Approved user IDs (with Username)
   * @return array $result  Returns all Approved UserIDs (with Username)
   */
  public function getUserIDs() {
    $sql = "SELECT UserID, UserName FROM users WHERE UserStatus = '1' ORDER BY UserName";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * getUserByID function - Retrieve user record based on ID
   * @param int    $userID  User ID
   * @return array $result  Returns user record for $userID
   */
  public function getUserByID($userID) {
    $sql = "SELECT UserID, UserName, FirstName, LastName, Email, ContactNo FROM users WHERE UserID = '$userID'";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetch();
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

  /**
   * updateRecord function - Updates the User record of a user
   * @param int $userID        User ID
   * @param string $firstName  User First Name
   * @param string $lastName   User Last Name
   * @param string $email      User Email Address
   * @param string $contactNo  User Contact Number
   * @return bool              True if function success
   */
  public function updateRecord($userID, $firstName, $lastName, $email, $contactNo) {
    $sql = "UPDATE users SET FirstName = '$firstName', LastName = '$lastName', Email = '$email', ContactNo = '$contactNo' WHERE UserID = '$userID'";
    $result = $this->conn->exec($sql);
    return $result;
  }

  /**
   * updatePassword function - Updates the password of a user
   * @param int $userID         User ID
   * @param string $existingPW  User Existing Password
   * @param string $newPW       User New Password
   * @return bool               True if function success
   */
  public function updatePassword($userID, $existingPW, $newPW) {
    $sqlChk = "SELECT UserID, UserPassword FROM users WHERE UserID = '$userID'";
    $stmtChk = $this->conn->query($sqlChk, PDO::FETCH_ASSOC);
    $result = $stmtChk->fetch();
    $passwordStatus = password_verify($existingPW, $result["UserPassword"]);
    $result = null;
    if ($passwordStatus == true) {  // Correct Existing Password Entered
      $passwordHash = password_hash($newPW, PASSWORD_ARGON2ID);
      $sql = "UPDATE users SET UserPassword = '$passwordHash' WHERE UserID = '$userID'";
      $result = $this->conn->exec($sql);
      if ($result) {  // Update Successful
        $_SESSION["message"] = "Password Successfully Updated.";
        return true;
      } else {  // Update Unsuccessful
        $_SESSION["message"] = "Error - Password not Updated.";
        return false;
      }
    } else {  // Incorrect Existing Password Entered
      $_SESSION["message"] = "Error - Incorrect Existing Password!";
        return false;
    }
  }
}
?>