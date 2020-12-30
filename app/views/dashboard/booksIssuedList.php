<!-- DASHBOARD - Books Issued List -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2"><?= $listData["listTitle"] ?></h1>
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
  <!-- Books Issued List -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Issued ID</th>
          <th>User ID</th>
          <th>User Name</th>
          <th>Issued Date</th>
          <th>Return Due Date</th>
        </tr>
      </thead>
      <tbody><?php
        if (empty($booksIssuedList)) :  // No books_issued Records Found ?>
          <tr>
            <td colspan="5">No Issued Books to Display</td>
          </tr><?php
        else :
          // Loop through the books_issued and output the values
          foreach (new BooksIssuedListRow(new RecursiveArrayIterator($booksIssuedList)) as $value) :
            echo $value;
          endforeach;
        endif; ?>
      </tbody>
    </table>
    <!-- List record count & Hyperlink to Display Books -->
    Issued Count: <?= count($booksIssuedList) ?> book(s).<br />
    <a href="dashboard.php?p=booksDisplay">Return to Display Books</a>
  </div>
<?php
// TO FIX: unset ($_SESSION["rowCount"]);
endif;?>

