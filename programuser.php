<?php

include("include/session.php");
include('include/hit.php');

if (!isset($_GET['roletype'])) {
   $message = 'You must select a roletype to access this page';
   header('Location: index.php');
}
$urltype = $_GET['roletype'];

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
         u.userid AS :userid,
         u.username AS :username,
         u.pushoveruser AS :pushoveruser,
         pu.msgunreadcount AS :msgunreadcount,
         pu.ruleoptincount AS :ruleoptincount,
         pu.pointcount AS :pointcount,
         pu.programid AS :programid,
         u.fitbitsecret AS :fitbitsecret,
         u.fitbitkey AS :fitbitkey,
         u.fitbitappname AS :fitbitappname         
      FROM
         programuser pu, user u 
      WHERE u.userid = pu.userid      
      AND  pu.programid = :programid 
      AND  pu.roletype = 'participant'
      ORDER by username ASC;");

   /*** bind the parameters ***/
   $userid = "";
   $username = "";
   $pushoveruser = "";
	$msgunreadcount = "";
	$ruleoptincount = "";
	$pointcount = "";
   $fitbitsecret = "";
   $fitbitkey = "";
   $fitbitappname = "";
   
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':pushoveruser', $pushoveruser, PDO::PARAM_STR);
   $stmt -> bindParam(':msgunreadcount', $msgunreadcount, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleoptincount', $ruleoptincount, PDO::PARAM_STR);
   $stmt -> bindParam(':pointcount', $pointcount, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitsecret', $fitbitsecret, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitkey', $fitbitkey, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitappname', $fitbitappname, PDO::PARAM_STR);
          
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");
}
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

   <!-- Begin: User Page -->
   <div data-theme="a" id="pageUser" data-role="page" data-fullscreen="false"><section>

      <script> writeHeader("backhome", "insertnudge"); </script>

         <div data-role="content">
            <div class="content-primary" id="User">
               <ul data-role="listview" data-filter="true" id="UserList" data-inset="true" >
                  <li data-role="divider">
                     <h4>Participants</h4>
                  </li>   
                           
               <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                  $id = $row[0];
                  $username = $row[1];
                  $pushoveruser = $row[2];
                  $msgunreadcount = $row[3];
                  $ruleoptincount = $row[4];
                  $pointcount = $row[5];
                  $programid = $row[6];
                  $fitbitsecret = $row[7];
                  $fitbitkey = $row[8];
                  $fitbitappname = $row[9];                  
               ?>
                  <li data-name="<?php echo "user".$id; ?>" data-inset="true" >                       
                     <a href="#popupUser" data-rel="popup" data-position-to="window" data-transition="pop">
                     <div class="ui-grid-b">     
                        <div class="ui-block-a" style="font-weight:normal; width:20%; !important;">
                           <img src="images/user.png"  style="width: 40px; height: 40px;" title="user" alt="user" class="ui-li-thumb">
                        </div>
                        <div class="ui-block-b" style="font-weight:normal; width:50%;!important;">                         
                           <?php echo $username; ?>
                        </div>
                        <div class="ui-block-c" style="font-weight:normal; width:30%; !important;">                         
                           <?php echo $pointcount." points"; ?>
                        </div>
                     </div>
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_userid"';?> value=<?php echo '"'.$id.'"'; ?> >
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_username"';?> value=<?php echo '"'.$username.'"'; ?> >
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_pushoveruser"';?> value=<?php echo '"'.$pushoveruser.'"'; ?> >
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_msgunreadcount"';?> value=<?php echo '"'.$msgunreadcount.'"'; ?> >
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_ruleoptincount"';?> value=<?php echo '"'.$ruleoptincount.'"'; ?> >
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_pointcount"';?> value=<?php echo '"'.$pointcount.'"'; ?> >                        
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_programid"';?> value=<?php echo '"'.$programid.'"'; ?> >                        
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_fitbitsecret"';?> value=<?php echo '"'.$fitbitsecret.'"'; ?> >                        
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_fitbitkey"';?> value=<?php echo '"'.$fitbitkey.'"'; ?> >                        
                     <input readonly="true" type="hidden" id=<?php echo '"user'.$id.'_fitbitappname"';?> value=<?php echo '"'.$fitbitappname.'"'; ?> >                        
                     </a>
                  </li>                   
               <?php } ?>
              
               </ul>
            </div>
         </div>
         
<!-- Begin: User popup -->
<div id="popupUser" class="ui-content" data-role="popup"  data-add-back-btn="false"> 
   <div class="content" data-role="content">
      
      <form id="user_form" action="#pageInsertNudge" method="get" rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

         <h3>Participant Details</h3>

            <input type="hidden" id="userid" name="userid" class="userid" value="userid">
            
            <p> pushover.net userid: <var class="popup_pushoveruser"></var> </p>
            <p> fitbit key: <var class="popup_fitbitkey"></var> </p>
            <p> fitbit secret: <var class="popup_fitbitsecret"></var> </p>
            <p> fitbit appname: <var class="popup_fitbitappname"></var> </p>

            <center>
               <input type="button" id="user_cancel" name="msg_cancel" class="msg_cancel" value="Close" data-inline="true">
               <input type="button" id="popup_nudge" name="popup_nudge" class="popup_nudge" value="Nudge" data-inline="true">
           </center>
         </div>
      </form>
      
   </div>
</div>
<!-- End: User div -->

   <script> writeFooter(); </script>
         
   </section></div>
      <!-- End: User Page -->

<!-- Begin: InsertNudge page -->
<div id="pageInsertNudge" data-role="page">
   
   <script> writeHeader("backuser", "home"); </script>
            
   <div class="content" data-role="content">
     
      <form id="nudge_form" action="nudge_submit.php" method="get" rel="external" data-ajax="false"> 
        <div data-role="fieldcontain">

          <fieldset data-role="controlgroup">
            <legend>Nudge <var style="font-style:normal;" class=nudge_username></var></legend>
            
            <input type="hidden" id="nudge_ruleid" name="ruleid" class="ruleid" value=0>
            <input type="hidden" id="nudge_programid" name="programid" class="programid">
            <input type="hidden" id="nudge_userid" name="userid" class="userid">
            <input type="hidden" id="nudge_rulename" name="rulename" class="rulename" value="ruleManual">
            <input type="hidden" id="nudge_username" name="username" class="username">
            
            <div data-role="fieldcontain">
              <label for="msgtxt">Message:</label>  
              <textarea cols="40" rows="8" id="nudge_msgtxt" name="msgtxt" class="msgtxt" placeholder="Nudge says"></textarea>               
            </div>

            <div data-role="fieldcontain">
              <label for="urllabel">URL Label:</label>            
              <input type="text" id="nudge_urllabel" name="urllabel" class="urllabel" placeholder="Optional URL label" >
            </div>

            <div data-role="fieldcontain">
              <label for="urltype">Type:</label>
              <div data-role="controlgroup">             
                <input type="radio" id="link" name="urltype" class="urltype" value="link" checked = "checked" >
                <label for="link">Link</label>
                <input type="radio" id="poll" name="urltype" class="urltype" value="poll" >
                <label for="poll">Poll</label>
               </div>
            </div>
          
            <div data-role="fieldcontain">
              <label for="urldesc">URL:</label>            
              <input type="text" id="nudge_urldesc" name="urldesc" class="urldesc" placeholder="Optional URL resource" >
            </div>
                              
            </fieldset>
            
            <center>
              <input type="button" id="nudge_cancel" name="nudge_cancel" class="nudge_cancel" value="Cancel" data-inline="true">
              <input type="submit" id="nudge_submit" name="nudge_submit" class="nudge_submit" value="Nudge" data-inline="true">
            </center>
            
         </div>
      </form>
      
   </div>
   
   <script> writeFooter(); </script>
      
</div>
<!-- End: InsertNudge div -->

<!-- Begin: InsertNudgeAll page -->
<div id="pageInsertNudgeAll" data-role="page">
   
   <script> writeHeader("backuser", "home"); </script>
            
   <div class="content" data-role="content">
     
      <form id="nudgeall_form" action="nudge_submit.php" method="get" rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

           <fieldset data-role="controlgroup">
           
           <legend>Nudge all participants</legend>
           
            <input type="hidden" id="nudgeall_ruleid" name="ruleid" class="ruleid" value=0>
            <input type="hidden" id="nudgeall_programid" name="programid" class="programid">
            <input type="hidden" id="nudgeall_rulename" name="rulename" class="rulename" value="ruleManual">
            <input type="hidden" id="nudgeall_username" name="username" class="username">
            
            <div data-role="fieldcontain">
               <textarea cols="40" rows="8" id="nudge_msgtxt" name="msgtxt" class="msgtxt" placeholder="Nudge says"></textarea>               
            </div>

            <div data-role="fieldcontain">            
               <input type="text" id="nudgeall_urllabel" name="urllabel" class="urllabel" placeholder="Optional URL label" >
            </div>

            <div data-role="fieldcontain">            
               <input type="radio" id="link" name="urltype" class="urltype" value="link" checked = "checked" >
               <label for="link">Link</label>
               <input type="radio" id="poll" name="urltype" class="urltype" value="poll" >
               <label for="poll">Poll</label>
            </div>

            <div data-role="fieldcontain">            
               <input type="text" id="nudgeall_urldesc" name="urldesc" class="urldesc" placeholder="Optional URL resource" >
            </div>
                              
            </fieldset>
            
            <center>
               <input type="button" id="nudgeall_cancel" name="nudge_cancel" class="nudge_cancel" value="Cancel" data-inline="true">
               <input type="submit" id="nudgeall_submit" name="nudge_submit" class="nudge_submit" value="Nudge" data-inline="true">
            </center>
         </div>
      </form>
      
   </div>
   
   <script> writeFooter(); </script>
      
</div>
<!-- End: InsertNudgeAll div -->

   </body>

<script>
$('#UserList li').click(function() {
   var userid = $(this).attr('data-name'); 
//   alert(userid); 
   localStorage.setItem("userid", userid);
}); 

$('#user_cancel').click(function() {
   $('#popupUser').popup("close");
});


$('#nudge_cancel').click(function() {
   $.mobile.changePage("#pageUser");
});

$('#popup_nudge').click(function() {
   $.mobile.changePage("#pageInsertNudge");
});

$('#nudgeall_cancel').click(function() {
   $.mobile.changePage("#pageUser");
});

$('#user_submit').click(function() {
   var userid_userid = localStorage.getItem("userid") + "_userid";
   var pushoveruserid = document.getElementById(userid_pushoveruser).value;
   document.getElementById("pushoveruser").value = pushoveruser;
   return true;
});

$( '#popupUser' ).on( 'popupbeforeposition',function(event){
   // inject read counter update here
   var userid = localStorage.getItem("userid");
   var userid_pushoveruser = userid + "_pushoveruser";
   var userid_fitbitsecret = userid + "_fitbitsecret";
   var userid_fitbitkey = userid + "_fitbitkey";
   var userid_fitbitappname = userid + "_fitbitappname";

   var pushoveruser = document.getElementById(userid_pushoveruser).value;
   var fitbitsecret = document.getElementById(userid_fitbitsecret).value;
   var fitbitkey = document.getElementById(userid_fitbitkey).value;
   var fitbitappname = document.getElementById(userid_fitbitappname).value;
   
   $('.popup_pushoveruser').empty();
   $('.popup_pushoveruser').append(pushoveruser);
   $('.popup_fitbitsecret').empty();
   $('.popup_fitbitsecret').append(fitbitsecret);
   $('.popup_fitbitkey').empty();
   $('.popup_fitbitkey').append(fitbitkey);
   $('.popup_fitbitappname').empty();
   $('.popup_fitbitappname').append(fitbitappname);
});

$( '#pageInsertNudge' ).on('pagebeforeshow', function(event) {
   var id = localStorage.getItem("userid");
   var username = document.getElementById(id + "_username").value;
   var userid = document.getElementById(id + "_userid").value;
   var programid = document.getElementById(id + "_programid").value;
  
   document.getElementById("nudge_username").value = username;
   document.getElementById("nudge_userid").value = userid;
   document.getElementById("nudge_programid").value = programid;
      
   $('.nudge_username').empty();
   $('.nudge_username').append(username);
});

$( '#pageInsertNudgeAll' ).on('pagebeforeshow', function(event) {
   var id = localStorage.getItem("userid");
   var username = document.getElementById(id + "_username").value;
   var programid = document.getElementById(id + "_programid").value;
  
   document.getElementById("nudgeall_username").value = username;
   document.getElementById("nudgeall_programid").value = programid;      
});

</script>

</html>

          