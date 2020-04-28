<?php
/**
 * Global Configuration Details
 */

/* Database Connection */
$connDetails = parse_ini_file("/var/www/privnet/inifiles/mariaDBCon.ini");
$connDetails["database"] = "libraryms";

define("DBSERVER", $connDetails);

/* Default Values */
$defaultValues = [
  "maxUploadSize" => 2000000,  // Maximum PHP upload file size in bytes - see phpInfo
  "booksImgPath" => "../../uploads/imgBooks/",  // Path to books images
  "returnDuration" => 14,  // Issued Book Return Duration
];

define("DEFAULTS", $defaultValues);

?>