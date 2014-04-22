<?php

include("include/session.php");

$ruleid = $_GET['ruleid'];
$responseJSON = $_GET['responseJSON'];
$responseJSON = json_decode($responseJSON);

$q01value = null;
$q02value = null;
$q03value = null;
$q04value = null;
$q05value = null;
$q06value = null;
$q07value = null;
$q08value = null;
$q09value = null;
$q10value = null;

$programid = $responseJSON->{'programid'};
$pollid  = $responseJSON->{'pollid'};
$polldesc  = $responseJSON->{'polldesc'};
$pollname  = $responseJSON->{'pollname'};
$userid  = $responseJSON->{'userid'};
$lastqseqno = $responseJSON->{'lastqseqno'};
$qcount = $responseJSON->{'qcount'};
$polldate = $responseJSON->{'polldate'};

if ( $qcount > 0 ) { $q01value = $responseJSON->{'q01value'}; }
if ( $qcount > 1 ) { $q02value = $responseJSON->{'q02value'}; }
if ( $qcount > 2 ) { $q03value = $responseJSON->{'q03value'}; }
if ( $qcount > 3 ) { $q04value = $responseJSON->{'q04value'}; }
if ( $qcount > 4 ) { $q05value = $responseJSON->{'q05value'}; }
if ( $qcount > 5 ) { $q06value = $responseJSON->{'q06value'}; }
if ( $qcount > 6 ) { $q07value = $responseJSON->{'q07value'}; }
if ( $qcount > 7 ) { $q08value = $responseJSON->{'q08value'}; }
if ( $qcount > 8 ) { $q09value = $responseJSON->{'q09value'}; }
if ( $qcount > 9 ) { $q10value = $responseJSON->{'q10value'}; }

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      INSERT INTO programpolluser (
         programid,
         pollid,
         userid,
         lastqseqno,
         qcount,
         polldate,
         q01value,
         q02value,
         q03value,
         q04value,
         q05value,
         q06value,
         q07value,
         q08value,
         q09value,
         q10value
      ) VALUES (
         :programid,
         :pollid,
         :userid,
         :lastqseqno,
         :qcount,
         :polldate,
         :q01value,
         :q02value,
         :q03value,
         :q04value,
         :q05value,
         :q06value,
         :q07value,
         :q08value,
         :q09value,
         :q10value
         )");          

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':pollid', $pollid, PDO::PARAM_STR);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':lastqseqno', $lastqseqno, PDO::PARAM_STR);
   $stmt -> bindParam(':qcount', $qcount, PDO::PARAM_STR);
   $stmt -> bindParam(':polldate', $polldate, PDO::PARAM_STR);
      
   $stmt -> bindParam(':q01value', $q01value, PDO::PARAM_STR);
   $stmt -> bindParam(':q02value', $q02value, PDO::PARAM_STR);
   $stmt -> bindParam(':q03value', $q03value, PDO::PARAM_STR);
   $stmt -> bindParam(':q04value', $q04value, PDO::PARAM_STR);
   $stmt -> bindParam(':q05value', $q05value, PDO::PARAM_STR);
   $stmt -> bindParam(':q06value', $q06value, PDO::PARAM_STR);
   $stmt -> bindParam(':q07value', $q07value, PDO::PARAM_STR);
   $stmt -> bindParam(':q08value', $q08value, PDO::PARAM_STR);
   $stmt -> bindParam(':q09value', $q09value, PDO::PARAM_STR);
   $stmt -> bindParam(':q10value', $q10value, PDO::PARAM_STR);
                  
   $stmt -> execute();
   $count = $stmt->rowCount();
   if ( $count != 1 ) {
      $_SESSION['message'] = "Failed to insert programpolluser";
      header("Location: error.php");
   }
   
   if ($qcount == 1 ) {
       $obsvalue = $q01value;
   } else {
       $obsvalue = $qcount;
   }
   $obstype = 'poll';
   $obsname = $pollname;
   $obsdesc = $polldesc;   
   include('include/insertuserobs.php');

   $rule = "poll";
   include("include/pointcount.php");

   if ( strpos($pollname, "gas") !== false ) {
      header('Location: goal.php?ruletype=gaslow');      
   } else {
      header('Location: programurl.php?urltype=poll');
   }
   
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later. '.$e;
   header("Location: error.php");
}
?>


<html lang="en">
<head>
   <title>Poll User Submit Page</title>
   
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
      
<?php echo "Poll entry attempt for userid=".$userid." in program=".$programid." for pollid=" .$pollid. " failed. ".$message; ?>

   </textarea>


</body>
</html>
          