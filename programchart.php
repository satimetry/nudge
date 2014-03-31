<?php

if (!isset($_GET['charttype'])) {
   $message = 'You must select a charttype to access this page';
   header('Location: index.php');
}
$charttype = $_GET['charttype'];

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   $stmt = $dbh -> prepare("
      SELECT
         programchartid AS programchartid,
         chartname AS :chartname,
         chartlabel AS :chartlabel,
         chartdesc AS :chartdesc
      FROM 
         programchart
      WHERE programid = :programid
       AND  charttype = :charttype;");

   /*** bind the parameters ***/
   $chartname = "";
   $chartlabel = "";
   $chartdesc = "";

   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':charttype', $charttype, PDO::PARAM_STR);
   $stmt -> bindParam(':chartname', $chartname, PDO::PARAM_STR);
   $stmt -> bindParam(':chartlabel', $chartlabel, PDO::PARAM_STR);
   $stmt -> bindParam(':chartdesc', $chartdesc, PDO::PARAM_STR);
   
   $stmt -> execute();

} catch(Exception $e) {

   /*** if we are here, something has gone wrong with the database ***/
   $message = 'We are unable to process your request. Please try again later -->'.$e;
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
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css" />
      <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
      <script src="http://code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js"></script>
      <link rel="stylesheet" href="css/nudge.css" />

   </head>
   <body>

      <!-- Begin: ProgramChart Page -->
      <section id="pageProgramChart" data-role="page" data-fullscreen="false">
   <header data-role="header" data-position="fixed" data-add-back-btn="true">
      <a href="../nudge/#pageCharts" data-role="button" data-icon="back" data-iconpos="notext" rel="external">Back</a>
      <p class=smallparagraph style="text-align:center; font-weight:bold; font-style:italic;">The Nudge Machine
         <img style="width: 20px; height: 20px;" alt="Flying Cockateil" src="images/cockateil.png">
      </p>   
      <a href="index.php"
         data-transition="flip"
         data-role="button"
         data-icon="home"
         data-iconpos="notext"
         class="ui-btn-right">Home</a>
         </header>

         <div data-role="content">
            <div class="content-primary" id="ProgramChart">
               <ul data-role="listview"  id="ProgramChartList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Program Charts</h4>
                  </li>            
     
               <?php $stmt->execute();
               while ($row = $stmt->fetch()) {
               ?>
                  <li data-name=<?php echo "'programchart".$row[0]."'"; ?> data-inset="true" >
                     
                     <?php if ($charttype == "user") { ?>
                       <a href="images/<?php echo $_SESSION['programname']; ?>/user/<?php echo $_SESSION['username']; ?>/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> rel="external">  
                       <img src="images/<?php echo $_SESSION['programname']; ?>/user/<?php echo $_SESSION['username']; ?>/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> alt="<?php echo $row[2]; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $row[2]; ?> </h4> 
                       <p> <?php echo $row[3]; ?> </p>
                       </a>
                     <?php } else if ($charttype == "group") { ?>
                       <a href="images/<?php echo $_SESSION['programname']; ?>/group/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> rel="external">  
                       <img src="images/<?php echo $_SESSION['programname']; ?>/group/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> alt="<?php echo $row[2]; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $row[2]; ?> </h4> 
                       <p> <?php echo $row[3]; ?> </p>
                       </a>                        
                     <?php } else if ($charttype == "program") { ?>
                       <a href="images/<?php echo $_SESSION['programname']; ?>/program/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> rel="external">  
                       <img src="images/<?php echo $_SESSION['programname']; ?>/program/<?php echo $row[1]; ?>.png" title=<?php echo $row[2]; ?> alt="<?php echo $row[2]; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $row[2]; ?> </h4> 
                       <p> <?php echo $row[3]; ?> </p>
                       </a>                        
                     <?php } ?>                     
                  </li>                   
               <?php } ?>
               
               </ul>
            </div>

   <footer data-role="footer" data-position="fixed">
      <p class=verysmallparagraph style="vertical-align:middle; text-align:right">This site maintained by  <a href="mailto:StefanoPicozzi.gmail.com">StefanoPicozzi@gmail.com</a>
      <img style="width: 20px; height: 20px;" alt="Flying Cockateil" src="images/cockateil.png"> </p>
   </footer>

</section>
<!-- End: ProgramChart Page -->

   </body>
</html>

          