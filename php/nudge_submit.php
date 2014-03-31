<?php

include("include/session.php");

$programid = $_GET['programid'];
$userid = $_GET['userid'];
$rulename = $_GET['rulename'];
$msgtxt = $_GET['msgtxt'];
$urldesc = $_GET['urldesc'];
$urllabel = $_GET['urllabel'];
$urltype = $_GET['urltype'];
//$urltypestr = "programurl.php?urltype=".$urltype;

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // To do need to get generated msgid and write it to the programurl table to associate msg to programurl

   if (strlen($userid) > 0 ) {
      $stmt = $dbh -> prepare("
      INSERT INTO msg (
         programid,
         userid,
         rulename,
         msgtxt,
         issent,
         isread,
         urldesc
      ) VALUES (
         :programid,
         :userid,
         :rulename,
         :msgtxt,
         0,
         0,
         :urldesc)"); 
      $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);

   } else {
     $stmt = $dbh -> prepare("
      INSERT INTO msg (
         programid,
         userid,
         rulename,
         msgtxt,
         issent,
         isread,
         urldesc) 
      SELECT
         :programid,
         pu.userid,
         :rulename,
         :msgtxt,
         0,
         0,
         :urldesc
      FROM programuser pu
      WHERE programid = :programid
        ");
   }
      
   /*** bind the parameters ***/
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':rulename', $rulename, PDO::PARAM_STR);
   $stmt -> bindParam(':msgtxt', $msgtxt, PDO::PARAM_STR);
//   $stmt -> bindParam(':urltypestr', $urltypestr, PDO::PARAM_STR);
   $stmt -> bindParam(':urldesc', $urldesc, PDO::PARAM_STR);
            
   $stmt -> execute();
   $mcount = $stmt->rowCount();
   if ( $mcount != 1 ) {
      $_SESSION['message'] = 'Failed to insert msg';
      header("Location: error.php");      
   }
   header('Location: programuser.php?roletype=participant');

} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");
}
?>


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
       <h1>User Diary Page</h1>
   </div>        

   <textarea disabled="disabled" data-mini="true" cols="40" rows="8" name="textarea-4" id="textarea-4">
      
<?php echo "Observation attempt for userid=".$userid." in program=".$programid." for obsname=" .$obsname. " with entry=".$obsvalue." failed. ".$message; ?>

   </textarea>


</body>
</html>
          