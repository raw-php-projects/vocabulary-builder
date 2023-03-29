<?php
session_start();

// Get Form action
$form_action = $_POST['action'] ?? '';

// Include functions.php
include_once "functions.php";

// Connect Database
include_once "config.php";
$con = mysqli_connect( DB_HOST, DB_USER, DB_PASS, DB_NAME );

if( ! $con ){
  throw new Exception("Database not connected");
  exit();
}else{
  if( "register" == $form_action ){
    // Register User
    $email = $_POST['email'] ?? '';
    $password = validate_input( $_POST['password'] ) ?? '';
    
    // Check if email and password is not empty
    if( !empty($email) && !empty($password) ){      

      // Redirect to if email format is not valid
      $valid_email = email_check( $email );
      if( ! $valid_email ){
        redirect("index.php", "invalid");
      }

      $_hash_password = password_hash( $password, PASSWORD_BCRYPT );

      // Query
      $query = "INSERT INTO users(email, password) VALUES('{$valid_email}', '{$_hash_password}')";
      mysqli_query( $con, $query );
      
      // check if user exist
      if( mysqli_error($con) ){
        echo mysqli_error($con);
        redirect("index.php", "userexist");
      }

      // Close connection and redirect
      mysqli_close($con);
      redirect("index.php", "created");
    }else{
      // If empty Redirect with status
      redirect("index.php", "required");
    }
    
  }else if( "login" == $form_action ){
    // Login
    $email = validate_input($_POST['email']) ?? '';
    $password = $_POST['password'] ?? '';
    
    // Check if email and password is not empty
    if( !empty($email) && !empty($password) ){

      // Redirect to if email format is not valid
      $valid_email = email_check( $email );
      if( ! $valid_email ){
        redirect("login.php", "invalid");
      }

      $query = "SELECT id, password FROM users WHERE email = '{$email}'";
      $result = mysqli_query( $con, $query );

      if( mysqli_num_rows($result) > 0 ){
        $user = mysqli_fetch_assoc($result);
        $user_hash_pass = $user['password']; 
        $_id = $user['id'];

        if( password_verify($password, $user_hash_pass) ){
          $_SESSION['id'] = $_id;
          redirect("words.php");
        }else{
          redirect("login.php", "notcorrect");
        }

      }else{
        redirect("login.php", "notfound");
      }
    }else{
      // If empty Redirect to login page with status
      redirect("login.php", "required");
    }
  }else{
    // Redirect user if without form submit
    redirect("index.php");
  }
}