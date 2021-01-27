<?php
/**
 * DASHBOARD/myIssuedBooks view - List of books_issued records for specific
 * user
 */

include_once "../app/models/bookIssuedToMeRowClass.php";

?>
<!-- My Issued Books - Header -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">My Issued Books</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<!-- My Issued Books - Table-->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Return<br />Due Date</th>
        <th>Actual<br />Returned Date</th>
        <th>Issued Date</th>
        <th>Book Title</th>
      </tr>
    </thead>
    <tbody><?php
      if (empty($booksIssuedToMe)) :  // No books_issued records found ?>
        <tr>
          <td colspan="5">No Issued Books to Display</td>
        </tr><?php
      else :
        // Loop through the books_issued records and output the values
        foreach (new BookIssuedToMeRow(new RecursiveArrayIterator($booksIssuedToMe)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>
