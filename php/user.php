<?php

include("include/session.php");
include('include/hit.php');

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $stmt = $dbh -> prepare("
      SELECT
         u.userid AS :userid,
         u.username AS :username,
         u.password AS :password,
         u.pushoveruser AS :pushoveruser,
         u.fitbitsecret AS :fitbitsecret,
         u.fitbitkey AS :fitbitkey,
         u.fitbitappname AS :fitbitappname       
      FROM
         user u 
      WHERE u.userid = :userid
      ;");

   /*** bind the parameters ***/
   $username = "";
   $password = "";
   $pushoveruser = "";
   $fitbitsecret = "";
   $fitbitkey = "";
   $fitbitappname = "";
   
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
   $stmt -> bindParam(':pushoveruser', $pushoveruser, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitsecret', $fitbitsecret, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitkey', $fitbitkey, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitappname', $fitbitappname, PDO::PARAM_STR);

   $stmt->execute();
   $row = $stmt->fetch(PDO::FETCH_NUM);

   $userid = $row[0];
   $username = $row[1];
   $password = $row[2];
   $pushoveruser = $row[3];
   $fitbitsecret = $row[4];
   $fitbitkey = $row[5];
   $fitbitappname = $row[6]; 
                            
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

<!-- Begin: Programuser Page -->
<div data-theme="a" id="pageProgramuser" data-role="page"><section>

   <script> writeHeader("backsettings", "accountinfo"); </script>

   <div class="content" data-role="content">
   
      <form id="register" action="user_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">


            <fieldset data-role="controlgroup">
            
            <legend>Account Details</legend>

            <div data-role="fieldcontain">
            <label for="username">Username:</label>
            <input type="text" class="username" name="username" id="username" value="<?php echo $username; ?>" disabled="disabled" >
            </div>

            <div data-role="fieldcontain">
            <label for="password">Password:</label>            
            <input type="password" class="password" name="password" id="password" value="<?php echo $password; ?>" >
            </div>
            
            <div data-role="fieldcontain">
            <label for="pushoveruser">pushover.net user:</label>
            <input style="font-size:15px;" type="text" class="pushoveruser" name="pushoveruser" placeholder="Optional" id="pushoveruser" 
               value="<?php echo $pushoveruser; ?>" > 
            </div>            

                           
            <div data-role="fieldcontain">
            <label for="fitbitkey">Fitbit key:</label>            
            <input style="font-size:15px;" type="text" class="fitbitkey" name="fitbitkey" placeholder="Optional" id="fitbitkey" value="<?php echo $fitbitkey; ?>" >
            </div>

            <div data-role="fieldcontain">
            <label for="fitbitsecret">Fitbit secret:</label>              
            <input style="font-size:15px;" type="text" class="fitbitsecret" name="fitbitsecret" placeholder="Optional" id="fitbitsecret" value="<?php echo $fitbitsecret; ?>" >
            </div>
            
            <div data-role="fieldcontain">
            <label for="fitbitappname">Fitbit appname:</label>             
            <input type="text" class="fitbitappname" name="fitbitappname" placeholder="Optional" id="fitbitappname" value="<?php echo $fitbitappname; ?>" >
            </div>

            </fieldset>
                                  
           <center>
              <input type="submit" value="Save Changes" name="submit" id="submit" data-inline="true">
           </center>
         </div>
         </form>
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Programuser Page -->

   </body>

<script>

</script>


</html>

          