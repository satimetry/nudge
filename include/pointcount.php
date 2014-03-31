<?php

try {
 if ( !isset($dbh) ) {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }

 if ( isset($userid) && isset($programid) ) {

   $ruleid = "";
   
   if ($rule == "poll") {
      
      if ( isset($_SESSION['ruleid']) ) { $ruleid = $_SESSION['ruleid']; }
      
      if ( $ruleid != "" ) {
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
         AND  r.ruletype = 'poll'
         AND  r.ruleid = :ruleid;
         ");
      }
       
   }
   
   if ($rule == "diary") {
      // Update user points
      $stmt = $dbh -> prepare("
      SELECT 
         MAX(pru.ruleid) AS :ruleid
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
         MAX(pru.ruleid) AS :ruleid
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

   if ($rule == "login") {
      // Update user points
      $stmt = $dbh -> prepare("
      SELECT 
         MAX(pru.ruleid) AS :ruleid
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
      AND  r.rulename like '%login%';
      "); 
   }

   if ($rule == "link") {
      // Update user points
      $stmt = $dbh -> prepare("
      SELECT 
         MAX(pru.ruleid) AS :ruleid
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
      AND  r.rulename like '%link%';
      "); 
   }
         
   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
          
   $stmt -> execute();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   $ruleid = $row[0];

   
   $prucount = $stmt -> rowCount();       
   if ( $prucount != 1 ) {   
      $_SESSION['message'] = 'No programruleuser selected.';
      header("Location: error.php");           
   }
   
}

if ( isset($ruleid) && isset($userid) && isset($programid) ) {
      
   // Update user points
   $stmt = $dbh -> prepare("
      UPDATE programuser
      SET pointcount = pointcount +
         (SELECT rulepoint
          FROM programrule
          WHERE programid = :programid
           AND  ruleid = :ruleid)
      WHERE programid = :programid
       AND  userid = :userid;"
      ); 

   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
       
   $stmt -> execute();

   $pucount = $stmt -> rowCount();       
   if ( $pucount != 1 ) {   
      $_SESSION['message'] = 'No programuser selected.';
      header("Location: error.php");           
   }
   
 }
} catch(Exception $e) {
   $_SESSION['message'] = "Failed to insert userobs";
   header("Location: error.php");
}
   
?>