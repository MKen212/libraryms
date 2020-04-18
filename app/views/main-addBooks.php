<!-- Add Books Page -->
<!-- Let Browser handle JavaScipt error checks -->
<div class="pt-3 pb-2 mb-3 border-bottom">
  <h1 class="h2">Add Books</h1>
</div>

<!-- Add Books Form -->
<div>
  <form class="ml-3" action="" enctype="multipart/form-data" method="POST" name="addBooksForm">
    <!-- Title -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="title">Title:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="title" id="title" placeholder="Enter Title" autocomplete="off" required autofocus />
      </div>
    </div>
    <!-- Author -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="author">Author:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="author" id="author" placeholder="Enter Author" autocomplete="off" required />
      </div>
    </div>
    <!-- Publisher -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="publisher">Publisher:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="publisher" id="publisher" placeholder="Enter Publisher" autocomplete="off" required />
      </div>
    </div>
    <!-- ISBN -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="ISBN">ISBN:</label>
      <div class="inpFixed">
        <input class="form-control" type="text" name="ISBN" id="ISBN" placeholder="Enter ISBN (Format: ###-#-###-#####-#)" pattern="(?:(?=.{17}$)97[89][ -](?:[0-9]+[ -]){2}[0-9]+[ -][0-9]|97[89][0-9]{10}|(?=.{13}$)(?:[0-9]+[ -]){2}[0-9]+[ -][0-9Xx]|[0-9]{9}[0-9Xx])" autocomplete="off" />
      </div>
    </div>
    <!-- Price GBP -->
    <div class="form-group row">
      <label class="col-form-label labFixed" for="priceGBP">Book Price (GBP):</label>
      <div class="inpFixed">
        <input class="form-control" type="number" name="priceGBP" id="priceGBP" placeholder="Enter Book Price in GBP" min="0" step="0.01" autocomplete="off" />
      </div>
    </div>
    <!-- Image Filename -->
    <div class="form-group row">
      <label class="col-form-label labFixed">Book Image:</label>
      <div class="custom-file inpFixed">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo DEFAULTS['maxUploadSize'];?>" />
        <input type="file" class="custom-file-input" name="imgFilename" id="imgFilename">
        <label class="custom-file-label" for="imgFilename">Choose file</label>
      </div> 
    </div>
    <div class="form-group row">
      <!-- Submit Button -->
      <div class="col-form-label labFixed">
        <button class="btn btn-primary" type="submit" name="addBook">Add Book</button>
      </div>
      <!-- Results -->
      <div class="inpFixed">
        <?php include("../controllers/booksAdd.php");?>
      </div>
    </div>
  </form>
</div>
