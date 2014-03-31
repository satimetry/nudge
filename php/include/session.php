<?php

/*** begin our session ***/
session_start();

$userid = "";
$programid = "";

if ( isset($_GET['userid']) ) {
   $userid = $_GET['userid'];
} else if ( isset($_SESSION['userid']) ) {
   $userid = $_SESSION['userid'];
}    
if ( isset($_GET['programid']) ) {
   $programid = $_GET['programid'];
} else if ( isset($_SESSION['programid']) ) {
   $programid = $_SESSION['programid'];
}  

if ( isset($_SESSION['programname']) ) {
   $programname = $_SESSION['programname'];
}  
if ( isset($_SESSION['username']) ) {
   $username = $_SESSION['username'];
}  

$roletype = 'participant';
if ( isset($_GET['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} else if ( isset($_SESSION['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 

if ( strlen($userid) < 1 || strlen($programid) < 1 ) {
   $message = 'You must be logged in to access this page';
   header('Location: login.php');
}

define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
define('DB_PORT', getenv('OPENSHIFT_MYSQL_DB_PORT'));
define('DB_USER', getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
define('DB_PASS', getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
define('DB_NAME', getenv('OPENSHIFT_GEAR_NAME'));

/*** connect to database ***/
/*** mysql hostname ***/
$mysql_hostname = DB_HOST;
if (empty($mysql_hostname)) {
   $mysql_hostname = '127.0.0.1';
}

/*** mysql username ***/
$mysql_username = DB_USER;
if (empty($mysql_username)) {
   $mysql_username = 'root';
}

/*** mysql password ***/
$mysql_password = DB_PASS;
if (empty($mysql_password)) {
   $mysql_password = '';
}

/*** database name ***/
$mysql_dbname = DB_NAME;
if (empty($mysql_dbname)) {
   $mysql_dbname = 'nudge';
}
?>
