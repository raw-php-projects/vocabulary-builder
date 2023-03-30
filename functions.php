<?php
// Define Const
define("ROOT_URL", "index.php");

// Connect Database
include_once "config.php";
$con = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );

if( ! $con ){
  throw new Exception("Database not connected");
  exit();
}

// getWordsByUserId() Get words by user id
function getWordsByUserId( $user_id ){
  $query = "SELECT * FROM words WHERE user_id = {$user_id}";
  global $con;
  $result = mysqli_query($con, $query);

  $words = [];
  while( $_data = mysqli_fetch_assoc($result) ){
    array_push($words, $_data);
  }
  return $words;
}

// Get user Email
function getUserEmail( $user_id ){
  $query = "SELECT * FROM users WHERE id = {$user_id}";

  global $con;
  $result = mysqli_query($con, $query);
  $email = mysqli_fetch_assoc($result);
  return $email['email'];
}

// Define Diffrent Status message in a array
$status = [
  "0" => "",
  "required" => "Email or Password is empty",
  "invalid" => "Invalid email format",
  "created" => "User Registerd Successfully",
  "userexist" => "User already exist with provided email",
  "notcorrect" => "Password is not correct",
  "notfound" => "User not found with this email",
  "wordadded" => "Word added successfully",
  "wordrequired" => "Word or Meanig is empty",
];

// Redirect Helper Function
function redirect( $url = 'index.php', $status = '' ){
  $status = $status ? "?status=". $status : '';
  $buildURL = $url . $status;
  header("Location: {$buildURL}");
  exit();
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