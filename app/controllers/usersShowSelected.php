<?php  // Show Selected UserID
include_once("../models/userClass.php");
$user = new User();

if (isset($_POST["selectUser"]) || isset($_POST["selectBook"]) || isset($_POST["issueBook"]) || isset($_POST["sendMessage"])) {
  $selUser = $user->getUserByID($_POST["userIDSelected"]);
  echo "<div class='table-responsive'>
    <table class='table table-striped table-sm'>
      <thead>
        <th>User ID</th>
        <th>User Name</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Contact No</th>
      </thead>
      <tbody>
        <tr>
          <td>" . $selUser["UserID"] . "</td>
          <td>" . $selUser["UserName"] . "</td>
          <td>" . $selUser["FirstName"] . "</td>
          <td>" . $selUser["LastName"] . "</td>
          <td>" . $selUser["Email"] . "</td>
          <td>" . $selUser['ContactNo'] . "</td>
        </tr>
      </tbody>
    </table>
  </div>";
}
?>

