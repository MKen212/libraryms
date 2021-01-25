<?php
/**
 * DASHBOARD/sidebar controller - Update data for Sidebar
 */

require_once "../app/models/messageClass.php";
$message = new Message();

// Get count of Unread Messages
$unreadClass = "badge badge-info";
$unreadCount = $message->countUnreadByUserID($_SESSION["userID"]);
if ($unreadCount == 0) $unreadClass = "badge badge-light";  // Update Badge if no unread
// Create link
$msgsUnreadLink = "<a class='{$unreadClass}' href='dashboard.php?p=myMessages'><span data-feather='mail'></span> {$unreadCount}</a>";

// Display Sidebar Menu
include "../app/views/dashboard/sidebar.php";
