<!-- DASHBOARD - Book Issue Form -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Issue Book</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<form class="ml-3" action="" method="post" name="bookIssueForm">
  <!-- Select User -->
  <div class="form-group row">
    <label class="col-form-label labFixed" for="userSelect">Select User:</label>
    <div class="input-group inpFixed">
      <select class="form-control" id="userSelect" name="userIDSelected">
        <!-- List all UserID: UserNames --><?php
        userOptions($booksIssuedRecord["UserID"]); ?>
      </select>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="selectUser">Select</button>
      </div>
    </div>
  </div><?php
  // Show Selected User Record & Select Book
  if (!empty($userRecord)) : ?>
    <div class="form-group row pr-3"><?php
      include "../app/views/dashboard/userRecord.php"; ?>
    </div>
    <!-- Select Book -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="bookSelect">Select Book:</label>
      <div class="input-group inpFixed">
        <select class="form-control" id="bookSelect" name="bookIDSelected">
          <!-- List all UserID: UserNames --><?php
          bookOptions($booksIssuedRecord["BookID"]); ?>
        </select>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" name="selectBook">Select</button>
        </div>
      </div>
    </div><?php
  endif;
  // Show Selected Book Record & Select Issue Date and Return Due Date
  if (!empty($bookRecord)) : ?>
    <div class="form-group row pr-3"><?php
      include "../app/views/dashboard/bookRecord.php"; ?>
    </div>
    <!-- Issued Date / Returned Due Date / Submit -->
    <div class="form-group row">
      <div class="input-group">
        <label class="col-form-label mr-3" for="issuedDate">Issued Date:</label>
        <input class="form-control mr-5" type="date" name="issuedDate" id="issuedDate" min="<?= $booksIssuedRecord["EarliestIssueDate"] ?>" value="<?= $booksIssuedRecord["IssuedDate"] ?>" required />
        <label class="col-form-label mr-3" for="returnDate">Return Due Date:</label>
        <input class="form-control mr-5" type="date" name="returnDueDate" id="returnDate" min="<?= $booksIssuedRecord["EarliestReturnDate"] ?>" value="<?= $booksIssuedRecord["ReturnDueDate"] ?>" required />
        <button class="btn btn-primary mr-3" type="submit" name="issueBook" id = "issueBook">Issue Book</button>
      </div>
    </div><?php
  endif; ?>
</form>
