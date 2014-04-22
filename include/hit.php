<?php

$hitip = "";
if ( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
    $hitip = $_SERVER['HTTP_CLIENT_IP'];
} elseif ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
    $hitip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} elseif ( !empty($_SERVER['REMOTE_ADDR']) ) {
    $hitip = $_SERVER['REMOTE_ADDR'];
}
$urlname = $_SERVER['PHP_SELF'];
$timestampInSeconds = $_SERVER['REQUEST_TIME']; 
$hitdate = date("Y-m-d H:i:s", $timestampInSeconds);
$programid = 0;
if ( isset($_SESSION['programid']) ) {
	$programid = intval($_SESSION['programid']);
}
$userid = 0;
if ( isset($_SESSION['userid']) ) {
	$userid = intval($_SESSION['userid']);
}

try {
   if ( !isset($dbh) ) {
      $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
      $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   }

	$stmt = $dbh -> prepare("
		INSERT INTO hit (hitdate,   urlname,  hitip,  programid,  userid)
	  	       VALUES (:hitdate, :urlname, :hitip, :programid, :userid)
		;");
	$stmt -> bindParam(':hitdate', $hitdate, PDO::PARAM_STR);
	$stmt -> bindParam(':urlname', $urlname, PDO::PARAM_STR, 40);
	$stmt -> bindParam(':hitip', $hitip, PDO::PARAM_STR, 40);
	$stmt -> bindParam(':programid', $programid, PDO::PARAM_STR, 40);
	$stmt -> bindParam(':userid', $userid, PDO::PARAM_STR, 40);
	$stmt -> execute();
	$count = $stmt -> rowCount();
} catch(Exception $e) {
   $_SESSION['message'] = 'We are unable to process your request. Please try again later...'.$e;
   header("Location: error.php");
}
?>
