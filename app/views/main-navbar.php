<!-- Top Navbar -->
<nav class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <!-- Brand -->
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#"><span data-feather="book"></span> Library MS</a>
  <!-- Search Bar -->
  <div class="input-group w-100">
    <input class="form-control form-control-dark" type="text" placeholder="Search" aria-label="Search" name="lmsSearch">
    <div class="input-group-append">
      <button class="btn btn-secondary" type="button" name="search"><span data-feather="search"></span></button>
    </div>
  </div>
  <!-- Logout -->
  <ul class="navbar-nav px-3">
    <li class="nav-item text-nowrap">
      <a class="nav-link" href="../views/main.php?q=logout">Sign out</a>
        <?php include("../controllers/logoutUser.php");?>
    </li>
  </ul>
</nav>