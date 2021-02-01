<?php
/**
 * DASHBOARD/navbar controller - Update data for top Navbar
 */

namespace LibraryMS;

// Update Book Title Search, if POSTed from navbar
if (isset($_POST["navSearch"])) {
  if (empty($_POST["navSchString"])) {
    unset($_SESSION["navSchString"]);
  } else {
    $_SESSION["navSchString"] = cleaninput($_POST["navSchString"], "string");
  }
  unset($_POST["navSearch"], $_POST["navSchString"]);
} elseif (isset($_POST["navClear"])) {
  unset($_POST["navClear"], $_SESSION["navSchString"]);
}

// Display Navbar Header View
include "../app/views/dashboard/navbarHeader.php";
