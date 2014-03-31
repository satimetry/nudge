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

<!-- Begin: DoNudge Page -->
<section id="pageDoNudge" data-role="page">

   <script> writeHeader("backdata", "settings"); </script>
     
   <div class="content" data-role="content">

      <form id="register" action="donudge_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
            
          <fieldset data-role="controlgroup">
            <legend>Fact Selection</legend>
            
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
            <label for="startdate">Start Date:</label>
               <input type="date" name="startdate" id="startdate" value="2014-01-01" style="text-align:center;" />
            </div>

            <div data-role="fieldcontain">
            <label for="enddate">End Date:</label>
               <input type="date" name="enddate" id="enddate" value=<?php echo date('Y-m-d'); ?> style="text-align:center;" />
            </div>
            
          </fieldset>
                  
           <center>
              <input type="button" id="cancel" name="cancel" class="cancel" value="Cancel" data-inline="true">
              <input type="submit" name="nudge" id="nudge" value="Select" data-inline="true">
           </center>

         </div>
         </form>
         
   </div>
   
   <script> writeFooter(); </script>

</section>
<!-- End: DoNudge Page -->


<script>

$('#UserObsList li').click(function() {
   var id = $(this).attr('data-name');  
   localStorage.setItem("id", id); 
}); 

$('#diarybutton').click(function() {
   $('#popupDiaryTxt').popup("close");
});

function post_to_url(path, params, method) {
    method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);

    for(var key in params) {
        if(params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);

            form.appendChild(hiddenField);
         }
    }

    document.body.appendChild(form);
    form.submit();
}

$('#delete').click(function() {
  programid = "<?php echo $programid ?>";
  userid = "<?php echo $userid ?>";
  alert("hello" + programid);
  post_to_url('http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/del', {programid: programid, groupid: userid}, "get");
});   
   
$('#cancel').click(function() {
   url = "#pageDoNudge";
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

          