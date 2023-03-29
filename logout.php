<?php 
session_start();    
require_once "functions.php";

// Log out user
$_SESSION['id'] = 0;
session_destroy();

// Redirect user after logout
redirect('index.php');