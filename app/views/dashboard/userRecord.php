<!-- DASHBOARD - Selected User Record Details -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>User ID</th>
        <th>Username</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Contact No</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $booksIssuedRecord["UserID"] ?></td>
        <td><?= $userRecord["Username"] ?></td>
        <td><?= $userRecord["FirstName"] ?></td>
        <td><?= $userRecord["LastName"] ?></td>
        <td><?= $userRecord["Email"] ?></td>
        <td><?= $userRecord["ContactNo"] ?></td>
      </tr>
    </tbody>
  </table>
</div>