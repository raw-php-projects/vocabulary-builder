<?php

// Check if form submited manually
$form_action = $_POST['action'] ?? '';
if( empty($form_action) ) header("Location: index.php");

// Include functions.php
include_once "functions.php";

// Connect Database
include_once "config.php";
$con = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );

if( ! $con ){
  throw new Exception("Database not connected");
}else{
  if( "register" == $form_action ){

    // Register User
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    #Return true if email is valid
    if( email_check( $email, $password ) ){
      $val_email = email_check( $email, $password );
      $_hash_password = password_hash( $password, PASSWORD_BCRYPT );
      $query = "INSERT INTO users(email, password) VALUE('{$email}', '{$_hash_password}')";
      mysqli_query( $con, $query );
      mysqli_close($con);
      header("Location: ". ROOT_URL ."?status=created");
    }else{
      // Redirect to home page with status
      email_check( $email, $password );
    }
    
  }
}