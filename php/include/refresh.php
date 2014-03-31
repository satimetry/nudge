<?php
   
try {
   
  if ( !isset($dbh) ) {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  if ( isset($userid) && isset($programid) ) {
   
   if ( isset($_SESSION['msgidlist']) ) {

      $msgidlist = $_SESSION['msgidlist'];      
      $msgidarray = explode(",", $msgidlist);
      $_SESSION['msgidlist'] = '';
           
      foreach ( $msgidarray as $msgid ) {
         $msgid = intval(substr($msgid, 3, 10));

         if ( $msgid > 0 ) {

         // Update isread status
         $stmt = $dbh -> prepare("
         UPDATE msg
         SET isread = 1
         WHERE programid = :programid
          AND  userid = :userid
          AND  msgid = :msgid; 
         ");
         
         /*** bind the parameters ***/
         $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
         $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
         $stmt -> bindParam(':msgid', $msgid, PDO::PARAM_STR);
          
         $stmt -> execute();
         }
      }
   }
      
   $stmt = $dbh -> prepare("
      UPDATE programuser
      SET msgunreadcount =
          (SELECT count(msgid) FROM msg
          WHERE programid = :programid
          AND   userid = :userid
          AND   isread = FALSE),
          ruleoptincount = 
          (SELECT count(programruleuserid) FROM programruleuser 
          WHERE programid = :programid 
          AND   userid = :userid
          AND   rulevalue = 1)
      WHERE programid = :programid
      AND   userid = :userid");

   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> execute();

   $pucount = $stmt -> rowCount();       
   if ( $pucount != 1 ) {   
      $_SESSION['message'] = 'No programuser update.';
      header("Location: error.php");           
   }

   $msgunreadcount = "";
   $ruleoptincount = "";
   $pointcount = "";
   
   $stmt = $dbh -> prepare(
      "SELECT 
         pu.msgunreadcount AS :msgunreadcount,
         pu.ruleoptincount AS :ruleoptincount,
         pu.pointcount AS :pointcount               
      FROM programuser pu
      WHERE pu.userid = :userid
        AND pu.programid = :programid;
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':msgunreadcount', $msgunreadcount, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':ruleoptincount', $ruleoptincount, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':pointcount', $pointcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $pucount = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);

   $pucount = $stmt -> rowCount();       
   if ( $pucount != 1 ) {   
      $_SESSION['message'] = 'No programuser selected.';
      header("Location: error.php");           
   }
   
   $msgunreadcount = $row[0];
   $ruleoptincount = $row[1];
   $pointcount = $row[2];

   $_SESSION['msgunreadcount'] = $msgunreadcount;
   $_SESSION['ruleoptincount'] = $ruleoptincount;
   $_SESSION['pointcount'] = $pointcount;

   $pollcount = "";
   $linkcount = "";
   $chartcount = "";

   $stmt = $dbh -> prepare(
      "SELECT 
         COUNT(programurlid) AS :pollcount
      FROM programurl purl
      WHERE purl.urltype = 'poll'
        AND purl.programid = :programid;
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':pollcount', $pointcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $pollcount = $row[0];

   if ( $count == 1 ) {
      $_SESSION['pollcount'] = $pollcount;
   }

   $stmt = $dbh -> prepare(
      "SELECT 
         COUNT(programurlid) AS :linkcount
      FROM programurl purl
      WHERE purl.urltype = 'link'
        AND purl.programid = :programid;
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':linkcount', $pointcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $linkcount = $row[0];

   if ( $count == 1 ) {
      $_SESSION['linkcount'] = $linkcount;
   }
             
   $stmt = $dbh -> prepare(
      "SELECT 
         COUNT(programurlid) AS :toolcount
      FROM programurl purl
      WHERE purl.urltype = 'tool'
        AND purl.programid = :programid;
      ");

   $toolcount = "";
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':toolcount', $toolcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $toolcount = $row[0];
  
   if ( $count == 1 ) {
      $_SESSION['toolcount'] = $toolcount;
   }
   
   $stmt = $dbh -> prepare(
      "SELECT 
         COUNT(programurlid) AS :chartcount
      FROM programurl purl
      WHERE purl.urltype IN ('user', 'group', 'program')
        AND purl.programid = :programid;
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':chartcount', $chartcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $chartcount = $row[0];

   if ( $count == 1 ) {
      $_SESSION['chartcount'] = $chartcount;
   }

   $goalcount = "";
   $stmt = $dbh -> prepare("
      SELECT COUNT(pru.programruleuserid) AS :goalcount
      FROM rule r,
        programruleuser pru
      WHERE r.ruletype = 'gaslow'
       AND  r.ruleid = pru.ruleid
       AND  pru.programid = :programid
       AND  pru.userid = :userid;
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':goalcount', $goalcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $goalcount = $row[0];

   if ( $count == 1 ) {
      $_SESSION['goalcount'] = $goalcount;
   }
       
   $usercount = "";
   $stmt = $dbh -> prepare(
      "SELECT 
         COUNT(userid) AS :usercount
      FROM programuser pu
      WHERE pu.programid = :programid
       AND  pu.roletype = 'participant';
      ");

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':usercount', $chartcount, PDO::PARAM_STR, 40);
            
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   $usercount = $row[0];

   if ( $count == 1 ) {
      $_SESSION['usercount'] = $usercount;
   }

   header("Location: msg.php");   
  }

} catch(Exception $e) {
   $_SESSION['message'] = "Failed to refresh settings-->".$e;
   header("Location: error.php");
}
   
?>