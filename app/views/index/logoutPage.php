<?php
/**
 * INDEX/logoutPage view - Logout page
 */

namespace LibraryMS;

?>
<!-- Logout Page -->
<div class="row justify-content-center mb-3">
  <h2>Goodbye.</h2>
</div>
<br />

<!-- System Messages -->
<div class="row justify-content-center mb-3"><?php
  msgShow(); ?>
</div>

<!-- Re-Login Links -->
<div class="row justify-content-center">
  <a href="index.php?p=login">Back to Login</a>
</div>
