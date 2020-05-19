<!-- Users Page -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users</h1>
</div>

<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <!-- Users Table Header -->
      <th>User ID</th>
      <th>User Name</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Contact No</th>
      <th>Admin User</th>
      <th>Status</th>
    </thead>
    <tbody>
      <!-- List All Users -->
      <?php include("../controllers/usersList.php");?>
    </tbody>
  </table>
</div>