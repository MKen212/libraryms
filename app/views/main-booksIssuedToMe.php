<!-- Books Issued To Me Page -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Books Issued To Me</h1>
</div>

<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <!-- Books Issued Table Header -->
      <th>Issued ID</th>
      <th>Book ID</th>
      <th>Book Title</th>
      <th>User ID</th>
      <th>User Name</th>
      <th>Issued Date</th>
      <th>Return Due Date</th>
      <th>Returned Date</th>
    </thead>
    <tbody>
      <!-- List All Issued Books -->
      <?php include("../controllers/booksIssuedListByUser.php");?>
    </tbody>
  </table>
  <?php  // List record count
    echo "Record Count: " . $_SESSION["rowCount"] . " record(s).";
    unset ($_SESSION["rowCount"]);
  ?>
</div>
