<?php

include("include/session.php");
include('include/hit.php');

if (!isset($_GET['urltype'])) {
   $message = 'You must select a urltype to access this page';
   header('Location: index.php');
}
$urltype = $_GET['urltype'];

$roletype = 'participant';
if ( isset($_SESSION['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 
if ( isset($_GET['roletype']) ) {
   $roletype = $_SESSION['roletype'];
} 

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   /* Find the last completed question for this user */

   // Todo, need to join programurl to msg for poll records
   
   if ( $roletype == "participant") {

      if ( $urltype != 'poll') {      
         $stmt = $dbh -> prepare("
         SELECT          
         programurlid AS programurlid,
         urlname AS :urlname,
         urllabel AS :urllabel,
         urldesc AS :urldesc,
         userid AS :userid,
         username AS :username,
         urldate AS :urldate,
         msgid AS :msgid
         FROM (
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.msgid AS msgid
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
         AND  pu.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  purl.urltype = :urltype
         AND  purl.msgid IS NULL
         UNION ALL
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.msgid AS msgid  
         FROM 
         programurl purl, 
         programuser pu,
         user u,
         msg m,
         programruleuser pru,
         rule r
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
         AND  pu.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  urltype = :urltype
         AND  purl.msgid IS NOT NULL
         AND  m.userid = pu.userid
         AND  m.msgid = purl.msgid
         AND  r.rulename = m.rulename
         AND  pru.programid = :programid
         AND  pru.userid = pu.userid
         AND  pru.userid = :userid
         AND  pru.ruleid = r.ruleid
         AND  pru.rulevalue = 1
         ) a ORDER BY urldate DESC
       ");
      } else {
         $stmt = $dbh -> prepare("
         SELECT          
         programurlid AS programurlid,
         urlname AS :urlname,
         urllabel AS :urllabel,
         urldesc AS :urldesc,
         userid AS :userid,
         username AS :username,
         urldate AS :urldate,
         msgid AS :msgid    
         FROM (
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.msgid AS msgid  
         FROM 
         programurl purl, 
         programuser pu,
         user u,
         programruleuser pru,
         poll p,
         rule r
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
         AND  pu.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  purl.urltype = :urltype
         AND  purl.msgid IS NULL
         AND  r.pollname = purl.urlname
         AND  p.pollname = r.pollname
         AND  pru.userid = pu.userid
         AND  pru.rulevalue = 1
         AND  pru.ruleid = r.ruleid 
         UNION ALL
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.msgid AS msgid  
         FROM 
         programurl purl, 
         programuser pu,
         user u,
         msg m,
         programruleuser pru,
         rule r
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
         AND  pu.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  urltype = :urltype
         AND  purl.msgid IS NOT NULL
         AND  m.userid = pu.userid
         AND  m.msgid = purl.msgid
         AND  r.rulename = m.rulename
         AND  pru.programid = :programid
         AND  pru.userid = pu.userid
         AND  pru.userid = :userid
         AND  pru.ruleid = r.ruleid
         AND  pru.rulevalue = 1
         ) a ORDER BY urldate DESC
       ");         
                                
      }                        

   } 
   
   if ( $roletype == "architect" ) {

      if ($urltype === "user" ) {
       $stmt = $dbh -> prepare("
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS :urlname,
         purl.urllabel AS :urllabel,
         purl.urldesc AS :urldesc,
         u.userid AS :userid,
         u.username AS :username,
         purl.urldate AS :urldate,
         purl.msgid AS :msgid  
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
         AND  pu.programid = :programid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  urltype = :urltype
         ORDER by urlname, username;");
      $userid = ""; 
     
     } else if ($urltype != "user" ) {

      $stmt = $dbh -> prepare("
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS :urlname,
         purl.urllabel AS :urllabel,
         purl.urldesc AS :urldesc,
         u.userid AS :userid,
         u.username AS :username,
         purl.urldate AS :urldate,
         purl.msgid AS :msgid  
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = pu.programid
          AND  pu.programid = :programid
         AND  purl.programid = :programid
         AND  pu.userid = u.userid
         AND  pu.roletype = 'architect'
         AND  pu.userid = :userid
         AND  urltype = :urltype
         ORDER by urldate DESC");
      }
      
//     $userid = ""; 
   }
   
   /*** bind the parameters ***/
   $urlname = "";
   $urllabel = "";
   $urldesc = "";
   $username = "";
   $urldate = "";
   $msgid = "";
   
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':urltype', $urltype, PDO::PARAM_STR);
   $stmt -> bindParam(':urlname', $urlname, PDO::PARAM_STR);
   $stmt -> bindParam(':urllabel', $urllabel, PDO::PARAM_STR);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':urldesc', $urldesc, PDO::PARAM_STR);
   $stmt -> bindParam(':urldate', $urldate, PDO::PARAM_STR);
   $stmt -> bindParam(':msgid', $msgid, PDO::PARAM_STR);
               
//   $stmt -> execute();

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

      <!-- Begin: Programurl Page -->
      <div data-theme="a" id="index.php" data-role="page" data-fullscreen="false"><section>
   <header data-role="header" data-position="fixed" data-add-back-btn="true">
      <a href="index.php#pageurls" data-role="button" data-icon="back" data-iconpos="notext" rel="external">Back</a>
      <p class=smallparagraph style="text-align:center; font-weight:bold; font-style:italic;">The Nudge Machine
         <img style="width: 20px; height: 20px;" alt="Flying Cockateil" src="images/cockateil.png">
      </p>   
      <a href="#pageInsertURL"
         data-transition="flip"
         data-role="button"
         data-icon="plus"
         data-iconpos="notext"
         data-ajax="false"
         class="ui-btn-right">Home</a>
         </header>

         <div data-role="content">
            <div class="content-primary" id="Programurl">
               <ul data-role="listview" data-filter="true" id="ProgramurlList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Program Resources</h4>
                  </li>            
     
               <?php $stmt->execute();
               while ( $row = $stmt->fetch(PDO::FETCH_NUM) ) {
                  $id = $row[0];
                  $urlname = $row[1];
                  $urllabel = $row[2];
                  $urldesc = $row[3];
                  $userid = $row[4];
                  $username = $row[5];
                  $urldate = $rown[6];
                  $msgid = $row[7];
               ?>
                     
                  <?php if ($urltype == "user" && $roletype != "architect") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/user/".$username."/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                          
                           <a href="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> rel="external">  
                           <img src="<?php echo $filename; ?>" alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                           <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                           <p> <?php echo $urldesc; ?> </p>
                           </a>

                        </li>                          
                     <?php } ?>
                  <?php } ?>

                  <?php if ($urltype == "user" && $roletype == "architect") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/user/".$username."/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
   
                           <a href="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> rel="external">  
                           <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                           <h4 class="ui-li-heading"> <?php echo $urllabel. " for ".$username; ?> </h4> 
                           <p> <?php echo $urldesc; ?> </p>
                           </a>

                        </li>                          
                     <?php } ?>
                  <?php } ?>
                                                               
                  <?php if ($urltype == "group") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/group/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                       
                           <a href="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> rel="external">  
                           <img src="<?php echo $filename; ?>" title=<?php echo $urlabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                           <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                           <p> <?php echo $urldesc; ?> </p>
                           </a>
                       
                        </li>                          
                     <?php } ?>                       
                  <?php } ?>
                                                                   
                  <?php if ($urltype == "program") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/program/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                        
                           <a href="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> rel="external">  
                           <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                           <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                           <p> <?php echo $urldesc; ?> </p>
                           </a>                        
                       
                        </li>                          
                     <?php } ?>                       
                  <?php } ?>
                     
                  <?php if ($urltype == "link") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/link/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                       
                       <a href="<?php echo $urldesc; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                       <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                       <p> <?php echo $urldesc; ?> </p>
                       </a>                        
                        </li>    
                                              
                     <?php } ?>  
                  <?php } ?>    

                  <?php if ($urltype == "poll") { ?>
                     <?php $filename = "images/poll.png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                       
                       <a href="<?php echo $urldesc."&msgid=".$msgid; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                       <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $urllabel." - ".$username; ?> </h4> 
                       <p> <?php echo $urldesc; ?> </p>
                       </a>                        
                        </li>    
                                              
                     <?php } ?>  
                  <?php } ?>    

                  <?php if ($urltype == "tool") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/tool/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                        
                       <a href="<?php echo $urldesc; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                       <img src="images/<?php echo $_SESSION['programname']; ?>/tool/<?php echo $urlname; ?>.png" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                       <p> <?php echo $urldesc; ?> </p>
                       </a>      
                                         
                        </li>                          
                     <?php } ?>  
                  <?php } ?>    
                            
               <?php } ?>
               
               </ul>
            </div>

   <script> writeFooter(); </script>

</section></div>
<!-- End: Programurl Page -->

<!-- Begin: InsertURL Page -->
<section id="pageInsertURL" data-role="page">

   <script> writeHeader("backlink", "home"); </script>
   
   <div class="content" data-role="content">
   
      <form id="url" action="programurl_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
            
            <h3>Link Entry</h3>

           <fieldset data-role="controlgroup">

            <div data-role="fieldcontain">
               <label for="urllabel">Label: </label>
               <input type="text" id="urllabel" name="urllabel" class="urllabel" placeholder="Short Description" >
            </div>
                                    
            <div data-role="fieldcontain">
               <label for="urldesc">URL: </label>
               <input type="text" id="urldesc" name="urldesc" class="urldesc" placeholder="URL resource" >
            </div>

          </fieldset>
                                  
           <center>
              <input type="button" id="cancel" name="cancel" class="cancel" value="Cancel" data-inline="true">
              <input type="submit" name="insert" id="insert" value="Add" data-inline="true">
           </center>

         </div>
         </form>
   </div>
   
   <script> writeFooter(); </script>

<script>
$('#url').submit(function() {
   var username = $(".registerusername").val();
//   var programname = $(this).find(":selected").val();
   localStorage.setItem("username", username);
//   localStorage.setItem("programname", programname);  
   return true;
});
</script>

</section>
<!-- End: InsertURL Page -->


<script>

$('#ProgramurlList li').click(function() {
   var id = $(this).attr('data-name') + "_diarytxt";  
   localStorage.setItem("programurlid", id);   
}); 


$('#cancel').click(function() {
   return false;
});

$( '#pageInsertURL' ).on('pagebeforeshow', function(event) {
//   var id = localStorage.getItem("programurlid");
//   var programid = document.getElementById(id + "_programid").value;
//   alert(programid);
//   $('.popupdiarytxtclass').empty();
//   $('.popupdiarytxtclass').append(diarytxt);
});
</script>

   </body>
</html>

          