<!-- DASHBOARD - Books List -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Books</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<div class="row">
  <!-- Books Table Search -->
  <div class="col-4 mb-3">
    <form action="" method="post" name="schBooks" autocomplete="off">
      <div class="input-group">
        <input class="form-control" type="text" name="schTitle" maxlength="40" placeholder="Search Title" />
        <div class="input-group-append">
          <button class="btn btn-secondary" type="submit" name="bookSearch"><span data-feather="search"></span></button>
        </div>
      </div>
    </form>
  </div>
  <div class="col-8"></div>
</div>

<div class="row">
  <!-- Books Table List -->
  <div class="table-responsive">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Publisher</th>
          <th>ISBN</th>
          <th>Price<br />(<?= DEFAULTS["currency"] ?>)</th>
          <th>Qty<br />Total</th>
          <th>Qty<br />Available</th>
          <th>Record</th>
        </tr>
      </thead>
      <tbody><?php
        if (empty($bookList)) :  // No Book Records Found ?>
          <tr>
            <td colspan="10">No Books to Display</td>
          </tr><?php
        else : 
          // Loop through the Users and output the values
          foreach (new BookListRow(new RecursiveArrayIterator($bookList)) as $value) :
            echo $value;
          endforeach;
        endif; ?>
      </tbody>
    </table>
  </div>
</div>