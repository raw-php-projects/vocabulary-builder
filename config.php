<?php

// Database Details
define( "DB_HOST", "localhost" );
define( "DB_NAME", "vocabulary-builder" );
define( "DB_USER", "root" );
define( "DB_PASS", "" );

/* activate reporting */
$driver = new mysqli_driver();
$driver->report_mode = MYSQLI_REPORT_OFF;