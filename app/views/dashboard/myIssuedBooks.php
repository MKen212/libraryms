<!-- DASHBOARD - My Issued Books -->
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

<!-- Books Issued To Me -->
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
      if (empty($booksIssuedToMe)) :  // No books_issued to me records Found ?>
        <tr>
          <td colspan="5">No Issued Books to Display</td>
        </tr><?php
      else :
        // Loop through the books_issued to me and output the values
        foreach (new BooksIssuedToMeRow(new RecursiveArrayIterator($booksIssuedToMe)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>