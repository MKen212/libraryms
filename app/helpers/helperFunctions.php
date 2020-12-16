<?php  // Global Helper Functions

/**
 * cleanInput function - Used to clean all manual data entry
 * @param string $input    Original Input
 * @param string $type     Input Type (string, int, float, email, password)
 * @return string $output  Cleaned Input
 */
function cleanInput($input, $type) {
  // Clean all with htmlspecialchars
  $output = htmlspecialchars($input);
  if ($type == "string") {
    $output = trim($output);
    $output = str_replace("\n", "^~",$output);  // Keep CRLF as ^~
    $output = stripslashes($output);
    $output = filter_var($output, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
  } elseif ($type == "int") {
    $output = filter_var($output, FILTER_SANITIZE_NUMBER_INT);
  } elseif ($type == "float") {
    $output = filter_var($output, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
  } elseif ($type = "email") {
    $output = filter_var($output, FILTER_SANITIZE_EMAIL);
  }
  return $output;
}

/**
 * msgPrep function - Used to prepare system messages for display
 * @param string $type       Type of message (success / warning / danger)
 * @param string $msg        Message Content
 * @return string $prepdMsg  Prepared Message
 */
function msgPrep($type, $msg) {
  if ($type == "success") {
    $prepdMsg = "<div class='alert alert-success'>{$msg}</div>";
  } elseif ($type == "warning") {
    $prepdMsg = "<div class='alert alert-warning'>{$msg}</div>";
  } elseif ($type == "danger") {
    $prepdMsg = "<div class='alert alert-danger'>{$msg}</div>";
  }
  return $prepdMsg;
}

/**
 * msgShow function - Used to display Session["Message"] & then clear it
 * @return bool  Returns true on completion
 */
function msgShow() {
  if (!empty($_SESSION["message"])) {
    echo $_SESSION["message"];
    unset($_SESSION["message"]);
  }
  return true;
}

/**
 * postValue function - Returns the value in a $_POST key field IF it's set
 * @param string $key            Name of $_POST["key"] to return
 * @param string $default        Default value to return if "key" NOT set (optional)
 * @return string $_POST["key"]  Returns $_POST["key"] value or default/NULL
 */
function postValue($key, $default = null) {
  if (isset($_POST["$key"])) {
    return $_POST["$key"];
  } else {
    return $default;
  }
}

/**
 * statusOutput function - Returns the HTML output relevant to the given status code
 * @param string $type           Status Type (from Config/StatusCodes)
 * @param int $status            Status Code
 * @param string $link           HREF Link (Optional)
 * @return string $statusOutput  Returns the HTML output for the Status Code
 */
function statusOutput($type, $status, $link = null) {
  $text = STATUS_CODES[$type][$status]["text"];
  $badge = STATUS_CODES[$type][$status]["badge"];
  $statusOutput = "<a class='badge badge-{$badge}' href='{$link}'>{$text}</a>";
  return $statusOutput;
}

?>