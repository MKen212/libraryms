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
   * @return bool $newMsgID  MessageID of added Message record or False
   */
  public function add($senderID, $receiverID, $subject, $body) {
    $sql = "INSERT INTO `messages` (`SenderID`, `ReceiverID`, `Subject`, `Body`) VALUES ('{$senderID}', '{$receiverID}', '{$subject}', '{$body}')";
    $this->conn->exec($sql);
    $newMsgID = $this->conn->lastInsertId();
    // Do Not set Session Message here as it overwrites when new user added
    return $newMsgID;
  }

  /**
   * countUnreadByUserID function - Count Unread Messages for User ID
   * @param int $userID   User ID
   * @return int $result  Count of Unread Messages for $userID
   */
  public function countUnreadByUserID($userID) {
    try {
      $sql = "SELECT COUNT(*) FROM `messages` WHERE `ReceiverID` = '{$userID}' AND `MsgStatus` = '0'";
      $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
      $result = $stmt->fetchColumn();
      return $result;
    } catch (PDOException $err) {
      $_SESSION["message"] = msgPrep("danger", "Error - Message/countUnreadByUserID Failed: {$err->getMessage()}");
      return false;
    }
  }

  /**
   * getMsgsToUserID function - Get ALL messages sent TO User ID
   * @param int $userID     User ID
   * @return array $result  Returns All messages sent TO $userID ordered by MsgTimestamp
   */
  public function getMsgsToUserID($userID) {
    $sql = "SELECT messages.MessageID, messages.MsgTimestamp, messages.MsgRead, messages.SenderID, users.Username, messages.Subject, messages.Body FROM messages LEFT JOIN users ON messages.SenderID = users.userID WHERE messages.ReceiverID = '$userID' ORDER BY messages.MsgTimestamp DESC";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * getMsgsFromUserID function - Get ALL messages sent FROM User ID
   * @param int $userID     User ID
   * @return array $result  Returns All messages sent FROM $userID ordered by MsgTimestamp
   */
  public function getMsgsFromUserID($userID) {
    $sql = "SELECT messages.MessageID, messages.MsgTimestamp, users.Username, messages.Subject, messages.Body FROM messages LEFT JOIN users ON messages.ReceiverID = users.userID WHERE messages.SenderID = '$userID' ORDER BY messages.MsgTimestamp DESC";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $stmt->fetchAll();
    return $result;
  }

  /**
   * updateMsgRead function - Update MsgRead status of a message
   * @param int $messageID     Message ID
   * @param bool $messageRead  True if Message Read / False if message UnRead
   * @return bool $result      True if function success
   */
  public function updateMsgRead($messageID, $messageRead) {
    $sql = "UPDATE messages SET MsgRead = '$messageRead' WHERE MessageID = '$messageID'";
    $result = $this->conn->exec($sql);
    return $result;
  }
}
?>