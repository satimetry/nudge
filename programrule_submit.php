<?php

include("include/session.php");

$ruleid = $_GET['ruleid'];
$rulepoint = $_GET['rulepoint'];
$pollname = $_GET['pollname'];

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $stmt = $dbh -> prepare("
      INSERT INTO programrule (
         programid,
         ruleid,
         rulehigh,
         rulelow,
         rulepoint
      ) VALUES (
         :programid,
         :ruleid,
         0,
         0,
         :rulepoint)");          

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':rulepoint', $rulepoint, PDO::PARAM_STR);   
   
   $stmt -> execute();  

   $count = $stmt -> rowCount();
   
   if ( $count < 1 ) {
      $_SESSION['message'] = 'Failed to insert programrule';
      header("Location: error.php");
   }      
            
   $stmt = $dbh -> prepare("
      INSERT INTO programruleuser (
         programid,
         ruleid,
         userid,
         rulevalue,
         rulehigh,
         rulelow)
      SELECT
         :programid,
         :ruleid,
         pu.userid,
         1,
         0,
         0
      FROM programuser pu,
           programrule pr
      WHERE pr.ruleid = :ruleid
       AND  pr.programid = :programid
       AND  pu.programid = :programid
       AND  pu.programid = pr.programid
       AND  pu.roletype = 'participant'
       AND  pu.programid = pr.programid
      ");        

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);

   $stmt -> execute();  

   $count = $stmt -> rowCount();
   if ( $count < 1 ) {
//      Valid as maybe no participants enrolled
//      $_SESSION['message'] = 'Failed to insert programruleuser';
//      header("Location: error.php");
   } 
 
   // Bug somewhere here  
   if ( (strlen($pollname) > 0) && (strpos($pollname, "gas") == false) ) {
                                
      $stmt = $dbh -> prepare("
      INSERT INTO programurl (
         programid,
         urltype,
         urlname,
         urllabel,
         urldesc,
         ruleid
      )
      SELECT
         :programid,
         'poll',
         :pollname,
         p.polldesc,
         p.pollurl,
         :ruleid
      FROM poll p,
           programrule pr
      WHERE pr.ruleid = :ruleid
       AND  p.pollname = :pollname
       AND  pr.programid = :programid
      ");        

      $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
      $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
      $stmt -> bindParam(':pollname', $pollname, PDO::PARAM_STR);
      $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);

      $stmt -> execute();  

      $count = $stmt -> rowCount();
      if ( $count < 1 ) {
         $_SESSION['message'] = 'Failed to insert programurl';
         header("Location: error.php");
      } 

   }           
                
   header('Location: programrule.php');

} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later-->'.$e;
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
          