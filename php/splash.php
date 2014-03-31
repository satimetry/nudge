<?php

include("include/session.php");
//include('include/hit.php');

$roletype = 'participant';
if ( isset($_SESSION['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 
if ( isset($_GET['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
         m.msgid AS :msgid,
         m.msgdate AS :msgdate,
         r.ruleid AS :ruleid,
         m.msgtxt AS :msgtxt,
         m.rulename AS :rulename,
         m.urldesc AS :urldesc,
         u.userid AS :userid,
         u.username AS :username,
         r.awardtype AS :awardtype,
         m.isread AS :isread
      FROM 
         msg m, rule r, user u
      WHERE m.userid = :userid
      AND  u.userid = m.userid
      AND  u.userid = :userid    
      AND  m.programid = :programid 
      AND  r.rulename = m.rulename
      AND  msgdate IN (
         SELECT MAX(msgdate)
         FROM msg m2
         WHERE m2.programid = :programid
          AND  m2.userid = :userid
          AND  m2.isread = 0)
      ;");

   $msgid = "";
   $msgdate = "";
   $ruleid = "";
   $rulename = "";
   $msgtxt = "";
   $urldesc = "";
   $username = "";
   $awardtype = "";
   $isread = "";
        
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);	    
   $stmt -> bindParam(':msgid', $msgid, PDO::PARAM_STR);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':msgdate', $msgdate, PDO::PARAM_STR);
   $stmt -> bindParam(':rulename', $rulename, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':msgtxt', $msgtxt, PDO::PARAM_STR);      
   $stmt -> bindParam(':urldesc', $urldesc, PDO::PARAM_STR);
   $stmt -> bindParam(':awardtype', $awardtype, PDO::PARAM_STR);
   $stmt -> bindParam(':isread', $isread, PDO::PARAM_STR);

   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   $id = $row[0];
   $msgdate = $row[1];
   $ruleid = $row[2];
   $msgtxt = $row[3];
   $rulename = $row[4];
   $urldesc = $row[5];
   $userid = $row[6];
   $username = $row[7];
   $awardtype = $row[8];                  
   $isread = $row[9];
   
   $mcount = $stmt->rowCount();
   if ($mcount == 0 ) {
      header("Location: index.php"); 
   } else {
      $stmt = $dbh -> prepare("
        UPDATE msg SET isread = 1
        WHERE msgid = :msgid;");

      $stmt -> bindParam(':msgid', $id, PDO::PARAM_STR);
      $stmt->execute();
      $ucount = $stmt->rowCount();   
      
      if ( $ucount == 0 ) {
        $_SESSION['message'] = 'msg isread not updated';
        header("Location: error.php");
      }     
   }
         
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");}
?>


<!doctype html>
<!--[if IE 7 ]>       <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>       <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>       <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en-US">
   <!--<![endif]-->

<html lang="en">
   <head>
      <title>The Nudge Machine</title>
      
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/themes/nudgetheme.min.css" />
      <link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css" />
      <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile.structure-1.4.0.min.css" />
      <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
      <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
      
      <link rel="stylesheet" href="css/nudge.css" />      
      <script src="js/nudge.js"  ></script>  
   </head>
   <body>

      <!-- Begin: Msgs Page -->
<div data-theme="a" id="pageMsg" data-role="page" data-fullscreen="false" style="background:url(images/cockateil.png); repeat-x;" ><section>

  <script> writeHeader("home", "msgs"); </script>

  <div data-role="content">
    <div class="content-primary" id="Msg">

      <fieldset data-role="controlgroup">

        <legend>Welcome <?php echo $username.' to the '.$programname.' program'; ?></legend>
            
        <div data-role="fieldcontain">
          <label for="textarea">
            <?php 
              $msgdate2 = date_create_from_format('Y-m-d H:i:s', $msgdate);
              echo date_format($msgdate2,'l g:ia jS F Y'); 
              ?> 
            </label>
            <div data-role="controlgroup">
              <textarea style="text-align:left;" cols="40" rows="8" name="textarea" id="textarea" readonly><?php echo $msgtxt; ?></textarea>
            </div>
        </div>
          
      </fieldset>

      <center>
        <input type="button" id="cancel" name="msg_cancel" class="cancel" value="Close" data-inline="true">
        <input type="button" id="url" name="url" class="url" value="Go to site ..." data-inline="true">
      </center>
                     
    </div>
  </div>
           
  <script> writeFooter(); </script>
</section></div>
<!-- End: Msg Page -->

</body>

<script>

$('#cancel').click(function() {
   var urldesc = "index.php";
   window.location.href = urldesc;
});


$('#url').click(function() {
   var urldesc = "<?php echo $urldesc; ?>";
   if ( urldesc != "") {
      window.location.href = urldesc;
   } else {
      window.location.href = "index.php";
   }
   
});

</script>

</html>

          