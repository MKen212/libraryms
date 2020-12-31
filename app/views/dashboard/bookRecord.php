<!-- DASHBOARD - Selected Book Record Details -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th>Book ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Author</th>
        <th>Publisher</th>
        <th>ISBN</th>
        <th>Qty Available</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td><?= $bookRecord["BookID"] ?></td>
        <td><img class="img-thumbnail" style="width:105px; height:165px" src="<?= getFilePath($bookRecord["BookID"], $bookRecord["ImgFilename"]) ?>" alt="<?= $bookRecord["ImgFilename"] ?>" /></td>
        <td><?= $bookRecord["Title"] ?></td>
        <td><?= $bookRecord["Author"] ?></td>
        <td><?= $bookRecord["Publisher"] ?></td>
        <td><?= $bookRecord["ISBN"] ?></td>
        <td><?= $bookRecord["QtyAvail"] ?></td>
      </tr>
    </tbody>
  </table>
  <input type="hidden" name="qtyAvail" value="<?= $bookRecord["QtyAvail"] ?>" />
</div>