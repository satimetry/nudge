<?php

try {
  if ( !isset($dbh) ) {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  if ( isset($userid) && isset($programid) ) {

   $ruleid = "";

   if ($rule == "diary") {
      // Update user points
      $stmt = $dbh -> prepare("
      SELECT 
         pru.ruleid AS :ruleid
      FROM 
         programruleuser pru,
         programrule pr,
         rule r
      WHERE
           pru.programid = :programid
      AND  pru.userid = :userid
      AND  pru.ruleid = pr.ruleid
      AND  r.ruleid = pr.ruleid
      AND  pru.programid = pr.programid
      AND  r.ruletype = 'user'
      AND  r.rulename like '%diary%';
      "); 
   }
   if ($rule == "userobs") {
      // Update user points
      $stmt = $dbh -> prepare("
      SELECT 
         pru.ruleid AS :ruleid
      FROM 
         programruleuser pru,
         programrule pr,
         rule r
      WHERE
           pru.programid = :programid
      AND  pru.userid = :userid
      AND  pru.ruleid = pr.ruleid
      AND  r.ruleid = pr.ruleid
      AND  pru.programid = pr.programid
      AND  r.ruletype = 'user'
      AND  r.rulename like '%obs%';
      "); 
   }
   
   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid' , $ruleid, PDO::PARAM_STR);

      $stmt -> execute();
      $row = $stmt->fetch(PDO::FETCH_NUM);
      $ruleid = $row[0];

      }
} catch(Exception $e) {
   $_SESSION['message'] = "Failed to insert userobs";
   header("Location: error.php");
}
?>