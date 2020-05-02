<!-- Books Issued Return Page -->
<!-- Let Browser handle basic form error checks -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Return Issued Books</h1>
</div>

<!-- Books Issued Return Form -->
<div>
  <form class="ml-3" action="" method="POST" name="issBksRtnForm">
    <div class="form-group row">
      <!-- Select User -->
      <label class="col-form-label labFixed" for="userSelect">Select User:</label>
      <div class="input-group inpFixed">
        <select class="form-control" id="userSelect" name="userIDSelected">
          <!-- List all UserID > UserNames -->
          <?php include("../controllers/usersSelectID.php");?>
        </select>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" name="selectOSUser">Select</button>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <!-- Show List of Outstanding Books Issued to User -->
      <?php include("../controllers/booksIssuedListOS.php");?>
    </div>
  </form>
</div>
