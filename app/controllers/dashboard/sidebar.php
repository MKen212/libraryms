<?php  // DASHBOARD - Sidebar
include_once "../app/models/messageClass.php";
$message = new Message();

// Check Unread Messages & update badge
$unreadClass = "badge badge-info";
$unreadCount = $message->countUnreadByUserID($_SESSION["userID"]);
if ($unreadCount == 0) $unreadClass = "badge badge-light";  // Update Badge if no unread

// Display Sidebar Menu
include "../app/views/dashboard/sidebar.php";
?>