<!-- DASHBOARD - Books Issued To Me -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Books Issued to Me</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<!-- Books Issued To Me -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Issued ID</th>
        <th>Book ID</th>
        <th>Book Title</th>
        <th>Issued Date</th>
        <th>Return<br />Due Date</th>
        <th>Actual<br />Returned Date</th>
      </tr>
    </thead>
    <tbody><?php
      if (empty($booksIssuedToMe)) :  // No books_issued to me records Found ?>
        <tr>
          <td colspan="6">No Issued Books to Display</td>
        </tr><?php
      else :
        // Loop through the books_issued to me and output the values
        foreach (new BooksIssuedToMeRow(new RecursiveArrayIterator($booksIssuedToMe)) as $value) :
          echo $value;
        endforeach; ?>
        <!-- Show record count -->
        <tr class="table-info">
          <td colspan="6"><b>Total issued to me: <?= count($booksIssuedToMe) ?></b></td>
        </tr><?php
      endif; ?>
    </tbody>
  </table>
</div>