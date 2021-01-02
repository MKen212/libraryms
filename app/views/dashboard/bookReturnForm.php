<!-- DASHBOARD - Book Return Form -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">List/Return Issued Books</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<!-- Display Book Return Form -->
<form class="ml-3" action="" method="get" name="bookReturnForm">
  <!-- Select User -->
  <div class="form-group row">
    <label class="col-form-label labFixed" for="userSelect">Select User:</label>
    <div class="input-group inpFixed">
      <select class="form-control" id="userSelect" name="userIDSelected">
        <!-- List all UserID: UserNames --><?php
        userOptions($selectedUserID); ?>
      </select>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="selectUser">Select</button>
      </div>
    </div>
  </div><?php

  if (!empty($userID)) :  // Only Show Issued Books list when UserID selected ?>
    <!-- Table of Issued Books for Selected User -->
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Issued ID</th>
            <th>Book ID</th>
            <th>Book Title</th>
            <th>Issued Date</th>
            <th>Return Due Date</th>
            <th>Return Book</th>
            <th>Record</th>
          </tr>
        </thead>
        <tbody><?php
          if (empty($booksIssuedByUserList)) :  // No books_issued records Found ?>
            <tr>
              <td colspan="7">No Issued Books to Display</td>
            </tr><?php
          else :
            // Loop through the books_issued records and output the values
            foreach (new BooksReturnListRow(new RecursiveArrayIterator($booksIssuedByUserList)) as $value) :
              echo $value;
            endforeach; ?>
            <!-- Show record count -->
            <tr class="table-info">
              <td colspan="7"><b>Total issued: <?= count($booksIssuedByUserList) ?></b></td>
            </tr><?php
          endif; ?>
        </tbody>
      </table>
    </div><?php
  endif; ?>
</form>