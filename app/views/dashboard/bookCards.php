<?php
/**
 * DASHBOARD/bookCards view - Display books records in card format
 */

namespace LibraryMS;

use RecursiveArrayIterator;

include_once "../app/models/bookCardClass.php";

?>
<!-- Books Display - Header -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Books Display</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<!-- Books Display -->
<div class="container-fluid mb-3"><?php
  if (empty($bookDisplay)) :  // No books records found ?>
    <div>No Books found<?= (!empty($title)) ? " matching search criteria" : "" ?>.</div><?php
  else :
    // Loop through the books records and output the values
    foreach (new BookCard(new RecursiveArrayIterator($bookDisplay)) as $value) :
      echo $value;
    endforeach;
  endif; ?>
</div>
