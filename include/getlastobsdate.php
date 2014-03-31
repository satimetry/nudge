<?php

try {
   if (!isset($dbh)) {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
      $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

   $stmt = $dbh -> prepare("
   SELECT
      MAX(polldate) AS :userpolldate
      FROM 
         programpolluser
      WHERE userid = :userid     
      AND  programid = :programid
      AND  pollid = :pollid
      ORDER by polldate DESC
      LIMIT 0, 20;");

   $userpolldate = "";

   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':userpolldate', $userpolldate, PDO::PARAM_STR);
   $stmt -> bindParam(':pollid', $pollid, PDO::PARAM_STR);

   $stmt -> execute();
   $row = $stmt -> fetch(PDO::FETCH_NUM);
   $uocount = $stmt->rowCount();
   $userpolldate = $row[0];
   
   date_default_timezone_set('Australia/Sydney');
 
   $uocount = $stmt -> rowCount();       
   if ( $uocount == 1 && isset($userpolldate) ) {
      $lastpolldate2 = date_create_from_format('Y-m-d H:i:s', $userpolldate);
      $lastpolldate = date_format($lastpolldate2,'l g:ia jS F Y'); 
   } else {
//      $lastpolldate2 = date_create();  
      $lastpolldate = "First entry";      
   }
  
     
} catch(Exception $e) {
   $_SESSION['message'] = "Failed to read programpolluser";
   header("Location: error.php");
}
?>