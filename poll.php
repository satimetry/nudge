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
         p.pollid AS :pollid,
         p.pollname AS :pollname,
         p.polldesc AS :polldesc,
         p.qcount AS :qcount,
         p.isinternal AS :isinternal,
         p.pollurl AS :pollurl
      FROM
         poll p 
      WHERE p.programid = :programid 
      ORDER by pollid ASC;");

   /*** bind the parameters ***/
   $pollid = "";
   $pollname = "";
   $polldesc = "";
   $qcount = "";
   $isinternal = "";
   $pollurl = "";
      
   $stmt -> bindParam(':pollid', $pollid, PDO::PARAM_STR);
   $stmt -> bindParam(':pollname', $pollname, PDO::PARAM_STR);
   $stmt -> bindParam(':polldesc', $polldesc, PDO::PARAM_STR);
   $stmt -> bindParam(':qcount', $qcount, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':isinternal', $isinternal, PDO::PARAM_STR);
   $stmt -> bindParam(':pollurl', $pollurl, PDO::PARAM_STR);
       
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

   <!-- Begin: Poll Page -->
   <div data-theme="a" id="pagePoll" data-role="page" data-fullscreen="false"><section>

      <script> writeHeader("backsettings", "home"); </script>


         <div data-role="content">
            <div class="content-primary" id="User">
               <ul data-role="listview" data-filter="true" id="PollList" data-inset="true" >
                  <li data-role="divider">
                     <h4>Polls</h4>
                  </li>   
                           
               <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                  $pollid = $row[0];
                  $pollname = $row[1];
                  $polldesc = $row[2];
                  $qcount = $row[3];
                  $isinternal = $row[4];
                  $pollurl = $row[5];
                  
                  if ( $isinternal == 1) {
                     $internalstr = "internal"; 
                  } else {
                     $internalstr = "external";
                  }

               ?>
                  <li data-name="<?php echo "poll".$pollid; ?>" data-inset="true" >                       
                     <a href="#popupPoll" data-rel="popup" data-position-to="window" data-transition="pop">
                           <img src="images/poll.png"  style="width: 40px; height: 40px;" title="user" alt="user" class="ui-li-thumb">
                           <div data-role="collapsible">
                           <h4 style="font-size:11px;" class="ui-li-heading" > <?php echo $pollname.": ".$pollurl; ?> </h4>                        
                           <p><?php echo $polldesc; ?> </p>
                           </div>
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_pollid"';?> value=<?php echo '"'.$pollid.'"'; ?> >
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_pollname"';?> value=<?php echo '"'.$pollname.'"'; ?> >
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_polldesc"';?> value=<?php echo '"'.$polldesc.'"'; ?> >
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_qcount"';?> value=<?php echo '"'.$qcount.'"'; ?> >
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_isinternal"';?> value=<?php echo '"'.$isinternal.'"'; ?> >
                           <input readonly="true" type="hidden" id=<?php echo '"poll'.$pollid.'_pollurl"';?> value=<?php echo '"'.$pollurl.'"'; ?> >
                           <input readonly="true" type="hidden" value=<?php echo '"'.$polldesc.'"'; ?> >
                     </a>
                  </li>                   
               <?php } ?>
              
               </ul>
            </div>
         </div>
         
<!-- Begin: Poll popup -->
<div id="popupPoll" class="ui-content" data-role="popup"  data-add-back-btn="false"> 
   <div class="content" data-role="content">
   
      <form id="poll_form" action="#pagePoll" method="get" rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

            <h3 class="polldesc"></h3>             
                       
            <input type="hidden" id="pollid" name="pollid" class="pollid" value="pollid">
            
            <center>
               <input type="button" id="popup_cancel" name="popup_cancel" class="popup_cancel" value="Close" data-inline="true">
               <input type="button" id="popup_review" name="popup_review" class="popup_review" value="Review" data-inline="true">
           </center>
         </div>
      </form>
      
   </div>
</div>
<!-- End: User div -->

      <script> writeFooter(); </script> 
           
   </section></div>
      <!-- End: User Page -->

   </body>

<script>
$('#PollList li').click(function() {
   var pollid = $(this).attr('data-name'); 
//   alert(pollid); 
   localStorage.setItem("pollid", pollid);
}); 

$( '#popupPoll' ).on( 'popupbeforeposition',function(event){
   // inject read counter update here
   var id = localStorage.getItem("pollid");
   var pollid_polldesc = id + "_polldesc";
//   alert(pollid_polldesc);
   var polldesc = document.getElementById(pollid_polldesc).value;
   $('.polldesc').empty();
   $('.polldesc').append(polldesc + " Poll");
});

$('#popup_review').click(function() {
   var id = localStorage.getItem("pollid");
   var pollid_pollid = id + "_pollid";
   var pollid = document.getElementById(pollid_pollid).value;
   var url = document.getElementById(id + "_pollurl").value;

//   var url = "pollq.php?pollid=" + pollid;
   window.location.href = url;
//   $.mobile.loadPage(url);
//   $.mobile.pagecontainer("load", url,
//         { reload: "true", } );
//   $('#popupPoll').popup("close");
});


$('#popup_cancel').click(function() {
   $('#popupPoll').popup("close");
   return true;
});

</script>

</html>

          