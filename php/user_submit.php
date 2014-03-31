<?php

include("include/session.php");

/*** if we are here the data is valid and we can insert it into database ***/
$username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_GET['password'], FILTER_SANITIZE_STRING);
$pushoveruser = filter_var($_GET['pushoveruser'], FILTER_SANITIZE_STRING);
$fitbitkey = filter_var($_GET['fitbitkey'], FILTER_SANITIZE_STRING);
$fitbitsecret = filter_var($_GET['fitbitsecret'], FILTER_SANITIZE_STRING);
$fitbitappname = filter_var($_GET['fitbitappname'], FILTER_SANITIZE_STRING);

//echo $fitbitkey.'-'.$fitbitappname.'-'.$fitbitsecret.'-'.$password;
//exit;

try {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $stmt = $dbh -> prepare("
      UPDATE user
      SET password = :password,
          pushoveruser = :pushoveruser,
          fitbitkey =    :fitbitkey,
          fitbitsecret = :fitbitsecret,
          fitbitappname = :fitbitappname
      WHERE userid = :userid;
      ");

   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':password', $password, PDO::PARAM_STR);   
   $stmt -> bindParam(':pushoveruser', $pushoveruser, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitsecret', $fitbitsecret, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitkey', $fitbitkey, PDO::PARAM_STR);
   $stmt -> bindParam(':fitbitappname', $fitbitappname, PDO::PARAM_STR);

   $stmt->execute();
   $count = $stmt -> rowCount();

   if ( $count == 0 ) {
      $_SESSION['message'] = 'No user updated';
      header("Location: error.php");
   } else {
      header('Location: settings.php');
   }

} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");
}
?>

<html lang="en">
<head>
   <title>Login Submit Page</title>
   
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   
   <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
   <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
   <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>

<style>
</style>

<body>

   <div data-role="header">
       <h1>Registration Page</h1>
   </div>        

   <textarea disabled="disabled" data-mini="true" cols="40" rows="8" name="textarea-4" id="textarea-4">
      
<?php echo "Registration attempt for ".$_GET['username']." failed. ".$message.$e; ?>

   </textarea>


</body>
</html>
