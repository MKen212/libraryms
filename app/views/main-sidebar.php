<!-- Sidebar Menu -->
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <!-- Welcome -->
      <li class="nav-brand">
        <h6 class="ml-2">Welcome, <?php include("../controllers/welcomeUser.php")?></h6>
        <hr>
      </li>
      <!-- Home -->
      <li class="nav-item">
        <a class="nav-link active" href="main-home.php"><span data-feather="home"></span>Home<span class="sr-only">(current)</span></a>
      </li>
      <!-- Books -->
      <li class="nav-item">
        <a class="nav-link" href="main-booksDisplay.php"><span data-feather="book"></span>Books</a>
      </li>
      <!-- Issued to Me -->
      <li class="nav-item">
        <a class="nav-link" href="main-booksIssuedToMe.php"><span data-feather="book-open"></span>Issued to Me</a>
      </li>
      <!-- Send a Message -->
      <li class="nav-item">
        <a class="nav-link" href="main-messagesSend.php"><span data-feather="send"></span>Send a Message</a>
        <hr />
      </li>
      <!-- My Profile -->
      <li class="nav-item">
        <a class="nav-link" href="main-usersProfile.php"><span data-feather="user"></span>My Profile</a>
        <hr />
      </li>
    </ul>
    
    <!-- Admin Section -->
    <?php if ($_SESSION["userIsAdmin"] == true) { ?>
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Admin Section</h6>
      <ul class="nav flex-column">
        <!-- List Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksList.php"><span data-feather="layers"></span>
          List Books</a>
        </li>
        <!-- Add Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksAdd.php"><span data-feather="plus-square"></span>
          Add Books</a>
        </li>
        <!-- List Issued Books-->
        <li class="nav-item">
          <a class="nav-link" href="main-booksIssuedAdd.php"><span data-feather="file-text"></span>
          List Issued Books</a>
        </li>
        <!-- Return Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksIssuedRtn.php"><span data-feather="plus-circle"></span>
          Return Books</a>  
        </li>
        <!-- List Users-->
        <li class="nav-item">
          <a class="nav-link" href="main-users.php"><span data-feather="users"></span>
          List Users</a>
        </li>
      <?php ;}?>
    </ul>
  </div>
</nav>