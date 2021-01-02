<!-- DASHBOARD - Users List -->
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
  <!-- Users Table Search -->
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

<!-- Table of Users -->
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
      if (empty($userList)) :  // No User Records Found ?>
        <tr>
          <td colspan="8">No Users to Display</td>
        </tr><?php
      else : 
        // Loop through the Users and output the values
        foreach (new UserListRow(new RecursiveArrayIterator($userList)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>