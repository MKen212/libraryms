<!-- DASHBOARD - User Form -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2"><?= $formData["formTitle"] ?></h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div><?php

if (empty($userRecord)) :  // User Record not found ?>
  <div>User ID not found.</div><?php
else :  // Display Forms ?>
  <!-- User Form -->
  <form class="ml-3" action="" method="post" name="userForm" autocomplete="off">
    <!-- User Name -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="username">Username:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="username" id="username" maxlength="40" placeholder="Enter Username" value="<?= $userRecord["Username"] ?>" required />
      </div>
    </div>
    <!-- First Name -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="firstName">First Name:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="firstName" id="firstName" maxlength="40" placeholder="Enter First Name" value="<?= $userRecord["FirstName"] ?>" />
      </div>
    </div>
    <!-- Last Name -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="lastName">Last Name:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="lastName" id="lastName" maxlength="40" placeholder="Enter Last Name" value="<?= $userRecord["LastName"] ?>" />
      </div>
    </div>
    <!-- Email -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="email">Email:</label>
      <div class="inpFixed">
        <input class="form-control" type="email" name="email" id="email" maxlength="40" placeholder="Enter Email Address" value="<?= $userRecord["Email"] ?>" required />
      </div>
    </div>
    <!-- Contact Number -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="contactNo">Contact No:</label>
      <div class="inpFixed">
        <input class="form-control" type="tel" name="contactNo" id="contactNo" maxlength="40" placeholder="Enter Contact Telephone Number" value="<?= $userRecord["ContactNo"] ?>" />
      </div>
    </div>
    <!-- Submit Button -->
    <div class="form-group row">
      <div class="col-form-label labFixed">
        <button class="btn btn-primary" type="submit" name="updateUser" id="updateUser"><?= $formData["submitText"] ?></button>
      </div>
      <div class="inpFixed"></div>
    </div>
  </form>
  <hr />

  <!-- Password Form -->
  <form class="ml-3" action="" method="post" name="passwordForm" autocomplete="off">
    <!-- Existing Password -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="existingPW">Existing Password:</label>
      <div class="inpFixed">
        <input class="form-control" type="password" name="existingPassword" id="existingPW" placeholder="Enter Existing Password" required />  
      </div>
    </div>
    <!-- New Password -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="newPW">New Password:</label>
      <div class="inpFixed">
        <input class="form-control" type="password" name="newPassword" id="newPW" minlength="5" placeholder="Enter New Password" required />  
      </div>
    </div>
    <!-- Repeat New Password -->
    <div class="form-group row">
      <label class ="col-form-label labFixed" for="repeatPW">Repeat Password:</label>
      <div class="inpFixed">
        <input class="form-control" type="password" name="repeatPassword" id="repeatPW" minlength="5" placeholder="Repeat New Password" required />  
      </div>
    </div>
    <!-- Submit Button -->
    <div class="form-group row">
      <div class="col-form-label labFixed">
        <button class="btn btn-primary" type="submit" name="updatePassword" id="updatePassword">Update Password</button>
      </div>
      <div class="inpFixed"></div>
    </div>
  </form><?php
endif; ?>