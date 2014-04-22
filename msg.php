<?php

include("include/session.php");
include('include/hit.php');

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

   if ( isset($_GET['msgidlist']) ) {
     $_SESSION['msgidlist'] = $_GET['msgidlist'];
     // refresh counters and page views
     include("include/refresh.php");
   }
   
   if ( $roletype == "participant" ) {
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
      ORDER by msgdate DESC
      LIMIT 0, 200;");
   } else if ( $roletype == "architect" ) {
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
         r.awardtype :awardtype,
         m.isread AS :isread
      FROM 
         msg m, rule r, user u
      WHERE      
           u.userid = m.userid
      AND  m.programid = :programid 
      AND  r.rulename = m.rulename
      ORDER by msgdate DESC, u.userid ASC, m.rulename ASC;
      ");
      $userid = "";
   }
   
   /*** bind the parameters ***/
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
      <div data-theme="a" id="pageMsg" data-role="page" data-fullscreen="false"><section>

         <script> writeHeader("backhome", "settings"); </script>

         <div data-role="content">
            <div class="content-primary" id="Msg">
               <ul data-role="listview" data-filter="true" id="MsgList" data-inset="true" >
                  <li data-role="divider">
                     <h4>Nudges</h4>
                  </li>   
                           
               <?php $stmt->execute();
               while ( $row = $stmt->fetch(PDO::FETCH_NUM) ) {
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
               ?>
                  <li data-name=<?php echo "msg".$id; ?> data-inset="true" >     
                                       
                     <a href="#popupMsg" data-rel="popup" data-position-to="window" data-transition="pop">  
                      <div class="ui-grid-b">      
                        <div class="ui-block-a" style="font-weight:normal; width:10%; font-size:11px !important;">                           
                           <img src="images/<?php echo $awardtype ?>.png" style="width:30px; height:30px;"  title="cockateil" alt="cockateil" class="ui-li-thumb">  
                        </div>
                        <div class="ui-block-b" style="font-weight:normal; width:20%; font-size:9px !important;">
                           <?php echo $msgdate." - ".$username; ?> 
                        </div>
   
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_ruleid"';?> value=<?php echo '"'.$ruleid.'"'; ?> >
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_rulename"';?> value=<?php echo '"'.$rulename.'"'; ?> >
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_urldesc"';?> value=<?php echo '"'.$urldesc.'"'; ?> >
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_userid"';?> value=<?php echo '"'.$userid.'"'; ?> >
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_username"';?> value=<?php echo '"'.$username.'"'; ?> >
                        <input readonly="true" type="hidden" id=<?php echo '"msg'.$id.'_msgtxt"';?> value=<?php echo '"'.$msgtxt.'"'; ?> >
   
                        <div class="ui-block-a" style="font-weight:normal; width:10%; font-size:9px !important;"></div>
                        
                        <?php if ( $isread == 0 ) { ?>
                        <div class="ui-block-b" style="font-weight:bold; width:70%; font-size:13px !important;">
                           <?php echo $msgtxt; ?>
                        </div>
                        <?php } else { ?>
                        <div class="ui-block-b" style="font-weight:200; width:70%; font-size:13px !important;">
                           <?php echo $msgtxt; ?>
                        </div>
                        <?php } ?>
                        
                      </div>
                     </a>
                     
                  </li>     
                                  
               <?php } ?>
                            
               </ul>
            </div>
         </div>
         
<!-- Begin: Msg popup -->
<div id="popupMsg" class="ui-content" data-role="popup"  data-add-back-btn="false"> 
   <div class="content" data-role="content">
      <h3>Message</h3>
      
      <form id="msg_form" action="programruleuser_submit.php" method="get" rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

            <input type="hidden" id="ruleid" name="ruleid" class="ruleid" value="ruleid">
            <input type="hidden" id="rulevalue" name="rulevalue" class="rulevalue" value="0">
            
            <p> Participant: <var class="popup_username"> username </var></p>
            <p> Nudge: <var class="popup_msgtxt"> msgtxt </var></p>
            <center>
               <input type="hidden" id="msg_submit" name="msg_submit" class="msg_submit" value="Opt Out" data-inline="true">
               <input type="button" id="msg_cancel" name="msg_cancel" class="msg_cancel" value="Close" data-inline="true">
               <input type="button" id="msg_url" name="msg_url" class="msg_url" value="Go to site ..." data-inline="true">
            </center>
         </div>
      </form>
      
   </div>
</div>
<!-- End: Msg div -->
 
      <script> writeFooter(); </script>
    
   </section></div>
      <!-- End: Msg Page -->

   </body>

<script>
$('#MsgList li').click(function() {
   var msgid = $(this).attr('data-name');  
   localStorage.setItem("msgid", msgid);
   var msgidlist = localStorage.getItem("msgidlist");
   if ( msgidlist != null) { msgidlist += msgid + ","; }   
   // Todo parse thru this list to update msg read count, do at convenient time
   localStorage.setItem("msgidlist", msgidlist); 
}); 

$('#msg_cancel').click(function() {
   $('#popupMsg').popup("close");
});

$('#msg_url').click(function() {
   var msgid_urldesc = localStorage.getItem("msgid") + "_urldesc";
   var urldesc = document.getElementById(msgid_urldesc).value;
   window.location.href = urldesc;
//   alert(urldesc);
//   $.mobile.changePage("programurl.php?urltype=link", { reloadPage:true } );
//   $.mobile.changePage("programurl.php?urltype=link");
//   $.mobile.changePage(urldesc);
//   $('#popupMsg').popup("close");
});

$('#msg_submit').click(function() {
   var msgid_ruleid = localStorage.getItem("msgid") + "_ruleid";
   var ruleid = document.getElementById(msgid_ruleid).value;
   document.getElementById("ruleid").value = ruleid;
//   $.mobile.changePage(”programruleuser_submit.php?ruleid=" + ruleid + "&rulevalue=0", {
//      type: "get"
//   });
//   window.location.href = ”programruleuser_submit.php?ruleid=" + ruleid + "&rulevalue=0";
//   $('#popupMsg').popup("close");
   return true;
});

$( '#popupMsg' ).on( 'popupbeforeposition',function(event){
   // inject read counter update here
   var msgid_msgtxt = localStorage.getItem("msgid") + "_msgtxt";
   var msgid_username = localStorage.getItem("msgid") + "_username";
   var msgtxt = document.getElementById(msgid_msgtxt).value;
   var username = document.getElementById(msgid_username).value;  
   $('.popup_msgtxt').empty();
   $('.popup_msgtxt').append(msgtxt);
   $('.popup_username').empty();
   $('.popup_username').append(username);
});

$( '#pageMsg' ).on( 'pagebeforeshow',function(event){
  localStorage.setItem('msgidlist', "");
});

</script>

</html>

          