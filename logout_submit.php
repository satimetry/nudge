<?php
    
/*** begin our session ***/
session_start();

$_SESSION['username'] = "";
$_SESSION['userid'] ="";
$_SESSION['programname'] = "";
$_SESSION['programid'] ="";
$_SESSION['roletype'] ="";
$_SESSION['msgunreadcount'] ="";
$_SESSION['ruleoptincount'] ="";
$_SESSION['pointcount'] ="";

header('Location: index.php');
?>

<!doctype html>
<!--[if IE 7 ]>       <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>       <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>       <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
   
<html lang="en">
<head>
   <title>Logout Submit Page</title>
   
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
   <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
   <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>

<style>
</style>

<body>

   <div data-role="header">
       <h1>Login Submit Page</h1>
   </div>        

   <textarea disabled="disabled" data-mini="true" cols="40" rows="8" name="textarea-4" id="textarea-4">
      
<?php echo "Logout attempt for ".$_SESSION['username']." failed. ".$message; ?>

   </textarea>


</body>
</html>
