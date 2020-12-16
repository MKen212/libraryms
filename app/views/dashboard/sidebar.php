<!-- DASHBOARD - Sidebar Menu -->
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <!-- Welcome -->
      <li class="nav-brand">
        <h6 class="ml-2">Welcome, <?= $_SESSION["username"] ?> <a class="<?= $unreadClass ?>" href="dashboard.php?p=messages"><span data-feather="mail"></span> <?= $unreadCount ?></a></h6>
        <hr>
      </li>
      <!-- Home -->
      <li class="nav-item">
        <a class="nav-link<?= ($page == "home") ? " active" : "";?>" href="dashboard.php?p=home"><span data-feather="home"></span>Home</a>
      </li>
      <!-- Display Books -->
      <li class="nav-item">
        <a class="nav-link" href="main-booksDisplay.php"><span data-feather="book"></span>Display Books</a>
      </li>
      <!-- Issued to Me -->
      <li class="nav-item">
        <a class="nav-link" href="main-booksIssuedToMe.php"><span data-feather="book-open"></span>My Issued Books</a>
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
    </ul><?php
    // Only Display Admin Section if userIsAdmin
    if ($_SESSION["userIsAdmin"] == 1) : ?>
      <!-- Admin Section -->
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">Admin Section</h6>
      <ul class="nav flex-column">
        <!-- Issue Books-->
        <li class="nav-item">
          <a class="nav-link" href="main-booksIssuedAdd.php"><span data-feather="arrow-up-circle"></span>
          Issue Books</a>
        </li>
        <!-- Return Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksIssuedRtn.php"><span data-feather="arrow-down-circle"></span>
          Return Books</a>  
        </li>
        <!-- Add Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksAdd.php"><span data-feather="plus-circle"></span>
          Add Books</a>
        </li>
        <!-- List/Edit Books -->
        <li class="nav-item">
          <a class="nav-link" href="main-booksList.php"><span data-feather="layers"></span>
          List/Edit Books</a>
        </li>
        <!-- List/Edit Users-->
        <li class="nav-item">
          <a class="nav-link<?= ($page == "usersList") ? " active" : "";?>" href="dashboard.php?p=usersList"><span data-feather="users"></span>
          List/Edit Users</a>
        </li>
      </ul><?php
    endif; ?>
  </div>
</nav>