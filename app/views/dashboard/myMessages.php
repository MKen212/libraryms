<?php
/**
 * DASHBOARD/myMessages view - List of messages records for specific user
 */

include_once "../app/models/messageReceivedRowClass.php";
include_once "../app/models/messageSentRowClass.php";

?>
<!-- My Messages List -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <div class="row">
    <!-- Title -->
    <div class="col-6">
      <h1 class="h2">My Messages</h1>
    </div>
    <!-- System Messages -->
    <div class="col-6"><?php
      msgShow(); ?>
    </div>
  </div>
</div>

<!-- Received Messages - Table -->
<div class="table-responsive">
  <h3>Received:</h3>
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th style="width:180px">Received</th>
        <th>From</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Status</th>
        <th>Reply</th>
      </tr>
    </thead>
    <tbody><?php
      if (empty($receivedMessageList)) :  // No received messages records found ?>
        <tr>
          <td colspan="6">No Received Messages to Display</td>
        </tr><?php
      else :
        // Loop through the received messages records and output the values
        foreach (new MessageReceivedRow(new RecursiveArrayIterator($receivedMessageList)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>
<hr />

<!-- Sent Messages - Table -->
<div class="table-responsive">
  <h3>Sent:</h3>
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th style="width:180px">Sent</th>
        <th>To</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Status</th>
        <th>Record</th>
      </tr>
    </thead>
    <tbody><?php
      if (empty($sentMessageList)) :  // No sent messages records found ?>
        <tr>
          <td colspan="6">No Sent Messages to Display</td>
        </tr><?php
      else :
        // Loop through the sent messages records and output the values
        foreach (new MessageSentRow(new RecursiveArrayIterator($sentMessageList)) as $value) :
          echo $value;
        endforeach;
      endif; ?>
    </tbody>
  </table>
</div>
