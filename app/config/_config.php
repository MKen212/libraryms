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
  "testing" => true,  // Flag to set whether to show test information
  "maxUploadSize" => 200000,  // Maximum PHP upload file size in bytes - see phpInfo
  "booksImgPath" => "uploads/imgBooks/",  // Path to books images
  "noImgUploaded" => "images/noImage.jpg" ,  // Default Image if no image file uploaded
  "currency" => "CHF",  // Default Currency
  "booksDisplayCols" => 3,  // Number of Columns for Books Display
  "returnDuration" => 14,  // Issued Book Return Duration
  "userAdminUserID" => 1,  // UserID for User Management Administrator
];

define("DEFAULTS", $defaultValues);

/* Status Codes */
$statusCodes = [
  "RecordStatus" => [  // All Tables / RecordStatus Field
    0 => [
      "text" => "Inactive",
      "badge" => "danger",
    ],
    1 => [
      "text" => "Active",
      "badge" => "success",
    ],
  ],
  "IsAdmin" => [  // users Table / IsAdmin Field
    0 => [
      "text" => "No",
      "badge" => "secondary",
    ],
    1 => [
      "text" => "Yes",
      "badge" => "primary",
    ],
  ],
  "UserStatus" => [  // users Table / UserStatus Field
    0 => [
      "text" => "UnApproved",
      "badge" => "danger",
    ],
    1 => [
      "text" => "Approved",
      "badge" => "success",
    ],
  ],
];

define("STATUS_CODES", $statusCodes);

?>