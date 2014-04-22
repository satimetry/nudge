<?php
/*** begin our session ***/
session_start();

$username = filter_var($_GET['username'], FILTER_SANITIZE_STRING);
$password = filter_var($_GET['password'], FILTER_SANITIZE_STRING);
$roletype = filter_var($_GET['roletype'], FILTER_SANITIZE_STRING);
$age = filter_var($_GET['age'], FILTER_SANITIZE_STRING);
$sex = filter_var($_GET['sex'], FILTER_SANITIZE_STRING);

$programid = filter_var($_GET['programid'], FILTER_SANITIZE_STRING);
$programname = filter_var($_GET['programname'], FILTER_SANITIZE_STRING);

include("include/db.php");

try {
   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /*** prepare the select statement ***/
   $stmt = $dbh -> prepare("
      SELECT 
         u.userid AS :userid
      FROM user u, programuser pu, program p
      WHERE u.username = :username 
      AND   u.password = :password
      AND   p.programid = pu.programid
      AND   p.programid = :programid
      AND   pu.programid = :programid
      AND   pu.roletype = :roletype
      AND   pu.userid = u.userid;");

   /*** bind the parameters ***/
   $userid = "";
   $programname2 = "";
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':password', $password, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':roletype', $roletype, PDO::PARAM_STR, 40);
   
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   $userid = $row[0];
   $pucount = $stmt -> rowCount();

   if ( $pucount > 0 ) {
      // Already enrolled nothing more to do
      $_SESSION['userid'] = $userid;
      $_SESSION['username'] = $username;
      $_SESSION['programname'] = $programname;
      $_SESSION['programid'] = $programid;
      $_SESSION['roletype'] = $roletype;
      
      $rule = "login";
      include("include/pointcount.php");
      include("include/refresh.php");
      header('Location: index.php');
      exit;      
   }
   
   $stmt = $dbh -> prepare("
   SELECT 
      u.userid AS :userid,
      u.password AS :password2
   FROM 
   user u
   WHERE u.username = :username;");
         
   $userid = "";
   $password2 = "";
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':password2', $password2, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   
   /*** execute the prepared statement ***/
   $stmt -> execute();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   $userid = $row[0];
   $password2 = $row[1];
   $ucount = $stmt -> rowCount();
         
   if ( $ucount == 1 ) {   
      if ( $password != $password2) {
         $_SESSION['message'] = 'This username already exists. Choose a different username or check password.';
         header("Location: error.php");
      }
   }
   
   // Create user record
   if ( $ucount == 0 ) {
      $stmt = $dbh -> prepare("
         INSERT INTO user 
  	      (username, password, age, sex)
    	   VALUES 
      	(:username, :password, :age, :sex);");
      $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
      $stmt -> bindParam(':password', $password, PDO::PARAM_STR, 40);
      $stmt -> bindParam(':age', $age, PDO::PARAM_STR);
      $stmt -> bindParam(':sex', $sex, PDO::PARAM_STR);

      $stmt -> execute();

      $stmt = $dbh -> prepare("
      SELECT 
         userid AS :userid
      FROM 
         user u
      WHERE u.username = :username 
      AND   u.password = :password;");
         
      $userid = "";
      $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
      $stmt -> bindParam(':password', $password, PDO::PARAM_STR, 40);
      $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
   
      /*** execute the prepared statement ***/
      $stmt -> execute();
      $userid = $stmt -> fetchColumn(0);

      $ucount = $stmt -> rowCount();       
      if ( $ucount != 1 ) {   
         $_SESSION['message'] = 'No user inserted. Please try again later...';
         header("Location: error.php");
      }
   }

   // Create pu record   
   $stmt = $dbh -> prepare("
      INSERT INTO programuser 
      (programid, userid, roletype)
      SELECT 
        programid, 
        :userid, 
        :roletype
      FROM program
      WHERE programid = :programid;");

   /*** bind the parameters ***/
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
   $stmt -> bindParam(':roletype', $roletype, PDO::PARAM_STR, 40);   
   $stmt -> execute();

   $pucount = $stmt -> rowCount();       
   if ( $pucount != 1 ) {   
      $_SESSION['message'] = 'No programuser inserted.';
      header("Location: error.php");           
   }

   /*** set the session user_id variable ***/
   $_SESSION['userid'] = $userid;
   $_SESSION['username'] = $username;
   $_SESSION['programname'] = $programname;
   $_SESSION['programid'] = $programid;
   $_SESSION['roletype'] = $roletype;

   // Sweep up the programrules for this program and user
   $stmt = $dbh -> prepare("
      INSERT INTO programruleuser (
         programid,
         ruleid,
         userid,
         rulevalue,
         rulehigh,
         rulelow)
      SELECT
         :programid,
         ruleid,
         :userid,
         1,
         0,
         0
      FROM programuser pu,
           programrule pr
      WHERE pu.userid = :userid
       AND  pr.programid = :programid
       AND  pu.programid = :programid
       AND  pu.programid = pr.programid
      ");        

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);

   $stmt -> execute();  

   $prucount = $stmt -> rowCount();
   if ( $prucount < 1 ) {
//      OK as maybe no rules yet      
//      $_SESSION['message'] = 'No programruleuser inserted. Please try again later...';
//      header("Location: error.php");
   } 
   
   $rule = "login";
   include("include/pointcount.php");
   include("include/refresh.php");
   header('Location: index.php');

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
