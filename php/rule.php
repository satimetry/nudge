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
         r.ruleid AS :ruleid,   
         r.rulename AS :rulename,    
         r.ruledesc AS :ruledesc,
         r.ruletype AS :ruletype,
         r.awardtype AS :awardtype,
         r.pollname AS :pollname
      FROM 
         rule r
      ORDER BY rulename
      ;");

   $ruleid = "";
   $rulename = "";
   $ruledesc = "";
   $ruletype = "";
   $awardtype = "";
   $pollname = "";

   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);   
   $stmt -> bindParam(':rulename', $rulename, PDO::PARAM_STR);
   $stmt -> bindParam(':ruledesc', $ruledesc, PDO::PARAM_STR);
   $stmt -> bindParam(':ruletype', $ruletype, PDO::PARAM_STR);
   $stmt -> bindParam(':awardtype', $awardtype, PDO::PARAM_STR);
   $stmt -> bindParam(':pollname', $pollname, PDO::PARAM_STR);       
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

      <!-- Begin: Rule Page -->
   <div data-theme="a" id="pageRule" data-role="page"><section>
      
      <script> writeHeader("backsettings", "insertrule"); </script>

   <div data-role="content">
      <div class="content-primary" id="rule">
         <ul data-role="listview" data-filter="true" id="rulelist" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> 
            		<h4> Rules </h4>
            </li>

           <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
               	$id = $row[0];
					   $rulename = $row[1];
						$ruledesc = $row[2];
                  $ruletype = $row[3];
						$awardtype = $row[4];
                  $pollname = $row[5];
            ?>

            <li data-name=<?php echo "r".$id; ?> data-icon="arrow-r">
               <a href="#popupRule" data-rel="popup" data-position-to="window" data-transition="pop">
               	
               <input type=hidden id=<?php echo "r".$id."_ruleid"; ?> name="r_ruleid" value=<?php echo $id; ?> >
               <input type=hidden id=<?php echo "r".$id."_rulename"; ?> name="r_rulename" value="<?php echo $rulename; ?>" >
               <input type=hidden id=<?php echo "r".$id."_ruledesc"; ?> name="r_ruledesc" value="<?php echo $ruledesc; ?>" >
               <input type=hidden id=<?php echo "r".$id."_ruletype"; ?> name="r_ruletype" value=<?php echo $ruletype; ?> >
               <input type=hidden id=<?php echo "r".$id."_awardtype"; ?> name="r_awardtype" value=<?php echo $awardtype; ?> >
               <input type=hidden id=<?php echo "r".$id."_pollname"; ?> name="r_pollname" value=<?php echo $pollname; ?> >

               <div data-role="collapsible">
               <h6>               
                  <?php echo $rulename; ?>
               </h6>
               <p style="font-size:15px !important;"> <?php echo "Level = ".$ruletype.". ".$ruledesc; ?> </p>
               </div>
               </a>
            </li>
                  
            <?php } ?>
               
         </ul>
      </div>
   </div>

<div data-role="popup" id="popupRule" class="ui-content" style="max-width:340px;">
      
   <fieldset data-role="controlgroup">
      <div data-role="fieldcontain">
         <label for="ruleid">ID: </label>
         <input type=text readonly name=ruleid id=pop_ruleid>
         <label for="rulename">Name: </label>
         <input type=text readonly name=rulename id=pop_rulename>
         <label for="ruledesc">Desc: </label>
         <input type=text readonly name=ruledesc id=pop_ruledesc>         
         <label for="ruletype">Type: </label>
         <input type=text readonly name=ruletype id=pop_ruletype>           
         <label for="pollname">Poll: </label>
         <input type=text readonly name=pollname id=pop_pollname>
         <label for="awardtype">Award: </label>
         <input type=text readonly name=awardtype id=pop_awardtype>
      </div>
   </fieldset>
         
   <center>
      <input type="button" id="pop_cancel" name="pop_cancel" class="pop_cancel" value="Close" data-inline="true">
   </center>
      
</div>
<!-- End: Rule Popup -->
 
   <script> writeFooter(); </script>


</section></div>
<!-- End: Rule Page -->

<!-- Begin: InsertRule Page -->
<section id="pageInsertRule" data-role="page">

   <script> writeHeader("backlink", "home"); </script>
   
   <div class="content" data-role="content">
   
   <form id="rule_insert" action="rule_submit.php" method="get"  rel="external" data-ajax="false"> 

   <div data-role="fieldcontain">

      <fieldset data-role="controlgroup">
         <legend>Rule Entry</legend>

         <div data-role="fieldcontain">                     
         <input type=text class=insert_rulename name=rulename id=insert_rulename placeholder="Rule name">
         </div>

         <div data-role="fieldcontain">                                       
         <input type=text name=ruledesc id=insert_ruledesc placeholder="Rule description">
         </div>
         
         <div data-role="fieldcontain">                     
         <fieldset data-role="controlgroup" data-mini="true"> 
         <label for="user">User</label>
         <input type="radio" name="ruletype" id="user" value="user" />
         <label for="group">Group</label>
         <input type="radio" name="ruletype" id="group" value="group" />
         <label for="program">Program</label>
         <input type="radio" name="ruletype" id="program" value="program" checked="checked" />
         <label for="poll">Poll</label>
         <input type="radio" name="ruletype" id="poll" value="poll" />
         <label for="system">System</label>
         <input type="radio" name="ruletype" id="system" value="system" />
         </fieldset>
         </div>

         <div data-role="fieldcontain">                                       
         <input type=text name=pollname id=insert_rpollname placeholder="Poll Name">
         </div>
         
         <div data-role="fieldcontain">            
         <fieldset data-role="controlgroup" data-mini="true">      
         <label for="awardtype" class="select">Award:</label>
         <select name="awardtype" id="insert_awardtype" data-mini="true">
            <option value="gold">Gold</option>
            <option value="silver">Silver</option>
            <option value="bronze">Bronze</option>
            <option value="cockateil">Cockateil</option>
         </select> 
         </fieldset>
         </div>
         
      </fieldset>
                         
   <center>
      <input type="button" id="insert_cancel" name="insert_cancel" class="cancel" value="Cancel" data-inline="true">
      <input type="submit" name="insert_submit" id="insert_submit" value="Add" data-inline="true">
   </center>

   </div>
   </form>

   </div>
   
   <script> writeFooter(); </script>

<script>
$('#rule').submit(function() {
   var username = $(".registerusername").val();
//   var programname = $(this).find(":selected").val();
   localStorage.setItem("username", username);
//   localStorage.setItem("programname", programname);  
   return true;
});
</script>

</section>
<!-- End: InsertRule Page -->

   </body>           

<script>
       
$('#pop_cancel').click(function() {
   $('#popupRule').popup("close");
});
         
$('#rulelist li').click(function() {
   var rid = $(this).attr('data-name');
   localStorage.setItem("rid", rid);                                 
});  
   
$( '#popupRule' ).on( 'popupbeforeposition',function(event){
   var rid = localStorage.getItem("rid");
   var ruleid = document.getElementById(rid + "_ruleid").value 
   var rulename = document.getElementById(rid + "_rulename").value 
   var ruledesc = document.getElementById(rid + "_ruledesc").value 
   var ruletype = document.getElementById(rid + "_ruletype").value 
   var awardtype = document.getElementById(rid + "_awardtype").value 
   var pollname = document.getElementById(rid + "_pollname").value 
    
   document.getElementById("pop_ruleid").value = ruleid;
   document.getElementById("pop_rulename").value = rulename;
   document.getElementById("pop_ruledesc").value = ruledesc;
   document.getElementById("pop_ruletype").value = ruletype;
   document.getElementById("pop_awardtype").value = awardtype;
   document.getElementById("pop_pollname").value = pollname;
});


</script>

</html>

          