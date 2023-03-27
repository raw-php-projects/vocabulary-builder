<?php

// Define Const
define("ROOT_URL", "index.php");

// Define Diffrent Status message in a array
$status = [
  "0" => "",
  "required" => "Email Or Password is required",
  "invalid" => "Invalid email format",
  "created" => "User Registerd Successfully",
];

// Email Validation #Check if the email format is valide
function email_check( $email, $password = "" ){  
  if( empty($email) || empty($password) ) {
    header("Location: ". ROOT_URL ."?status=required");
  }else{
    $trim = validate_input($email);
    if( !filter_var($trim, FILTER_VALIDATE_EMAIL ) ) {
      header("Location: ". ROOT_URL ."?status=invalid");
    }
  }
  return $email;
}

// Validate input
function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}