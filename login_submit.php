<?php

/*** begin our session ***/
session_start();

$_SESSION['username'] = "";
$_SESSION['userid'] ="";
$_SESSION['programname'] = "";
$_SESSION['programid'] ="";
$_SESSION['roletype'] ="";
           
$programname = $_GET['programname'];
$programid = $_GET['programid'];
$username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_GET['password'], FILTER_SANITIZE_STRING);

include("include/db.php");

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /*** prepare the select statement ***/
   $stmt = $dbh -> prepare("
      SELECT 
         u.userid AS :userid,
         pu.roletype AS :roletype      
      FROM user u, programuser pu, program p
      WHERE pu.userid = u.userid
        AND p.programid = pu.programid
        AND p.programid = :programid
        AND pu.programid = :programid
        AND u.username = :username
        AND u.password = :password");
   
   /*** bind the parameters ***/

   $userid = "";
   $roletype = "";
   
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':password', $password, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':roletype', $roletype, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $pucount = $stmt->rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);   
   
   $userid = $row[0];
   $roletype = $row[1];
         
   if ( $pucount == 1 ) {

      $_SESSION['userid'] = $userid;
      $_SESSION['username'] = $username;
      $_SESSION['programid'] = $programid;
      $_SESSION['programname'] = $programname;
      $_SESSION['roletype'] = $roletype;
      
   } else {
      $_SESSION['message'] = 'To use this system please enrol or enter a valid username and password';
      header("Location: error.php");
      exit;
   }

   $rule = "login";
   include("include/pointcount.php");
   include("include/refresh.php");
   
   $stmt = $dbh -> prepare("
      SELECT COUNT(msgid)
      FROM msg m2
      WHERE m2.programid = :programid
       AND  m2.userid = :userid
      ;");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
    
   $stmt->execute();
   $mcount = $stmt->rowCount();
   if ( $mcount == 0 || $roletype != "participant" ) {
      header("Location: index.php"); 
   } else {
      header("Location: splash.php");       
   }
     
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");
}
?>

<!doctype html>
<!--[if IE 7 ]>       <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>       <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>       <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en-US">
   <!--<![endif]-->

<html lang="en">
   <head>
      <title>Login Submit Page</title>

      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

      <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
      <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
      <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>

      <style>
      </style>

      <body>

         <div data-role="header">
            <h1>Login Submit Page</h1>
         </div>
         <textarea disabled="disabled" data-mini="true" cols="40" rows="8" name="textarea-4" id="textarea-4">
      
<?php echo "Login attempt for userid=" . $userid . " and username=" . $username . " and password=" . $password . " and programname=" . $programname . " and programid=" .$programid . " failed. " . $message.$e; ?>

   </textarea>                  
         
      </body>
</html>
