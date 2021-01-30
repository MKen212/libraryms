<?php
/**
 * DASHBOARD/navbarHeader view - Top navigation bar
 */

?>
<!-- Top Navbar -->
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <!-- Brand/Logo -->
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="dashboard.php?p=home"><span data-feather="book"></span> Library MS</a>
  <!-- Search Bar -->
  <form class="input-group w-100" action="dashboard.php?p=displayBooks" method="post" name="schNavbar" autocomplete="off">
    <!-- Search Text -->
    <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search" name="navSchString" value="<?= isset($_SESSION["navSchString"]) ? $_SESSION["navSchString"] : null ?>" />
    <!-- Search Button -->
    <div class="input-group-append">
      <button class="btn btn-secondary" type="submit" name="navSearch"><span data-feather="search"></span></button>
    </div>
    <!-- Clear Button -->
    <div class="input-group-append">
      <button class="btn btn-secondary" type="submit" name="navClear"><span data-feather="x-circle"></span></button>
    </div>
  </form>
  <!-- Logout Link -->
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="index.php?p=logout&q">Sign out</a>
    </li>
  </ul>
</nav>
