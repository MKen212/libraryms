<!-- INDEX - Login Form -->
<div class="row">
  <form class="form-user" action="" method="post" name="loginForm">
    <h3 class="mb-3">Please sign in</h3>
    <!-- User Name -->
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text form-labels">Username:</span>
      </div>
      <input class="form-control" type="text" name="lmsUsername" maxlength="50" placeholder="Enter Username" required autofocus />
    </div>
    <!-- Password -->
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text form-labels">Password:</span>
      </div>
      <input class="form-control" type="password" name="lmsPassword"  placeholder="Enter Password" required />
    </div>
    <br />
    <!-- Submit Button -->
    <button class="btn btn-lg btn-primary btn-block" type="submit" name="login" >Sign in</button>
    <!-- New Account Links -->
    <a href="index.php?p=register">Create new account</a>
  </form>
</div>
<!-- System Messages -->
<div class="row justify-content-center"><?php
  msgShow(); ?>
</div>