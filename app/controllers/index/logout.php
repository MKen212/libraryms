<?php
/**
 * INDEX/logout controller - Logout User
 */

require_once "../app/models/userClass.php";
$user = new User();

// Logout User if logout hyperlink clicked
if (isset($_GET["q"])) {
  $user->logout();
}
$_GET = [];

// Show Logout Page View
include "../app/views/index/logoutPage.php";

// Clear Session
session_unset();
session_destroy();
