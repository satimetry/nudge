<?php

try {
   if (!isset($dbh)) {
      $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
      $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

   $stmt = $dbh -> prepare("
   SELECT
      MAX(obsdate) AS :userobsdate
      FROM 
         userobs
      WHERE userid = :userid     
      AND  programid = :programid
      AND  obsname = :obsname
      ORDER by obsdate DESC
      LIMIT 0, 20;");

   $userobsdate = "";

   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':userobsdate', $userobsdate, PDO::PARAM_STR);
   $stmt -> bindParam(':obsname', $obsname, PDO::PARAM_STR);

   $stmt -> execute();
   $row = $stmt -> fetch(PDO::FETCH_NUM);
   $uocount = $stmt->rowCount();
   $userobsdate = $row[0];
   
   date_default_timezone_set('Australia/Sydney');
 
   $uocount = $stmt -> rowCount();       
   if ( $uocount == 1 && isset($userobsdate) ) {
      $lastobsdate2 = date_create_from_format('Y-m-d H:i:s', $userobsdate);
      $lastobsdate = date_format($lastobsdate2,'l g:ia jS F Y'); 
   } else {
//      $lastobsdate2 = date_create();  
      $lastobsdate = "First entry";      
   }
  
     
} catch(Exception $e) {
   $_SESSION['message'] = "Failed to insert userobs";
   header("Location: error.php");
}
?>