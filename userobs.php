<?php

include("include/session.php");
include('include/hit.php');

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
         userobsid AS :userobsid,
         obsname AS :obsname,
         obsdate AS :obsdate,
         obsvalue AS :obsvalue,
         obsdesc AS :obsdesc
      FROM 
         userobs
      WHERE userid = :userid     
      AND  programid = :programid 
      ORDER by obsdate DESC
      LIMIT 0, 20;");

   /*** bind the parameters ***/
   $userobsid = "";
   $obsname = "";
   $obsdate = "";
   $obsvalue = "";
   $obsdesc = "";

   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':userobsid', $userobsid, PDO::PARAM_STR);
   $stmt -> bindParam(':obsname', $obsname, PDO::PARAM_STR);
   $stmt -> bindParam(':obsdate', $obsdate, PDO::PARAM_STR);
   $stmt -> bindParam(':obsvalue', $obsvalue, PDO::PARAM_STR);      
   $stmt -> bindParam(':obsdesc', $obsdesc, PDO::PARAM_STR);      

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

      <!-- Begin: Home Page -->
      <section data-theme="a" id="pageUserObs" data-role="page" data-fullscreen="false">

         <script> writeHeader("backdata", "insertobs"); </script>

         <div data-role="content">
            <div class="content-primary" id="ruleOptions">
               <ul data-role="listview" data-filter="true" id="UserObsList" data-inset="true" >
                  <li data-role="divider">
                     <h4>Last 20 observations</h4>
                  </li>   
                           
               <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                  $id = $row[0];
                  $obsname = $row[1];
                  $obsdate = $row[2];
                  $obsvalue = $row[3];                                   
                  $obsdesc = $row[4];                                   
               ?>
                  <li data-name=<?php echo $id; ?> data-inset="true" >
                                      
                     <div class="ui-grid-b">     
                        <div class="ui-block-a" style="font-weight:normal; width:45%; font-size:11px !important;">
                           <?php echo $obsdate; ?> 
                        </div>
                        <div class="ui-block-b" style="font-weight:normal; width:30%; font-size:11px !important;">
                           <?php echo $obsname; ?> 
                        </div>
                        <div class="ui-block-c" style="font-weight:normal; width:25%; text-align:right; font-size:11px !important;">
                           <?php echo $obsvalue; ?> 
                        </div>
                        <div class="ui-block-a" style="font-weight:normal; width:45%; font-size:11px !important;">
                           <?php echo ""; ?> 
                        </div>
                         <div class="ui-block-a" style="font-weight:normal; width:55%; font-size:9px !important;">
                           <?php echo $obsdesc; ?> 
                        </div>                                                            
                     </div>
                     
                  </li>                   
               <?php } ?>
              
               </ul>
            </div>
 
         <script> writeFooter(); </script>
       
      </section>
      <!-- End: userObs Page -->

<!-- Begin: InsertUserObs Page -->
<section id="pageInsertUserObs" data-role="page">

   <script> writeHeader("backobs", "insertobs"); </script>
     
   <div class="content" data-role="content">

      <form id="register" action="userobs_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
            
            <fieldset data-role="controlgroup">
            <legend>Observation Entry</legend>
            
            <div data-role="fieldcontain">
            <label for="obsname">Type:</label>
            <div data-role="controlgroup">
              <select name="obsname" id="obsname" class="obsname"  data-mini="true">
                  <script> 
                  for (var i=0 ; i < obstypeJSON.length; i++) {
                     document.write("<option value=" + obstypeJSON[i].name + ">");
                     document.write("<var class='obsdesc2'>" + obstypeJSON[i].metric + "</var></option>");
                  }
                  </script>
               </select>
            </div>
            </div>

            <div data-role="fieldcontain">
            <label for="obsdesc">Description:</label>
               <input type="text" name="obsdesc" id="obsdesc" class="obsdesc" placeholder="Optional description" data-mini="true" >
            </div>

            <div data-role="fieldcontain">
            <label for="obsdate">Date:</label>
               <input type="date" name="obsdate" id="obsdate" value=<?php echo date('Y-m-d'); ?> style="text-align:center;" />
            </div>

            <div data-role="fieldcontain">
            <label for="obstime">Time:</label>
               <input type="time" name="obstime" id="obstime" value=<?php putenv("TZ=Australia/Sydney"); echo date('H:i'); ?> style="text-align:center;" />
            </div>

            <div data-role="fieldcontain">
            <label for="obsgps">GPS:</label>
               <input type="text" name="obsgps" id = "obsgps" class="obsgps" value="" readonly >
            </div>

            <div data-role="fieldcontain">
            <label for="obsvalue">Value:</label>
               <input type="text" name="obsvalue" id = "obsvalue" class="obsvalue" value=0 style="width:80%;text-align:center !important">
            </div>
            
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
<!-- End: InsertUserObs Page -->


<script>

$('#UserObsList li').click(function() {
   var id = $(this).attr('data-name');  
   localStorage.setItem("id", id); 
}); 

$('#diarybutton').click(function() {
   $('#popupDiaryTxt').popup("close");
});

$('#cancel').click(function() {
   url = "#pageUserObs";
   window.location.href = url;
   return false;
});

$( '#popupDiaryTxt' ).on( 'popupbeforeposition',function(event){
   var diarytxtid = "" + localStorage.getItem("diarytxtid") + "";
   var diarytxt = document.getElementById(diarytxtid).value;
//   alert(diarytxt);
   $('.popupdiarytxtclass').empty();
   $('.popupdiarytxtclass').append(diarytxt);
});

$( '.obsname' ).on('change', function () {
   var choice = document.getElementById("obsname").value;
   if (choice == "other") {
      document.getElementById("obsdesc").placeholder = "Describe activity and metric used";
   } else {
      document.getElementById("obsdesc").placeholder = "Optional description";
   }
});



$( '#pageInsertUserObs' ).on('pagebeforeshow', function(event) {
  
navigator.geolocation.getCurrentPosition (function (pos)
{
  var lat = pos.coords.latitude;
  var lng = pos.coords.longitude;
  document.getElementById("obsgps").value = "Lat: " + lat.toFixed(3) + " Lon: " + lng.toFixed(3);
});
 
        //   document.getElementById("obsdesc").type = "hidden";
});

</script>

   </body>
</html>

          