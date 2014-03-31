<?php

include("include/session.php");

$urldesc = $_GET['urldesc'];
$urllabel = $_GET['urllabel'];
$urltype = $_GET['urltype'];
$urlname = $_GET['urlname'];

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      INSERT INTO programurl (
         programid,
         urltype,
         urlname,
         urllabel,
         urldesc
      ) VALUES (
         :programid,
         :urltype,
         :urlname,
         :urllabel,
         :urldesc)");          

   if ($urlname == "") { $urlname = 'html'; }
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':urltype', $urltype, PDO::PARAM_STR);
   $stmt -> bindParam(':urllabel', $urllabel, PDO::PARAM_STR);
   $stmt -> bindParam(':urlname', $urlname, PDO::PARAM_STR);
   $stmt -> bindParam(':urldesc', $urldesc, PDO::PARAM_STR);
            
   $stmt -> execute();            
   header('Location: programurl.php?urltype='.$urltype);

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
          