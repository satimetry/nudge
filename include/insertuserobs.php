<?php

if ( !isset( $obstype) ) { $obstype = "userobs"; }
if ( isset($obsname) && isset($obsvalue) && isset($userid) && isset($programid) ) {

  try {
   if ( !isset($dbh) ) {
      $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
      $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

   $stmt = $dbh -> prepare("
      INSERT INTO userobs (
         userid,
         programid,
         obsname,
         obsvalue,
         obsdesc,
         obsdate,
         obstype      
      ) VALUES (
         :userid,
         :programid,
         :obsname,
         :obsvalue,
         :obsdesc,
         CURRENT_TIMESTAMP,
         :obstype)"
      ); 

   if ( !isset($obsdesc) ) { $obsdesc = ""; }
   
   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':obsdesc', $obsdesc, PDO::PARAM_STR);
   $stmt -> bindParam(':obsname', $obsname, PDO::PARAM_STR);
   $stmt -> bindParam(':obsvalue', $obsvalue, PDO::PARAM_STR);
   $stmt -> bindParam(':obstype' , $obstype, PDO::PARAM_STR);

      $stmt -> execute();

      } catch(Exception $e) {
      $_SESSION['message'] = "Failed to insert userobs";
      header("Location: error.php");
      }
      }
   ?>