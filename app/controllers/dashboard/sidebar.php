<?php
declare(strict_types=1);
/**
 * DASHBOARD/sidebar controller
 *
 * Retrieve the count of unread messages for the current logged-in user, and
 * display the sidebar menu.
 *
 * For the full copyright and license information, please view the
 * {@link https://github.com/MKen212/libraryms/blob/master/LICENSE LICENSE}
 * file that was included with this source code.
 */

namespace LibraryMS;

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

// Display Sidebar Menu View
include "../app/views/dashboard/sidebarMenu.php";
