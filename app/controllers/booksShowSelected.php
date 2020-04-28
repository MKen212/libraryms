<?php  // Show Selected Book ID
include_once("../models/bookClass.php");
$book = new Book();

if (isset($_POST["selectBook"]) || isset($_POST["issueBook"])) {
  $selBook = $book->getBookByID($_POST["bookIDSelected"]);
  echo "<table class='table table-striped table-sm'>
    <thead>
      <th>Book ID</th>
      <th>Title</th>
      <th>Author</th>
      <th>Publisher</th>
      <th>ISBN</th>
    </thead>
    <tbody>
      <tr>
        <td>" . $selBook["BookID"] . "</td>
        <td>" . $selBook["Title"] . "</td>
        <td>" . $selBook["Author"] . "</td>
        <td>" . $selBook["Publisher"] . "</td>
        <td>" . $selBook["ISBN"] . "</td>
      </tr>
    </tbody>
  </table>";
}

?>

