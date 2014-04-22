<?php

include("include/session.php");

$obsname = $_GET['obsname'];
$obsvalue = $_GET['obsvalue'];
$startdate = $_GET['startdate'];
$enddate = $_GET['enddate'];

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
        u.username AS :username,
        uo.obsvalue AS :obsvalue,
        uo.obsdate AS :obsdate,
        uo.obsdesc AS :obsdesc
      FROM userobs uo, user u
      WHERE uo.programid = :programid
       AND  uo.userid = :userid
       AND  u.userid = :userid
       AND  uo.userid = u.userid
       AND  obsname = :obsname
       AND  obsdate between :startdate and :enddate
      ");

   /*** bind the parameters ***/
   $username = "";
   $obsvalue = "";
   $obsdate = "";
   $obsdesc = "";
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':obsname', $obsname, PDO::PARAM_STR);
   $stmt -> bindParam(':obsvalue', $obsvalue, PDO::PARAM_STR);
   $stmt -> bindParam(':obsdate', $obsdate, PDO::PARAM_STR);
   $stmt -> bindParam(':obsdesc', $obsdesc, PDO::PARAM_STR);
   $stmt -> bindParam(':startdate', $startdate, PDO::PARAM_STR);
   $stmt -> bindParam(':enddate', $enddate, PDO::PARAM_STR);
      
   $stmt -> execute();
   $count = $stmt->rowCount();
   if ( $count < 1) {
      $_SESSION['message'] = 'No userobs selected';
      header("Location: error.php");
   }
   
   $i = 0;
   while ($row = $stmt->fetch(PDO::FETCH_NUM)) {

      $username[$i] = $row[0];
      $obsvalue[$i] = $row[1];
      $obsdate[$i] = $row[2];
      $obsdesc[$i] = $row[3];
                                
      $factJSON[$i] = " {";
      $factJSON[$i] = $factJSON[$i].'"username" : "'.$username[$i].'", ';
      $factJSON[$i] = $factJSON[$i].'"obsname" : "'.$obsname.'", ';
      $factJSON[$i] = $factJSON[$i].'"obsdate" : "'.$obsdate[$i].'", ';
      $factJSON[$i] = $factJSON[$i].'"obsvalue" : "'.$obsvalue[$i].'", ';
      $factJSON[$i] = $factJSON[$i].'"obsdesc" : "'.$obsdesc[$i].'"  ';      
      $factJSON[$i] = $factJSON[$i]." }"; 
            
      $i = $i + 1;
   }
 
  header('Access-Control-Allow-Origin: *');
  
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
                     <h4>Facts</h4>
                  </li>   
                           
               <?php 
               $i = 0;
               $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                  $fact = $factJSON[$i];
               ?>
                  <li data-name=<?php echo $i; ?> data-inset="true" style="font-weight:normal; font-size:9px !important;">
                    <?php echo $fact; ?>                                                           
                  </li>                   
               <?php 
               $i = $i + 1;
               } ?>
              
               </ul>
            </div>

      <form id="register" action="donudge_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">

           <center>                      
          <fieldset data-role="controlgroup">

            <div data-role="fieldcontain">
              <div data-role="controlgroup">
                <select name="rulename" id="rulename" class="rulename"  data-mini="true">
                  <script> 
                  for (var i=0 ; i < rulenameJSON.length; i++) {
                    document.write("<option value=" + rulenameJSON[i].name + ">");
                    document.write("<var class='rulename'>" + rulenameJSON[i].name + "</var></option>");
                  }
                  </script>
                </select>
              </div>
            </div>


          </center>  
          <center>                                                  
              <input type="button" name="remove" id="remove" value="Remove" data-inline="true">
              <input type="button" name="create" id="create" value="Create" data-inline="true">
              <input type="button" name="nudge" id="nudge" value="Nudge" data-inline="true">
           </center>
          </fieldset>
         </div>
         </form>
         
         <script> writeFooter(); </script>
       
      </section>
      <!-- End: userObs Page -->

</body>

<script>

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

$('#remove').click(function() {
  programid = "<?php echo $programid ?>";
  userid = "<?php echo $userid ?>";
  post_to_url('http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/del', {programid: programid, groupid: userid}, "get");
});   
   
   
$('#create').click(function() {
  
  programid = "<?php echo $programid ?>";
  userid = "<?php echo $userid ?>";
  
  <?php foreach ($factJSON as $fact) { ?>  
    fact = <?php echo json_encode($fact); ?>;
//    post_to_url('http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact', {programid: programid, groupid: userid, factjson: fact }, "post");
    
    $.ajax({
      type: 'POST',
      url: 'http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact',
      data: {programid: programid, groupid: userid, factjson: fact },
      async:false
    });

  <?php } ?>

});   

$('#nudge').click(function() {

  rulename = document.getElementById("rulename").value;
  programid = "<?php echo $programid ?>";
  userid = "<?php echo $userid ?>";

  post_to_url('http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/nudge', {programid: programid, groupid: userid, rulename: rulename}, "get");
});   
   
   
</script>

</html>
          