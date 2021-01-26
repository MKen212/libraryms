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

// Show Logout View
include "../app/views/index/logout.php";

// Clear Session
session_unset();
session_destroy();
