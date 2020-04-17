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
  "TBA" => "TBAValue",  // TBA
];

define("DEFAULTS", $defaultValues);

?>