<?php

/*** begin our session ***/
session_start();

$programname = $_GET['programname'];
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

include("include/db.php");

try {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   if ( strlen($programname) > 0 ) {

      /*** prepare the select statement ***/
      $stmt = $dbh -> prepare("SELECT programid AS :programid FROM program 
                    WHERE programname = :programname;");

      /*** bind the parameters ***/
      $programid = "";
      $stmt -> bindParam(':programname', $programname, PDO::PARAM_STR);
      $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);

      /*** execute the prepared statement ***/
      $stmt -> execute();   
      $programid = $stmt -> fetchColumn(0);
      
   } else if ( strlen($userid) > 0 ) {
   
      /*** prepare the select statement ***/
      $stmt = $dbh -> prepare("
         SELECT MAX(pu.programid) AS :programid,
            p.programname AS :programname 
         FROM programuser pu, program p
         WHERE pu.userid = :userid
          AND  p.programid = pu.programid;");

      $programid = "";
			$programname = "";
      $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
      $stmt -> bindParam(':programname', $programname, PDO::PARAM_STR);
      $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
      $stmt -> execute();
      $programid = $stmt -> fetchColumn(0);
      $stmt -> execute();
      $programname = $stmt -> fetchColumn(1);

   } else if ( strlen($username) > 0 ) {
   
      /*** prepare the select statement ***/
      $stmt = $dbh -> prepare("
         SELECT MAX(pu.programid) AS :programid,
            p.programname AS :programname 
         FROM programuser pu, program p, user u
         WHERE u.username = :username
          AND  u.userid = pu.userid
          AND  p.programid = pu.programid;");

      $programid = "";
			$programname = "";
      $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
      $stmt -> bindParam(':programname', $programname, PDO::PARAM_STR);
      $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
      $stmt -> execute();
      $programid = $stmt -> fetchColumn(0);
      $stmt -> execute();
      $programname = $stmt -> fetchColumn(1);

   } else {
   
      /*** prepare the select statement ***/
      $stmt = $dbh -> prepare("
         SELECT programid AS :programid,
            programname AS :programname
         FROM program
         WHERE isdefault = TRUE;");

      $programid = "";
      $programname = "";
      $stmt -> bindParam(':programname', $programname, PDO::PARAM_STR);
      $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
      $stmt -> execute();
      $programid = $stmt -> fetchColumn(0);
      $stmt -> execute();
      $programname = $stmt -> fetchColumn(1);

   }
      
   /*** set the session user_id variable ***/
   $_SESSION['programname'] = $programname;
   $_SESSION['programid'] = $programid;

   /*** tell the user we are logged in ***/
   $message = 'You are now logged in';
   header('Location: index.php');

} catch(Exception $e) {
   /*** if we are here, something has gone wrong with the database ***/
   $message = 'We are unable to process your request. Please try again later -->'.$e;
}
?>

<html lang="en">
<head>
   <title>Progam Page</title>
   
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
   <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
   <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>

<style>
</style>

<body>

   <div data-role="header">
       <h1>Registration Page</h1>
   </div>        

   <textarea disabled="disabled" data-mini="true" cols="40" rows="8" name="textarea-4" id="textarea-4">
      
<?php echo "Program selection attempt for ".$programname."-".$userid." failed. ".$message; ?>

   </textarea>

</body>
</html>
