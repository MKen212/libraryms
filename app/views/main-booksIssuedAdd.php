<!-- Books Issued Add Page -->
<!-- Let Browser handle basic form error checks -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Add Issued Books</h1>
</div>

<!-- Issued Books Add Form -->
<div>
  <form class="ml-3" action="" method="POST" name="issBksAddForm">
    <div class="form-group row">
      <!-- Select User -->
      <label class="col-form-label labFixed" for="userSelect">Select User:</label>
      <div class="input-group inpFixed">
        <select class="form-control" id="userSelect" name="userIDSelected">
          <!-- List all UserID > UserNames -->
          <?php include("../controllers/usersSelectID.php");?>
        </select>
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit" name="selectUser">Select</button>
        </div>
      </div>
    </div>
    <div class="form-group row">
      <!-- Show selected User Details -->
      <?php include("../controllers/usersShowSelected.php");?>
    </div>
    <div class="form-group row">
      <!-- Select Book -->
      <?php include("../controllers/booksSelectID.php");?>
    </div>
    <div class="form-group row">
      <!-- Show selected Book Details -->
      <?php include("../controllers/booksShowSelected.php");?>
    </div>
    <div class="form-group row">
      <!-- Enter Return Date -->
      <?php include("../controllers/booksReturnDue.php");?>
      <!-- Issue Book -->
      <?php include("../controllers/booksIssuedAdd.php");?>
    </div>
  </form>
</div>
