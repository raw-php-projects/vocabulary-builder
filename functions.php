<?php

// Define Const
define("ROOT_URL", "index.php");

// Define Diffrent Status message in a array
$status = [
  "0" => "",
  "required" => "Email Or Password is required",
  "invalid" => "Invalid email format",
  "created" => "User Registerd Successfully",
  "userexist" => "User already exist with provided email",
  "notcorrect" => "Password is not correct",
  "notfound" => "User not found with this email",
];

// Redirect Helper Function
function redirect( $url = 'index.php', $status = '' ){
  $status = $status ? "?status=". $status : '';
  $buildURL = $url . $status;
  header("Location: {$buildURL}");
  die();
}

// Email Validation #Check if the email format is valide
function email_check( $email ){  
    $trim = validate_input($email);
    $validate = filter_var($trim, FILTER_VALIDATE_EMAIL );
    return $validate;
}

// Validate input
function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}