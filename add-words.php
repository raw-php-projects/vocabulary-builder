<?php
session_start();

// Get Form action
$form_action = $_POST['action'] ?? '';

// Include functions.php
include_once "functions.php";

// Connect Database
include_once "config.php";
$con = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );
mysqli_set_charset($con, 'utf8');

if( ! $con ){
  throw new Exception("Database not connected");
  exit();
}else{
  if( "add-word" == $form_action ){
    // Add Word
    $word = validate_input( $_POST['word'] ) ?? '';
    $meaning = validate_input( $_POST['meaning'] ) ?? '';
    $user_id = $_SESSION['id'];
    
    // Check if email and password is not empty
    if( !empty($word) && !empty($meaning) ){

      // Query
      $query = "INSERT INTO words(user_id, word, meaning) VALUES('{$user_id}', '{$word}', '{$meaning}')";
      mysqli_query( $con, $query );

      // Close connection and redirect
      mysqli_close($con);
      redirect("words.php", "wordadded");
    }else{
      // If empty Redirect with status
      redirect("words.php", "wordrequired");
    }
    
  }
}