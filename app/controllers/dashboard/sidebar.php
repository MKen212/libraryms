<?php
/**
 * DASHBOARD/sidebar controller - Update data for Sidebar
 */

require_once "../app/models/messageClass.php";
$message = new Message();

// Get count of Unread Messages
$unreadClass = "badge badge-info";
$unreadCount = $message->countUnreadByUserID($_SESSION["userID"]);
// Update Badge if no unread
if ($unreadCount == 0) {
  $unreadClass = "badge badge-light";
}

// Create link
$msgsUnreadLink = "<a class='{$unreadClass}' href='dashboard.php?p=myMessages'><span data-feather='mail'></span> {$unreadCount}</a>";

// Display Sidebar Menu
include "../app/views/dashboard/sidebar.php";
