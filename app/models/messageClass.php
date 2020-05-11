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
      echo "Database Connection Failed: " . $err->getMessage() . "<br />";
    }
  }

  /**
   * addMessage function - Add Message
   * @param int $senderID    Sender User ID
   * @param int $receiveID   Receiver User ID
   * @param string $subject  Message Subject
   * @param string $body     Message Body
   * @return bool $result    True if Function success
   */
  public function addMessage($senderID, $receiverID, $subject, $body) {
    $sql = "INSERT INTO messages (SenderID, ReceiverID, Subject, Body) VALUES ('$senderID', '$receiverID', '$subject', '$body')";
    $result = $this->conn->exec($sql);
    return $result;
  }

  /**
   * cntUnreadByUserID function - Count Unread Messages for User ID
   * @param int $userID  User ID
   * @return int $count  Count of Unread Messages for $userID
   */
  public function cntUnreadByUserID($userID) {
    $sql = "SELECT MessageID FROM messages WHERE ReceiverID = '$userID' AND MsgRead = '0' AND MsgStatus = '1'";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $count = $statement->rowCount();
    return $count;
  }

  /**
   * getMsgsByUserID function - Get ALL messages sent to User ID
   * @param int $userID     User ID
   * @return array $result  Returns All messages sent to $userID ordered by MsgRead, MsgTimestamp
   */
  public function getMsgsByUserID($userID) {
    $sql = "SELECT messages.MessageID, messages.MsgRead, messages.SenderID, users.Username, messages.Subject, messages.Body, messages.MsgTimestamp FROM messages LEFT JOIN users ON messages.SenderID = users.userID WHERE messages.ReceiverID = '$userID' ORDER BY messages.MsgTimestamp DESC";
    $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $result = $statement->fetchAll();
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

  /**
   * updateMsgStatus function - Update the MsgStatus of a message
   * @param int $messageID   Message ID
   * @param bool $msgStatus  Message Status Flag (0=Deleted / 1=Active)
   * @return bool $result    True if function success
   */
  public function updateMsgStatus($messageID, $msgStatus) {
    $sql = "UPDATE messages SET MsgStatus = '$msgStatus' WHERE MessageID = '$messageID'";
    $result = $this->conn->exec($sql);
    return $result;
  }
}
?>