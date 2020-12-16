<!-- DASHBOARD - Users List -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Users List</h1>
</div>
<!-- System Messages -->
<div><?php
  msgShow(); ?>
</div>

<!-- Table of Users -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <th>User ID</th>
      <th>User Name</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Contact No</th>
      <th>Admin User</th>
      <th>Status</th>
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