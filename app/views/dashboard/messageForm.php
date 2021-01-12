

      
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Send Message</h1>
</div>
<!-- Send Message Form -->
<div>
  <form class="ml-3" action="" method="POST" name="sendMsgForm">
    <div class="form-group row">
      <!-- Select User -->
      <label class="col-form-label labFixed" for="recipientSelect">Select Recipient:</label>
      <div class="input-group inpFixed">
        <select class="form-control" id="recipientSelect" name="userIDSelected">
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
      <!-- Enter Message -->
      <?php include("../controllers/messagesEnter.php");?>
      <!-- Send Message -->
      <?php include("../controllers/messagesSend.php");?>
    </div>
  </form>
</div>
      