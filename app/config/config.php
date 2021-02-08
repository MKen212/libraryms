<?php
declare(strict_types=1);
/**
 * Global Configuration Details
 *
 * For the full copyright and license information, please view the
 * {@link https://github.com/MKen212/libraryms/blob/master/LICENSE LICENSE}
 * file that was included with this source code.
 */

namespace LibraryMS;

/* Database Connection */
$connDetails = parse_ini_file("../inifiles/mariaDBCon.ini");
$connDetails["database"] = "libraryms";

/**
 * Database connection details
 */
define("\LibraryMS\DBSERVER", $connDetails);

/* Default Values */
$defaultValues = [
  "testing" => true,  // Flag to set whether to show test information
  "maxUploadSize" => 200000,  // Maximum PHP upload file size in bytes - see phpInfo
  "booksImgPath" => "uploads/imgBooks/",  // Path to books images
  "noImgUploaded" => "images/noImage.jpg" ,  // Default Image if no image file uploaded
  "currency" => "CHF",  // Default Currency
  "returnDuration" => 14,  // Issued Book Return Duration
  "userAdminUserID" => 1,  // UserID for User Management Administrator
];

/**
 * Application default values
 */
define("\LibraryMS\DEFAULTS", $defaultValues);

/* Valid Pages */
$validPages = [
  "index" => [
    "login",
    "logout",
    "register",
  ],
  "dashboard" => [
    "home",
    "myMessages",
    "displayBooks",
    "booksIssuedByBook",
    "myIssuedBooks",
    "sendMessage",
    "myProfile",
  ],
  "dashboard_admin" => [
    "issueBook",
    "listReturnIssuedBooks",
    "addBook",
    "listEditBooks",
    "bookDetails",
    "listEditUsers",
    "userDetails",
  ],
];

/**
 * Valid pages used within INDEX and DASHBOARD frames
 */
define("\LibraryMS\VALID_PAGES", $validPages);

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
  "MessageStatus" => [  // messages Table / MessageStatus Field
    0 => [
      "text" => "UnRead",
      "badge" => "info",
    ],
    1 => [
      "text" => "Read",
      "badge" => "light",
    ],
  ],
];

/**
 * Output Text and Badge Class for each valid Status Field / Status Code
 */
define("\LibraryMS\STATUS_CODES", $statusCodes);
