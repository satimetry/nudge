<?php

include("include/session.php");
include('include/hit.php');

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
         ud.userdiaryid AS :userdiaryid,
         ud.diarydate AS :diarydate,
         ud.diarytxt AS :diarytxt
      FROM 
         userdiary ud
      WHERE ud.userid = :userid     
      AND  ud.programid = :programid
      ORDER by diarydate DESC
      LIMIT 0, 20;");

   /*** bind the parameters ***/
   $userdiaryid = "";
   $diarydate = "";
   $diarytxt = "";
   
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':userdiaryid', $userdiaryid, PDO::PARAM_STR);
   $stmt -> bindParam(':diarydate', $diarydate, PDO::PARAM_STR);
   $stmt -> bindParam(':diarytxt', $diarytxt, PDO::PARAM_STR);      

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

      <!-- Begin: UserDiary Page -->
      <section data-theme="a" id="pageUserDiary" data-role="page" data-fullscreen="false">
         
         <script> writeHeader("backdata", "insertdiary"); </script>

         <div data-role="content">
            <div class="content-primary" id="userDiary">
               <ul data-role="listview" data-filter="true" id="userDiaryList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Last 20 entries</h4>
                  </li>
                  
               <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
               ?>
               
                  <li data-name=<?php echo '"userdiary'.$row[0].'"'; ?> data-inset="true" >  
                     <a href="#popupDiaryTxt" data-rel="popup" data-position-to="window" data-transition="pop">
                     <div class="ui-grid-a">     
                        <div class="ui-block-a" style="font-weight:normal; width:40%; font-size:11px !important;">
                           <?php echo $row[1]; ?> 
                        </div>
                        <div  class="ui-block-b" style="font-weight:normal; width:100%; font-size:11px !important;">
                           <?php echo $row[2]; ?>
                           <input readonly="true" type="hidden" id=<?php echo '"userdiary'.$row[0].'_diarytxt"';?> value=<?php echo '"'.$row[2].'"'; ?> >
                        </div>
                     </div>
                    </a>
                  </li>                   
               <?php } ?>
               
               </ul>
               </div>
            </div>

<!-- Begin: DiaryTxt popup -->
<div id="popupDiaryTxt" class="ui-content" data-role="popup"  data-add-back-btn="false"> 
   <div class="content" data-role="content">
      
      <h4>Diary Entry</h4>
      <p class="diarytxt"></p>
      
      <center>
         <input type="button" id="popupclose" name="popupclose" value="Close" data-inline="true">
      </center>

   </div>
</div>
<!-- End: DiaryTxt div -->

   <script> writeFooter(); </script>

</section>
<!-- End: UserDiary Page -->

<!-- Begin: InsertUserDiary Page -->
<section id="pageInsertUserDiary" data-role="page">

   <script> writeHeader("backdiary", "home"); </script>
   
   <div class="content" data-role="content">
   
      <form id="register" action="userdiary_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

           <fieldset data-role="controlgroup">

            <legend>Diary Entry</legend>
            
            <center>
               <div data-role="fieldcontain">
            <textarea cols="40" class="insertuserdiary" name="diarytxt" id="diarytxt" placeholder="Your diary entry" minlength=4 autofocus required> 
            </textarea>
            </div>
            </center>
          </fieldset>
                      
           <center>
              <input type="button" id="cancel" name="cancel" class="cancel" value="Cancel" data-inline="true">
              <input type="submit" name="insert" id="insert" value="Add" data-inline="true">
           </center>

         </div>
         </form>
   </div>
   
   <script> writeFooter(); </script>

</section>
<!-- End: InsertUserDiary Page -->


<script>

$('#userDiaryList li').click(function() {
   var id = $(this).attr('data-name');  
   localStorage.setItem("id", id);   
}); 

$('#cancel').click(function() {
   url = "#pageUserDiary";
   window.location.href = url;
   return false;
});

$('#popupclose').click(function() {
   $('#popupDiaryTxt').popup("close");
   return true;
});

$( '#popupDiaryTxt' ).on( 'popupbeforeposition',function(event){
   var id = localStorage.getItem("id");
   var diarytxt = document.getElementById(id + "_diarytxt").value;
   $('.diarytxt').empty();
   $('.diarytxt').append(diarytxt);
});

</script>

   </body>
</html>

          