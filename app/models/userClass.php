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
   * @return bool  True if function success or False
   */
  public function logout() {
    try {
      unset($_SESSION["userLogin"], $_SESSION["userIsAdmin"], $_SESSION["userID"], $_SESSION["username"]);
      $_SESSION["message"] = msgPrep("success", "You are successfully logged out. Thanks for using the LibraryMS.");
      return true;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/Logout Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getList function - Retrieve list of user records
   * @param string $username  Username (Optional)
   * @return array $result    Returns all/selected user records (Username order) or False
   */
  public function getList($username = null) {
    try {
      // Build WHERE clause
      $whereClause = null;
      if (!empty($username)) $whereClause = "WHERE `Username` LIKE '%{$username}%'";
      $sql = "SELECT `UserID`, `Username`, `FirstName`, `LastName`, `Email`, `ContactNo`, `IsAdmin`, `UserStatus`, `RecordStatus` FROM `users` {$whereClause}ORDER BY `Username`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/getList Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getUserIDs function - Retrieve all Approved/Active User IDs with Username
   * @return array $result  Returns all Approved/Active records or False
   */
  public function getUserIDs() {
    try {
      $sql = "SELECT `UserID`, `Username` FROM `users` WHERE `UserStatus` = '1' AND `RecordStatus` = '1' ORDER BY `Username`";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/getUserIDs Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getRecord function - Retrieve user record based on ID
   * @param int    $userID  User ID
   * @return array $result  Returns user record for $userID or False
   */
  public function getRecord($userID) {
    try {
      $sql = "SELECT `Username`, `FirstName`, `LastName`, `Email`, `ContactNo` FROM `users` WHERE `UserID` = '{$userID}'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetch();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/getRecord Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * updateRecord function - Updates an existing User record
   * @param int $userID        User ID
   * @param int $username      Username
   * @param string $firstName  User First Name
   * @param string $lastName   User Last Name
   * @param string $email      User Email Address
   * @param string $contactNo  User Contact Number
   * @return int $result       Number of records updated (=1) or False
   */
  public function updateRecord($userID, $username, $firstName, $lastName, $email, $contactNo) {
    try {
      // Check update username does not already exist (other than in current record)
      $exists = $this->exists($username);
      if (!empty($exists) && $exists != $userID) {  // Username is NOT unique
        $_SESSION["message"] = msgPrep("danger", "Error - Username '{$username}' is already in use! Please try again.");
        return false;
      } else {  // Update User Record
        $sql = "UPDATE `users` SET `Username` = '{$username}', `FirstName` = '{$firstName}', `LastName` = '{$lastName}', `Email` = '{$email}', `ContactNo` = '{$contactNo}' WHERE `UserID` = '{$userID}'";
        $result = $this->conn->exec($sql);
        if ($result == 0) {  // No Changes made
          $_SESSION["message"] = msgPrep("warning", "Warning - No changes made to User ID '{$userID}'.");
        } elseif ($result == 1) {  // Only 1 record should have been updated
          $_SESSION["message"] = msgPrep("success", "Update of User ID: '{$userID}' was successful.");
          if ($userID == $_SESSION["userID"]) {  // User has updated their own record
            $_SESSION["userName"] = $username;
          }
        } else {
          throw new PDOException("Update unsuccessful or multiple records updated.");
        }
        return $result;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/updateRecord Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * updatePassword function - Updates the password of a user record
   * @param int $userID               User ID
   * @param string $existingPassword  User Existing Password
   * @param string $newPassword       User New Password
   * @return int $result              Number of records updated (=1) or False
   */
  public function updatePassword($userID, $existingPassword, $newPassword) {
    try {
      $sqlChk = "SELECT `UserID`, `Password` FROM `users` WHERE `UserID` = '{$userID}'";
      $stmtChk = $this->conn->query($sqlChk, PDO::FETCH_ASSOC);
      $resultChk = $stmtChk->fetch();
      $passwordStatus = password_verify($existingPassword, $resultChk["Password"]);
      $result = null;
      if ($passwordStatus == true) {  // Correct Existing Password Entered
        $passwordHash = password_hash($newPassword, PASSWORD_ARGON2ID);
        $sql = "UPDATE `users` SET `Password` = '{$passwordHash}' WHERE `UserID` = '{$userID}'";
        $result = $this->conn->exec($sql);
        if ($result == 0) {  // No Changes made
          $_SESSION["message"] = msgPrep("warning", "Warning - No changes made to User ID '{$userID}'.");
        } elseif ($result == 1) {  // Only 1 record should have been updated
          $_SESSION["message"] = msgPrep("success", "Password Successfully Updated.");
          return true;
        } else {
          throw new PDOException("Update unsuccessful or multiple records updated.");
        }
      } else {  // Incorrect Existing Password Entered
        $_SESSION["message"] = msgPrep("danger", "Error - Incorrect Existing Password!");
        return false;
      }
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/updatePassword Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * updateStatus function - Updates the relevant Status Code of a user record
   * @param string $field   Field in users table to be updated
   * @param int $userID     User ID
   * @param int $newStatus  New Status code for field
   * @return int $result    Number of records updated (=1) or False
   */
  public function updateStatus($field, $userID, $newStatus) {
    try {
      $sql = "UPDATE `users` SET {$field} = '$newStatus' WHERE `UserID` = '{$userID}'";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - User/updateStatus Failed: {$err->getMessage()}");
      return false;
    }
  }
}
?>