<!-- DASHBOARD - Message Form -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">Send a Message</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>
<div>

<form class="ml-3" action="" method="post" name="messageForm" autocomplete="off">
  <!-- Select Recipient -->
  <div class="form-group row">
    <label class="col-form-label labFixed" for="recipientSelect">Select Recipient:</label>
    <div class="input-group inpFixed">
      <select class="form-control" id="recipientSelect" name="userIDSelected">
        <!-- List all UserID: UserNames --><?php
        userOptions($messageRecord["ReceiverID"]); ?>
      </select>
      <div class="input-group-append">
        <button class="btn btn-primary" type="submit" name="selectUser">Select</button>
      </div>
    </div>
  </div><?php
  // Show Selected User Record
  if (!empty($userRecord)) : ?>
    <div class="form-group row pr-3"><?php
      include "../app/views/dashboard/userRecord.php"; ?>
    </div>
    <!-- Subject -->
    <div class="form-group row pr-3">
      <label class="col-form-label labFixed" for="subject">Subject:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="subject" id="subject" maxlength="40" placeholder="Enter Subject" value="<?= $messageRecord["Subject"] ?>" required />
      </div>
    </div>
    <!-- Body -->
    <div class="form-group row pr-3">
      <label class="col-form-label labFixed" for="body">Message:</label>
      <div class="inpFixed">
        <textarea class="form-control" name="body" id="body" rows="5" placeholder="Enter Message" maxlength="500" required><?= $messageRecord["Body"] ?></textarea>
      </div>
    </div>
    <!-- Submit Button -->
    <div class="form-group row pt-3 mr-2 border-top">
      <div class="col-form-label labFixed">
        <button class="btn btn-primary" type="submit" name="sendMessage" id = "sendMessage">Send Message</button>
      </div>
      <div class="inpFixed"></div>
    </div><?php
  endif; ?>
</form>