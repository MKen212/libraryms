<?php
/**
 * DASHBOARD/usersList view - List of users records
 */

namespace LibraryMS;

use RecursiveArrayIterator;

include_once "../app/models/userListClass.php";

?>
<!-- Users List - Header -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Users</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<div class="row">
  <!-- Users - Search -->
  <div class="col-4 mb-3">
    <form action="" method="post" name="schUsers" autocomplete="off">
      <div class="input-group">
        <input class="form-control" type="text" name="schUsername" maxlength="40" placeholder="Search Username" />
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit" name="userSearch"><span data-feather="search"></span></button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-8"></div>
</div>

<!-- Users List -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Contact No</th>
        <th>Admin</th>
        <th>Status</th>
        <th>Record</th>
      </tr>
    </thead>
    <tbody><?php
      if (empty($userList)) :  // No users records found ?>
        <tr>
          <td colspan="8">No Users to Display</td>
        </tr><?php
      else :
        // Loop through the users records and output the values
        foreach (new UserList(new RecursiveArrayIterator($userList)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>
