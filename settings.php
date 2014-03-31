<?php
include('include/sessionlight.php');
#include('include/db.php');
#include('include/hit.php');
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
 
<!-- Begin: Settings page -->
<div data-theme="a" id="pageSettings" data-role="page" data-fullscreen="false" ><section>

  <script> writeHeader("home", "settings"); </script>

   <div data-role="content">
      <div class="content-primary" id="Settings">
         <ul data-role="listview"  id="SettingsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> <h4>Settings Menu</h4> </li>
            <li> <a href="register.php" data-ajax="false">Enroll</a> </li>
            <li> <a href="user.php" data-ajax="false">Account </a> </li>
            <li> <a href="about.php" data-ajax="false">About </a> </li>
            <li> <a href="#popupLogout" data-rel="popup" data-position-to="window" data-transition="pop">Logout </a> </li>
                 
            <li>
               <a href="programgoal.php?ruletype=gashigh" data-ajax="false" >Goals </a>
            </li>
    
            <?php if ( $_SESSION['roletype'] == "architect") { ?>             
               <li> <a href="poll.php?roletype=architect" data-ajax="false">Polls</a> </li>
            <?php } ?>
            
            <li> <a href="rulesettings.php" data-ajax="false">Rules 
               <span class="ui-li-count"><var style="font-style:normal;" class="ruleoptincount"></var> </span>
                </a> 
            </li>
             
            <?php if ( $_SESSION['roletype'] == "administrator") { ?>             
               <li>
                  <a href="rule.php?roletype=administrator" data-ajax="false" >Creation </a>
               </li>
            <?php } ?>
             
            <?php if ( $_SESSION['roletype'] == "architect") { ?>             
               <li>
                  <a href="programrule.php?roletype=architect" data-ajax="false" >Assign </a>
               </li>
            <?php } ?>

         </ul>
      </div>
   </div>
   
   <script> writeFooter(); </script>

<!-- End: Settings page -->


<!-- Begin: Logout popup -->
<div id="popupLogout" class="ui-content" data-role="popup"  data-add-back-btn="false"> 
   <div class="content" data-role="content">
      <h3>Logout</h3>
      <p>Participant <var class=logoutusername> logoutusername </var> will now be logged out.</p>
    
         <form id="logout" action="logout_submit.php" method="post" rel="external" data-ajax="false">
               
            <center>
               <input type="button" id="logoutcancel" name="logoutcancel" class="logoutcancel" value="Cancel" data-inline="true">
               <input type="submit" id="logoutsubmit" name="logoutsubmit" class="logoutsubmit" value="Logout" data-inline="true">
            </center>
         </form>

   </div>
</div>
<!-- End: Logout div -->

</section></div>
<!-- End: Settings section -->

<!-- Begin: Goals Page -->
<div data-theme="a" id="pageGoals" data-role="page"><section>
      
   <script> writeHeader("backhome", "settings"); </script>

   <div data-role="content">
      <div class="content-primary" id="Goal">
         <ul data-role="listview"  id="GoalList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               <h4>Goals </h4>
               </li>

               <li>
               <a href="programruleuser.php?ruletype=gashigh" data-ajax="false">Higher Order
               <span class="ui-li-count"><script>
                  document.write(program.chartusercount);
               </script> </span> </a>
               </li>

               <li>
               <a href="programruleuser.php?ruletype=gaslow" data-ajax="false">Lower Order
               <span class="ui-li-count"><script>
                  document.write(program.chartusercount);
               </script> </span> </a>
               </li>
               
               <li>
               <a href="programruleuser.php?ruletype=gas" data-ajax="false">GAS Levels
               <span class="ui-li-count"><script>
                  document.write(program.chartusercount);
               </script> </span> </a>
               </li>

         </ul>
      </div>
   </div>
 
         <script> writeFooter(); </script>

      </section></div>
      <!-- End: Goalss Page -->

<!-- Begin: Program Page -->
<div data-theme="b" id="pageProgram" data-role="page"><section>
   <header data-role="header" data-add-back-btn="true">
      <a href="#pageSettings" data-role="button" data-icon="back" data-iconpos="notext">Back</a>
      <p class=smallparagraph style="text-align:center; font-weight:bold; font-style:italic;">
         The Nudge Machine <img style="width: 20px; height: 20px;" alt="Flying Cockateil" src="images/cockateil.png">
      </p>
      <a href="index.php"
         data-transition="flip"
         data-role="button"
         data-icon="home"
         data-ajax="false"
         data-iconpos="notext"
         class="ui-btn-right">Home</a>
   </header>
   
   <div class="content" data-role="content">
   
         <form id="program" action="program_submit.php" method="get"  rel="external" data-ajax="false"> 
            <div data-role="fieldcontain">
           <fieldset data-role="controlgroup">
            
           <legend>Program</legend>

            <select name="programname" id="programname">
               <option value="fitbit">Fitbit Activity Monitoring</option>
               <option value="study1">MLWW Study1 Program</option>
               <option value="study2">MLWW Study2 Program</option>
            </select>
           </fieldset>
            
           <center>
              <input type="submit" value="Select Program" id="submit" data-inline="true">
           </center>
         </div>
         </form>

   </div>

   <script> writeFooter(); </script>
         
<script>
$('#program').submit(function() {
   var programname = $(this).find(":selected").val();
   localStorage.setItem("programname", programname);  
   return true;
});
</script>

</section></div>
<!-- End: Program Page -->

<!-- Begin: Register Page -->
<div data-theme="b" id="pageRegister" data-role="page"><section>
   <header data-role="header" data-add-back-btn="true">
      <a href="#pageSettings" data-role="button" data-icon="back" data-iconpos="notext">Back</a>
      <p class=smallparagraph style="text-align:center; font-weight:bold; font-style:italic;">
         The Nudge Machine <img style="width: 20px; height: 20px;" alt="Flying Cockateil" src="images/cockateil.png">
      </p>
      <a href="index.php"
         data-transition="flip"
         data-role="button"
         data-icon="home"
         data-iconpos="notext"
         data-ajax="false"
         class="ui-btn-right">Home</a>
   </header>
   
   <div class="content" data-role="content">
   
      <form id="register" action="register_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
           <fieldset data-role="controlgroup">
            
            <legend>Registration Details</legend>

            <input type="hidden" class="programname" name="programname" id="programname">
            <input type="text" class="registerusername" name="username" id="username" value="" placeholder="Username" minlength=4 autofocus required>
            <input type="password" class="registerpassword" name="password" id="password" value="" autocomplete="off" placeholder="Password" required>
          </fieldset>
            
           <center>
              <input type="submit" value="Register" name="register" id="register" data-inline="true">
           </center>
         </div>
         </form>
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Register Page -->


   </body>

<script>
         
$( '#popupLogout' ).on( 'popupbeforeposition',function(event){
   var username = localStorage.getItem("username");
   $('.logoutusername').empty();
   $('.logoutusername').append(username);
});

$('#register').submit(function() {
   var username = $(".registerusername").val();
   var password = $(".registerpassword").val();
   localStorage.setItem("username", username);
   localStorage.setItem("password", password);
   programname = localStorage.setItem("programname");
   if (programname.length > 0) {
      document.getElementById("programname").value = programname;   
   }
   return true;
});

$('#logoutcancel').click(function() {
   $('#popupLogout').popup("close");
});

$('#logout').submit(function() {
   localStorage.setItem("pointcount", 0);
   localStorage.setItem("username", "");
   localStorage.setItem("roletype", "");   
   return true;
});

$('#pageSettings').on('pagebeforeshow', function(event) {    
   user.msgunreadcount = localStorage.getItem("msgunreadcount");
   user.ruleoptincount = localStorage.getItem("ruleoptincount");
   <?php if ( isset($_SESSION['msgunreadcount']) && isset($_SESSION['ruleoptincount']) ) { ?>
      user.msgunreadcount = "<?php echo $_SESSION['msgunreadcount']; ?>";
      user.ruleoptincount = "<?php echo $_SESSION['ruleoptincount']; ?>";
   <?php } ?>
   $('.ruleoptincount').empty();
   if (user.ruleoptincount != null ) {
      $('.ruleoptincount').append(user.ruleoptincount + " opt-in");
   }
});

</script>
   
</html>

          