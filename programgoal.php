<?php

include("include/session.php");
include('include/hit.php');

if ( isset($_GET['ruletype']) ) {
   $ruletype = $_GET['ruletype'];
} else {
   $ruletype = "program";
}  

$roletype = 'participant';
if ( isset($_SESSION['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 

if ( isset($_GET['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 

if ( isset($_GET['parentruleid']) ) {
   $parentruleid = $_GET['parentruleid'];
} 

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */
   
   if ( $roletype == "participant" ) {
      if ( strpos($ruletype, "gashigh") !== false ) {
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
         pru.ruleuserdesc AS :ruleuserdesc,
         r.ruletype AS :userruletype
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
         AND  r.ruletype LIKE CONCAT(:ruletype, '%')
         AND  r.ruleid = pru.ruleid
         ORDER BY rulename;");
 
      } else {
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
         pru.ruleuserdesc AS :ruleuserdesc,
         r.ruletype AS :userruletype
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
         AND  r.ruletype LIKE CONCAT(:ruletype, '%')
         AND  r.ruleid = pru.ruleid
         AND  r.parentruleid = :parentruleid
         ORDER BY rulename;");      
      }    
              
   } else if ( $roletype != "participant" ) {
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
         pru.ruleuserdesc AS :ruleuserdesc,              
         r.ruletype AS :userruletype
      FROM 
         programuser pu,
         programrule pr,     
         programruleuser pru,     
         rule r,
         user u
      WHERE
           pu.userid = pru.userid
      AND  u.userid = pru.userid      
      AND  pru.programid = :programid 
      AND  pru.programid = pu.programid
      AND  pr.programid = pu.programid
      AND  pr.ruleid = pru.ruleid
      AND  pu.roletype = 'participant'
      AND  r.ruletype LIKE CONCAT(:ruletype, '%')
      AND  r.ruleid = pru.ruleid
      ORDER BY rulename;");      
      $userid = "";
   }
   /*** bind the parameters ***/
   $rulename = "";
   $ruledesc = "";
   $rulevalue = "";
   $ruleid = "";
   $rulehigh = "";   
   $rulelow = "";
	$username = "";
   $ruleuserdesc = "";
   $userruletype = "";
   
	$stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruletype', $ruletype, PDO::PARAM_STR);
   $stmt -> bindParam(':rulename', $rulename, PDO::PARAM_STR);
   $stmt -> bindParam(':rulevalue', $rulevalue, PDO::PARAM_STR);
   $stmt -> bindParam(':ruledesc', $ruledesc, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':rulehigh', $rulehigh, PDO::PARAM_STR);
   $stmt -> bindParam(':rulelow', $rulelow, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleuserdesc', $ruleuserdesc, PDO::PARAM_STR);
   $stmt -> bindParam(':userruletype', $userruletype, PDO::PARAM_STR);
   $stmt -> bindParam(':parentruleid', $parentruleid, PDO::PARAM_STR);
         
//echo "role=".$roletype.$message;
//exit;
         
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
      <script src="js/customjqm.js"  ></script>  
      <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
      
      <link rel="stylesheet" href="css/nudge.css" />      
      <script src="js/nudge.js"  ></script>  
      <script> var config = false; </script>
        
   </head>
   <body>

      <!-- Begin: Home Page -->
   <div data-theme="a" id="pageProgramGoal" data-role="page"><section>
      
      <script> writeHeader("backsettings", "home"); </script>

   <div data-role="content">
      <div class="content-primary" id="ProgramGoal">
         <ul data-role="listview" data-filter="true" id="ProgramGoalList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> 

              <script>
              var ruletype = "<?php echo $ruletype; ?>";
              if ( ruletype == "gashigh" ) { 
                document.write("<h4> Higher order goals </h4>");
              } else if ( ruletype == "gaslow" ) {
                document.write("<h4> Lower order goals </h4>");                
              } else {
                document.write("<h4> Goal attainment scale </h4>");                
              }
              </script>
              
            </li>
            	
            <?php $stmt->execute();
               while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
               	$id = $row[0];
					   $rulename = $row[1];
						$rulevalue = $row[2];
						$ruledesc = $row[3];
						$rulehigh = $row[4];
						$rulelow = $row[5];
                  $userid = $row[6];
                  $username = $row[7];                 															
                  $ruleuserdesc = $row[8];   
                  $userruletype = $row[9];                                                                             
            ?>

            <li data-name=<?php echo "pru".$id; ?> data-icon="gear">
               <a href="index.html">
               	
               <input type=hidden id=<?php echo "pru".$id."_ruleid"; ?> name="ruleid" value=<?php echo $id; ?> >
               <input type=hidden id=<?php echo "pru".$id."_rulename"; ?> name="rulename" value="<?php echo $rulename; ?>" >
               <input type=hidden id=<?php echo "pru".$id."_rulehigh"; ?> name="rulehigh" value=<?php echo $rulehigh; ?> >
               <input type=hidden id=<?php echo "pru".$id."_rulelow"; ?> name="rulehigh" value=<?php echo $rulelow; ?> >
               <input type=hidden id=<?php echo "pru".$id."_userid"; ?> name="userid" value=<?php echo $userid; ?> >
               <input type=hidden id=<?php echo "pru".$id."_ruledesc"; ?> name="ruledesc" value="<?php echo $ruledesc; ?>" >
               <input type=hidden id=<?php echo "pru".$id."_ruleuserdesc"; ?> name="ruledesc" value="<?php echo $ruleuserdesc; ?>" >
               <input type=hidden id=<?php echo "pru".$id."_ruletype"; ?> name="ruletype" value="<?php echo $userruletype; ?>" >
                
               <h6>
                  <?php 
                  if ( strlen($ruleuserdesc) > 0 ) {
                     echo $ruleuserdesc;
                  } else {
                     echo $ruledesc; 
                  } ?>
               </h6>
                  <?php if ( $userruletype == "gashigh" ) { ?>
                     <a class="config" href="#pageUpdateGAS"> Customise</a>
                  <?php } else if ( $userruletype == "gaslow" ) { ?>                   
                     <a class="config" href="#pageUpdateGAS"> Customise</a>
                  <?php } else if ( strpos($userruletype, "gas" ) !== false ) { ?>                   
                  	<a class="config" href="#pageUpdateRuleUser" data-ajax="false"> Customise</a>
                  <?php } else { ?>
          	   
                  	<a id="config" href="#popupProgramRuleUser" data-rel="popup" data-position-to="window" data-transition="pop">
                     Save Changes</a>
                   <?php } ?>
            </li>
                  
            <?php } ?>
               
         </ul>
      </div>
   </div>

<div data-role="popup" id="popupProgramGoal" class="ui-content" style="max-width:340px;">
   <div data-role="controlgroup" data-type="horizontal">
      
      <h3>Save Changes?</h3>    
      <p>The rule <var class="popup_rulename" >rulename </var> 
      will be set to value <var class="popup_rulevalue"> rulevalue </var>  
      when you click submit. </p>
         
      <form id="pru_submit" action="programruleuser_submit.php" method="get" rel="external" data-ajax="false">
               
         <input type=hidden name=ruleid id="ruleid" value="" >
         <input type=hidden name=rulevalue id="rulevalue" value="" >
         <input type=hidden name=crudtype id="crudtype" value="read">
         <input type=hidden name=ruletype id="ruletype" value="">

         <center>
            <input type="button" id="pru_cancel" name="pru_cancel" class="pru_cancel" value="Cancel" data-inline="true">
            <input type="submit" id="pru_submit" name="pru_submit" class="pru_submit" value="Save Changes" data-inline="true">
         </center>
      </form>
      
   </div>
</div>
<!-- End: ProgramRuleUser Popup -->
 
   <script> writeFooter(); </script>


</section></div>
<!-- End: ProgramRuleUser Page -->

<!-- Begin: pageUpdateGAS Page -->
<div data-theme="a" id="pageUpdateGAS" data-role="page"><section>
   
   <script> writeHeader("backrulegas", "settings"); </script>
 
   <div class="content" data-role="content">

      <form id="pru_update" action="programruleuser_submit.php" method="get"  rel="external" data-ajax="false"> 

         <div data-role="fieldcontain">

           <fieldset data-role="controlgroup">
            <legend><var style="font-style:normal" class="ruledesc"></var></legend>

            <center>

            <input type=hidden name=crudtype id=crudtype value="update">
            <input type=hidden name=ruleid id="user_ruleid" value ="">
            <input type=hidden name=rulename id="user_rulename" value="">
            <input type=hidden name=ruletype id="user_ruletype" value="">

            <div data-role="fieldcontain">
               <label for="user_ruleuserdesc"> Goal Description: </label>
               <input data-clear-btn="true" type="text" class="user_ruleuserdesc" name="ruleuserdesc" id="user_ruleuserdesc" placeholder="Optional description" data-mini="true">
            </div>
   
            <div data-role="fieldcontain" >                                 
            <fieldset data-role="controlgroup" data-mini="true"> 
               <label for="opt-in">Opt-in</label>
               <input type="radio" name="rulevalue" id="opt-in" value="1" checked="checked" />
               <label for="opt-out">Opt-out</label>
               <input type="radio" name="rulevalue" id="opt-out" value="0" />
            </fieldset>
            </div>
  
            </center>
           </fieldset>
         </div>
                        
         <div data-role="fieldcontain">                                       
            <center>
               <input type="submit" name="insert" id="user_insert" value="Update" data-inline="true">
            </center>
         </div>

      </form>
      
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: pageUpdateGAS Page -->

<!-- Begin: pageUpdateRuleUser Page -->
<div data-theme="a" id="pageUpdateRuleUser" data-role="page"><section>
   
   <script> writeHeader("backrulegas", "settings"); </script>
 
   <div class="content" data-role="content">

      <form id="pru_update" action="programruleuser_submit.php" method="get"  rel="external" data-ajax="false"> 

         <div data-role="fieldcontain">

           <fieldset data-role="controlgroup">
            <legend><var style="font-style:normal" class="ruledesc"></var></legend>

            <input type=hidden name=crudtype id=crudtype value="update">
            <input type=hidden name=ruleid id="pru_ruleid" value="">
            <input type=hidden name=rulename id="rulename" value="">
            <input type=hidden name=ruletype id="pru_ruletype" >
         
            <div data-role="fieldcontain">
               <label for="user_ruleuserdesc"> Goal Description: </label>
               <input type="text" class="user_ruleuserdesc" name="ruleuserdesc" id="ruleuserdesc" placeholder="Optional description" data-mini="true">
            </div>
   
            <div data-role="fieldcontain">
            	<label for="user_rulehigh"> High Target: </label>
         		<input type="number" class="user_rulehigh" name="rulehigh" id="rulehigh" data-mini="true">
				</div>

            <div data-role="fieldcontain">						
            	<label for="user_rulelow"> Low Target: </label>         		
         		<input type="number" class="user_rulelow" name="rulelow" id="rulelow" data-mini="true">
  				</div>

            <div data-role="fieldcontain" >
           <label for="rulevalue"> Opt-in/out: </label>                                   
            <div data-role="controlgroup" data-mini="true"> 
               <label for="opt-in">Opt-in</label>
               <input type="radio" class="rulevalue" name="rulevalue" id="opt-in" value="1" checked="checked" />
               <label for="opt-out">Opt-out</label>
               <input type="radio" class="rulevalue" name="rulevalue" id="opt-out" value="0" />
            </div>
            </div>

           </fieldset>
         </div>
           					
         <div data-role="fieldcontain">						      	         	
            <center>
              	<input type="submit" name="insert" id="user_insert" value="Update" data-inline="true">
            </center>
         </div>

      </form>
      
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: pageUpdateRuleUser Page -->

</body>           

<script>

$( ".config" ).click(function() {
  config = true;
  return true;
});

$( ".config" ).mouseenter(function() {
  config = true;
  return true;
});

$( ".config" ).mouseover(function() {
  config = true;
  return true;
});

$( ".config" ).mouseleave(function() {
  config = false;
  return true;
});

$( ".config" ).mouseout(function() {
  config = false;
  return true;
});

$('#pru_cancel').click(function() {
   $('#popupProgramRuleUser').popup("close");
});
         
$('#ProgramGoalList li').click(function() {
   var id = $(this).attr('data-name');
   localStorage.setItem("id", id);
   var ruletype = document.getElementById(id + "_ruletype").value;   
   var ruleid = document.getElementById(id + "_ruleid").value;   
   
   if (!config || config == null) {
   if ( ruletype == "gashigh" ) {
      url = "programgoal.php?ruletype=gaslow&parentruleid=" + ruleid;
      window.location.href = url;
      return true;
   } else if ( ruletype == "gaslow" ) {
      url = "programgoal.php?ruletype=gas&parentruleid=" + ruleid;
      window.location.href = url;
      return true;
   } else {
      return true;
   }
   }
});  

$( '.rulevalueselect' ).change(function() {
   $(this).data('icon', 'check'); 
   $(this).find(".ui-icon").addClass("ui-icon-check").removeClass("ui-icon-gear"); 
   $(this).buttonMarkup('refresh');

   var id = $(this).attr('data-name');  
   localStorage.setItem("id", id);

   // $(this).attr('data-icon','check');
   // $(this).find(".ui-icon").removeClass('ui-icon-gear').addClass('ui-icon-check');
   // $(this).jqmData('icon','check');
   // alert("Yeppo");
   // $(this).find(".ui-icon").addClass("check").removeClass("gear");
   //$(this).buttonMarkup({ icon: "check" });
   //alert("Change2");
});

   
$( '#popupProgramGoal' ).on( 'popupbeforeposition',function(event){

   var id = localStorage.getItem("id");
   var rulename = document.getElementById(id + "_rulename").value;
   var rulevalue = document.getElementById(id + "_rulevalue").value;
   var ruletype = document.getElementById(id + "_ruletype").value;
   var ruleid = document.getElementById(id + "_ruleid").value;

   $('.popup_rulename').empty();
   $('.popup_rulename').append(rulename);
   $('.popup_rulevalue').empty();
   $('.popup_rulevalue').append(rulevalue);

   document.getElementById("ruleid").value = ruleid;
   document.getElementById("rulevalue").value = rulevalue;
   document.getElementById("ruletype").value = ruletype;
});

$('#user_cancel').click(function() {
   $.mobile.changePage("#pageProgramRuleUser");
});

$( '#pageUpdateRuleUser' ).on('pagebeforeshow', function(event) {

   var id = localStorage.getItem("id");

   // inject read counter update here
   var rulename = document.getElementById(id + "_rulename").value;
   var ruledesc = document.getElementById(id + "_ruledesc").value;
   var ruleuserdesc = document.getElementById(id + "_ruleuserdesc").value;
//   var rulevalue = document.getElementById(id + "_rulevalue").value;
   var ruleid = document.getElementById(id + "_ruleid").value;
   var rulehigh = document.getElementById(id + "_rulehigh").value;
   var rulelow = document.getElementById(id + "_rulelow").value;
   var ruletype = document.getElementById(id + "_ruletype").value;
      
   $('.ruledesc').empty();
   $('.ruledesc').append(ruledesc);
   
   document.getElementById("ruleid").value = ruleid;
//   document.getElementById("pru_rulevalue").value = rulevalue;
   document.getElementById("rulename").value = rulename;
   document.getElementById("ruleuserdesc").value = ruleuserdesc;
   document.getElementById("rulehigh").value = rulehigh;
   document.getElementById("rulelow").value = rulelow;
   document.getElementById("pru_ruletype").value = ruletype;
   document.getElementById("pru_ruleid").value = ruleid;

});

$( '#pageUpdateGAS' ).on('pagebeforeshow', function(event) {

   var id = localStorage.getItem("id");

   // inject read counter update here
   var rulename = document.getElementById(id + "_rulename").value;
   var ruledesc = document.getElementById(id + "_ruledesc").value;
   var ruleuserdesc = document.getElementById(id + "_ruleuserdesc").value;
//   var rulevalue = document.getElementById(id + "_rulevalue").value;
   var ruleid = document.getElementById(id + "_ruleid").value;
   var rulehigh = document.getElementById(id + "_rulehigh").value;
   var rulelow = document.getElementById(id + "_rulelow").value;
   var ruletype = document.getElementById(id + "_ruletype").value;

   $('.ruledesc').empty();
   $('.ruledesc').append(ruledesc);
   
   document.getElementById("user_ruleid").value = ruleid;
//   document.getElementById("user_rulevalue").value = rulevalue;
   document.getElementById("user_rulename").value = rulename;
   document.getElementById("user_ruleuserdesc").value = ruleuserdesc;
   document.getElementById("user_ruletype").value = ruletype;
 
});
</script>

</html>

          