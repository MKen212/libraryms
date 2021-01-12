<?php  // Message Class
class Message {
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
      $_SESSION["message"] = msgPrep("danger", "Error - Message/DB Connection Failed: {$err->getMessage()}");
    }
  }

  /**
   * add function - Add Message Record
   * @param int $senderID    Sender User ID
   * @param int $receiverID  Receiver User ID
   * @param string $subject  Message Subject
   * @param string $body     Message Body
   * @return int $newMsgID  MessageID of added Message record or False
   */
  public function add($senderID, $receiverID, $subject, $body) {
    try {
      $sql = "INSERT INTO `messages` (`SenderID`, `ReceiverID`, `Subject`, `Body`) VALUES ('{$senderID}', '{$receiverID}', '{$subject}', '{$body}')";
    $this->conn->exec($sql);
    $newMsgID = $this->conn->lastInsertId();
    // Do Not set Session Message here as it overwrites when new user added
    return $newMsgID;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/add Failed: {$err->getMessage()}");
    }
  }

  /**
   * countUnreadByUserID function - Count ACTIVE Unread Messages for User ID
   * @param int $userID   User ID
   * @return int $result  Count of ACTIVE Unread Messages for $userID
   */
  public function countUnreadByUserID($userID) {
    try {
      $sql = "SELECT COUNT(*) FROM `messages` WHERE `ReceiverID` = '{$userID}' AND `MessageStatus` = '0' AND `RecordStatus` = '1'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchColumn();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/countUnreadByUserID Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getListReceived function - Retrieve list of messages RECEIVED BY Receiver ID (optionally by RecordStatus) from messages_view
   * @param int $receiverID    Receiver User ID
   * @param int $recordStatus  Record Status (Optional)
   * @return array $result     Returns all messages received by Receiver ID (AddedTimeStamp Descending order) or False
   */
  public function getListReceived($receiverID, $recordStatus = null) {
    try {
      // Build WHERE clause
      $whereClause = "WHERE `ReceiverID` = '{$receiverID}' ";
      if (!empty($recordStatus)) $whereClause .= "AND `RecordStatus` = '{$recordStatus}' ";
      // Build SQL & Execute
      $sql = "SELECT `MessageID`, `AddedTimestamp`, `SenderID`, `SenderName`, `Subject`, `Body`, `MessageStatus` FROM `messages_view` {$whereClause}ORDER BY `AddedTimestamp` DESC";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/getListReceived Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getListSent function - Retrieve list of messages SENT BY Sender ID (optionally by RecordStatus) from messages_view
   * @param int $senderID      Sender User ID
   * @param int $recordStatus  Record Status (Optional)
   * @return array $result     Returns all messages sent by Sender ID (AddedTimeStamp Descending order) or False
   */
  public function getListSent($senderID, $recordStatus = null) {
    try {
      // Build WHERE clause
      $whereClause = "WHERE `SenderID` = '{$senderID}' ";
      if (!empty($recordStatus)) $whereClause .= "AND `RecordStatus` = '{$recordStatus}' ";
      // Build SQL & Execute
      $sql = "SELECT `MessageID`, `AddedTimestamp`, `ReceiverName`, `Subject`, `Body`, `MessageStatus`, `RecordStatus` FROM `messages_view` {$whereClause}ORDER BY `AddedTimestamp` DESC";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/getListSent Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * updateStatus function - Updates the relevant Status Code of a message record
   * @param string $field   Field in messages table to be updated
   * @param int $userID     Message ID
   * @param int $newStatus  New Status code for field
   * @return int $result    Number of records updated (=1) or False
   */
  public function updateStatus($field, $messageID, $newStatus) {
    try {
      $sql = "UPDATE `messages` SET {$field} = '$newStatus' WHERE `MessageID` = '{$messageID}'";
      $result = $this->conn->exec($sql);
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/updateStatus Failed: {$err->getMessage()}");
      return false;
    }
  }
}
?>