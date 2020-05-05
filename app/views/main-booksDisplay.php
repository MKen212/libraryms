<!-- Books Page -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Books Display</h1>
</div>

<!-- Books Table Search -->
<div>
  <form action="" method="POST" name="schBookForm">
    <!-- Title -->
    <div class="input-group mb-3 w-50">
      <input class="form-control" type="text" name="schTitle" placeholder="Search Title" autocomplete="off" />
      <div class="input-group-append">
        <button class="btn btn-secondary" type="submit" name="bookSearch"><span data-feather="search"></span></button>
    </div>
  </form>
</div>

<!-- Books Table Display -->
<div class="container-fluid mb-3">
  <!-- Display All Books -->
  <?php include("../controllers/booksDisplay.php");?>
</div>