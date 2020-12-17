<!-- DASHBOARD - Home -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Home</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div><?php

// Display Testing Information if in Testing Mode
if (DEFAULTS["testing"] == true) : ?>
  <!-- PHP Global Variables -->
  <div>
    <pre><?php
      echo "SESSION: ";
      print_r($_SESSION);
      echo "<br />POST: ";
      print_r($_POST);
      echo "<br />GET: ";
      print_r($_GET);
      echo "<br />FILES: ";
      print_r($_FILES);
      // echo "<br />SERVER: ";
      // print_r($_SERVER);
      echo "<br />"; ?>
    </pre>
  </div><?php
endif; ?>