<?php

include("include/session.php");
include('include/hit.php');

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */
   
   if ( $roletype == "participant" ) {
      $stmt = $dbh -> prepare("
      SELECT
         r.ruleid AS :ruleid,   
         r.rulename AS :rulename,
         pru.rulevalue AS :rulevalue,     
         r.ruledesc AS :ruledesc,
         pru.rulehigh AS :rulehigh,
         pru.rulelow AS :rulelow,
         pu.userid AS :userid,
         u.username AS :username,
         r.pollname AS :pollname
      FROM 
         programuser pu,
         programrule pr,     
         programruleuser pru,     
         rule r,
         user u
      WHERE pu.userid = :userid 
      AND  pu.userid = pru.userid
      AND  u.userid = pru.userid            
      AND  u.userid = :userid    
      AND  pru.programid = :programid 
      AND  pru.programid = pu.programid
      AND  pr.programid = pu.programid
      AND  pr.ruleid = pru.ruleid 
      AND  r.ruletype = :ruletype
      AND  r.ruleid = pru.ruleid;");
         
   } else if ( $roletype == "architect" ) {
      $stmt = $dbh -> prepare("
         SELECT
            r.ruleid AS :ruleid,   
            r.rulename AS :rulename,    
            r.ruledesc AS :ruledesc,
            r.awardtype AS :awardtype,
            r.pollname AS :pollname
         FROM 
            rule r
         WHERE r.ruleid NOT IN
            (SELECT pr.ruleid
             FROM programrule pr
             WHERE pr.programid = :programid);");
   }

   $rulename = "";
   $ruledesc = "";
   $ruleid = "";
   $awardtype = "";
   $pollname = "";
   
   $stmt -> bindParam(':rulename', $rulename, PDO::PARAM_STR);
   $stmt -> bindParam(':ruledesc', $ruledesc, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
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

      <!-- Begin: Home Page -->
   <div data-theme="a" id="pageProgramRuleUser" data-role="page"><section>
      
      <script> writeHeader("backsettings", "home"); </script>

   <div data-role="content">
      <div class="content-primary" id="ProgramRuleUser">
         <ul data-role="listview" data-filter="true" id="ProgramRuleList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> 
            		<h4> Click gear to add rule </h4>
            </li>

           <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
               	$id = $row[0];
					   $rulename = $row[1];
						$ruledesc = $row[2];
						$awardtype = $row[3];
                  $pollname = $row[4];
            ?>

            <li data-name=<?php echo "pr".$id; ?> data-icon="gear">
               <a href="#popupProgramRule" data-rel="popup" data-position-to="window" data-transition="pop">
               	
               <input type=hidden id=<?php echo "pr".$id."_ruleid"; ?> name="pr_ruleid" value=<?php echo $id; ?> >
               <input type=hidden id=<?php echo "pr".$id."_rulename"; ?> name="pr_rulename" value=<?php echo $rulename; ?> >
               <input type=hidden id=<?php echo "pr".$id."_ruledesc"; ?> name="pr_ruledesc" value=<?php echo $ruledesc; ?> >
               <input type=hidden id=<?php echo "pr".$id."_awardtype"; ?> name="pr_awardtype" value=<?php echo $awardtype; ?> >
               <input type=hidden id=<?php echo "pr".$id."_pollname"; ?> name="pr_pollname" value=<?php echo $pollname; ?> >

               <div data-role="collapsible">
               <h6>               
                  <label for="rulevalueselect" style="font-size:15px !important;"><?php echo $rulename; ?></label>
                  <div class="containing-element">
                     <input type=range name="pr_rulepoint" id="<?php echo "pr".$id."_rulepoint"; ?>" value="0" min="0" max="100">
                  </div>
               </h6>
               <p style="font-size:15px !important;"> <?php echo $ruledesc; ?> </p>
               </div>
               </a>
            </li>
                  
            <?php } ?>
               
         </ul>
      </div>
   </div>

<div data-role="popup" id="popupProgramRule" class="ui-content" style="max-width:340px;">
   <div data-role="controlgroup" data-type="horizontal">
      
      <h3>Add Rule</h3>    
      <p>The rule <var class="rulename">rulename</var> 
      will be added to the <script> document.write(program.name); </script>
      program when you click Add. </p>
         
      <form id="programrule" action="programrule_submit.php" method="get" rel="external" data-ajax="false">
         <input type=hidden name=ruleid id=ruleid>
         <input type=hidden name=rulepoint id=rulepoint>
         <input type=hidden name=pollname id=pollname>

         <center>
            <input type="button" id="pr_cancel" name="pr_cancel" class="pr_cancel" value="Cancel" data-inline="true">
            <input type="submit" id="pr_submit" name="pr_submit" class="pr_submit" value="Add" data-inline="true">
         </center>
      </form>
      
   </div>
</div>
<!-- End: ProgramRule Popup -->
 
   <script> writeFooter(); </script>


</section></div>
<!-- End: ProgramRuleUser Page -->

   </body>           

<script>
       
$('#pr_cancel').click(function() {
   $('#popupProgramRule').popup("close");
});
         
$('#ProgramRuleList li').click(function() {
   var prid = $(this).attr('data-name');
   localStorage.setItem("prid", prid);                                 
   // var rulevalue = $(this).find(":selected").val();      
});  

$( '.rulevalueselect' ).change(function() {
   $(this).data('icon', 'check'); 
   $(this).find(".ui-icon").addClass("ui-icon-check").removeClass("ui-icon-gear"); 
   $(this).buttonMarkup('refresh');
   
   // $(this).attr('data-icon','check');
   // $(this).find(".ui-icon").removeClass('ui-icon-gear').addClass('ui-icon-check');
   // $(this).jqmData('icon','check');
   // alert("Yeppo");
   // $(this).find(".ui-icon").addClass("check").removeClass("gear");
   //$(this).buttonMarkup({ icon: "check" });
   //alert("Change2");
});

   
$( '#popupProgramRule' ).on( 'popupbeforeposition',function(event){

   var prid = localStorage.getItem("prid");
   var ruleid = document.getElementById(prid + "_ruleid").value 
   var rulename = document.getElementById(prid + "_rulename").value 
   var rulepoint = document.getElementById(prid + "_rulepoint").value 
   var pollname = document.getElementById(prid + "_pollname").value 
    
   $('.rulename').empty();
   $('.rulename').append(rulename);

  document.getElementById("ruleid").value = ruleid;
  document.getElementById("rulepoint").value = rulepoint;
  document.getElementById("pollname").value = pollname;

});


</script>

</html>

          