<!-- Books Page -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Books List</h1>
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

<!-- Books Table List -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <!-- Books Table Header -->
      <th>Book ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Publisher</th>
      <th>ISBN</th>
      <th>Price (GBP)</th>
      <th>Qty Total</th>
      <th>Qty Available</th>
      <th>Date Added</th>
      <th>Added By</th>
    </thead>
    <tbody>
      <!-- List All Books -->
      <?php include("../controllers/booksList.php");?>
    </tbody>
  </table>
</div>