<?php
/**
 * Global Configuration Details
 */

/* Database Connection */
$connDetails = parse_ini_file("../inifiles/mariaDBCon.ini");
$connDetails["database"] = "libraryms";

define("DBSERVER", $connDetails);

/* Default Values */
$defaultValues = [
  "maxUploadSize" => 2000000,  // Maximum PHP upload file size in bytes - see phpInfo
  "booksImgPath" => "uploads/imgBooks/",  // Path to books images
  "noImgUploaded" => "images/noImage.jpg" ,  // Default Image if no image file uploaded
  "booksDisplayCols" => 3,  // Number of Columns for Books Display
  "returnDuration" => 14,  // Issued Book Return Duration
  "userAdminUserID" => 2,  // UserID for User Management Administrator
];

define("DEFAULTS", $defaultValues);
?>