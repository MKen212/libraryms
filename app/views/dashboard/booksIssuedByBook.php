<?php
/**
 * DASHBOARD - Books Issued By Book List
 */

include_once "../app/models/bookIssuedByBookRowClass.php";
?>

<!-- Books Issued By Book -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Currently Issued for Book ID: <?= $bookID ?></h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div><?php

if (empty($bookRecord)) :  // Book Record not found ?>
  <div>Book ID not found.</div><?php
else :  // Display Selected Book Record
  include "../app/views/dashboard/bookRecord.php";?>
  <!-- Books Issued By Book Table -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Return Due Date</th>
          <th>Issued Date</th>
          <th>Issued To</th>
        </tr>
      </thead>
      <tbody><?php
        if (empty($booksIssuedByBook)) :  // No books_issued Records Found ?>
          <tr>
            <td colspan="3">No Issued Books to Display</td>
          </tr><?php
        else :
          // Loop through the books_issued and output the values
          foreach (new BookIssuedByBookRow(new RecursiveArrayIterator($booksIssuedByBook)) as $value) :
            echo $value;
          endforeach;
        endif; ?>
      </tbody>
    </table>
  </div><?php
endif;
