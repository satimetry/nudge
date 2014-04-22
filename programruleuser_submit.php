<?php

include("include/session.php");

if ( isset($_GET['crudtype']) ) {
	$crudtype = $_GET['crudtype'];
} else {
	$crudtype = "read";	
}

$ruleid = $_GET['ruleid'];
$rulevalue = $_GET['rulevalue'];

$ruletype = $_GET['ruletype'];
  
try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	 if ( $crudtype == "read" ) {
	 	
   	/*** prepare the select statement ***/
   	$stmt = $dbh -> prepare("
         UPDATE programruleuser
            SET rulevalue = :rulevalue
          WHERE programid = :programid
            AND  userid = :userid
            AND  ruleid = :ruleid;
         ");

   	/*** bind the parameters ***/ 
   	$stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   	$stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulevalue', $rulevalue, PDO::PARAM_STR, 40);

   	/*** execute the prepared statement ***/
   	$stmt -> execute();
      if ( strpos($ruletype, 'gas') !== false ) {
        header( "Location: programgoal.php?ruletype=gashigh" );
      } else {
        header( 'Location: programruleuser.php?ruletype='.$ruletype );       
      }	 
    } else if ( $crudtype == "update" ) {
	 		
	 	$rulehigh = $_GET['rulehigh'];
		$rulelow = $_GET['rulelow'];
      $ruleuserdesc = $_GET['ruleuserdesc'];
	 	
   	/*** prepare the select statement ***/
   	$stmt = $dbh -> prepare("
         UPDATE programruleuser
            SET rulevalue = :rulevalue,
                rulehigh = :rulehigh,
                rulelow = :rulelow,
                ruleuserdesc = :ruleuserdesc
          WHERE programid = :programid
            AND  userid = :userid
            AND  ruleid = :ruleid;
         ");

   	/*** bind the parameters ***/ 
   	$stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   	$stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulevalue', $rulevalue, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulehigh', $rulehigh, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulelow', $rulelow, PDO::PARAM_STR, 40);
      $stmt -> bindParam(':ruleuserdesc', $ruleuserdesc, PDO::PARAM_STR, 40);
   	   
   	/*** execute the prepared statement ***/
   	$stmt -> execute();
 
    if ( strpos($ruletype, 'gas') !== false ) {
   	  header( "Location: programgoal.php?ruletype=gashigh" );
		} else {
		  header( 'Location: programruleuser.php?ruletype='.$ruletype );   	  
		}
				
	 } else if ( $crudtype == "create" ) {
	 	
   	/*** prepare the select statement ***/
   	$stmt = $dbh -> prepare("
         INSERT INTO programruleuser (
          programid,
         	ruleid,
         	userid,
         	rulevalue,
         	ruletype,
         	rulehigh,
         	rulelow
         ) VALUES (
         	:programid,
         	:ruleid,
         	:userid,
         	1,
         	'user',
         	:rulehigh,
         	:rulelow
         "); 

    $rulehigh = $_GET['rulehigh'];
		$rulelow = $_GET['rulelow'];
		
   	/*** bind the parameters ***/ 
   	$stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   	$stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulehigh', $rulehigh, PDO::PARAM_STR, 40);
   	$stmt -> bindParam(':rulelow', $rulelow, PDO::PARAM_STR, 40);

   	/*** execute the prepared statement ***/
   	$stmt -> execute();
      
   	header( 'Location: programruleuser.php' );	 			 	
	 }
	 
} catch(Exception $e) {
  $_SESSION['message'] = ' We are unable to process your request. Please try again later...'.$e;
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
      <title>Program Rule User Page</title>

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
      
<?php echo "Rule update attempt for rule " . $ruleid . " and program " . $programid . " and user " . $userid . " and value " . $rulevalue + " failed. " . $message; ?>

   </textarea>         
         
      </body>
</html>
