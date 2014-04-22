<?php

include("include/session.php");
include('include/hit.php');

if (!isset($_GET['urltype'])) {
   $_SESSION['message'] = 'You must select a urltype to access this page';
   header("Location: error.php");
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

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
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
         ruleid AS :ruleid,
         urltype AS :urltype
         FROM (
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.ruleid AS ruleid,
         purl.urltype AS urltype
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = purl.programid
         AND  pu.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  purl.urltype = :urltype
         ) a ORDER BY urllabel
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
         ruleid AS :ruleid,
         urltype AS :urltype    
         FROM (
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS urlname,
         purl.urllabel AS urllabel,
         purl.urldesc AS urldesc,
         u.userid AS userid,
         u.username AS username,
         purl.urldate AS urldate,
         purl.ruleid AS ruleid,
         purl.urltype AS urltype
         FROM 
         programurl purl, 
         programuser pu,
         user u,
         programruleuser pru,
         poll p,
         rule r,
         programrule pr
         WHERE purl.programid = :programid
         AND  pu.programid = pru.programid
         AND  pr.programid = pru.programid
         AND  pu.programid = :programid
         AND  pru.programid = :programid
         AND  p.programid = :programid
         AND  u.userid = :userid
         AND  u.userid = pu.userid
         AND  pu.roletype = 'participant'
         AND  purl.urltype = :urltype
         AND  r.pollname = purl.urlname
         AND  p.pollname = r.pollname
         AND  r.ruletype = 'poll'
         AND  pru.userid = pu.userid
         AND  pru.rulevalue = 1
         AND  pru.ruleid = r.ruleid 
         AND  pr.ruleid = pru.ruleid
         AND  pr.programid = :programid
         ) a ORDER BY urllabel   
       ");         
                                
      }                        

   } 
   
   if ( $roletype != "participant" ) {

      if ($urltype == "user" ) {
       $stmt = $dbh -> prepare("
         SELECT
         purl.programurlid AS programurlid,
         purl.urlname AS :urlname,
         purl.urllabel AS :urllabel,
         purl.urldesc AS :urldesc,
         u.userid AS :userid,
         u.username AS :username,
         purl.urldate AS :urldate,
         purl.ruleid AS :ruleid,
         purl.urltype AS :urltype 
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = purl.programid
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
         purl.ruleid AS :ruleid,
         purl.urltype AS :urltype 
         FROM 
         programurl purl, 
         programuser pu,
         user u
         WHERE purl.programid = :programid
         AND  pu.programid = purl.programid
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
   $ruleid = "";
      
   $stmt -> bindParam(':programid', $programid, PDO::PARAM_STR);
   $stmt -> bindParam(':urltype', $urltype, PDO::PARAM_STR);
   $stmt -> bindParam(':urlname', $urlname, PDO::PARAM_STR);
   $stmt -> bindParam(':urllabel', $urllabel, PDO::PARAM_STR);
   $stmt -> bindParam(':userid', $userid, PDO::PARAM_STR);
   $stmt -> bindParam(':username', $username, PDO::PARAM_STR);
   $stmt -> bindParam(':urldesc', $urldesc, PDO::PARAM_STR);
   $stmt -> bindParam(':urldate', $urldate, PDO::PARAM_STR);
   $stmt -> bindParam(':ruleid', $ruleid, PDO::PARAM_STR);
   $stmt -> bindParam(':urltype', $urltype, PDO::PARAM_STR);
                  
//   $stmt -> execute();

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

      <!-- Begin: Programurl Page -->
    <div data-theme="a" id="pageProgramurl" data-role="page" data-fullscreen="false">
      <section>
 
        <?php 
        if ( $roletype != 'participant' ) {       
            echo "<script> writeHeader(\"backhome\", \"inserturl\") </script>";
        } else {
            echo "<script> writeHeader(\"backhome\", \"home\") </script>";
        } 
        ?>
                   
         <div data-role="content">
            <div class="content-primary" id="Programurl">
               <ul data-role="listview" data-filter="true" id="ProgramurlList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Program Resources</h4>
                  </li>            
     
               <?php $stmt->execute();
               $count = $stmt->rowCount();
               while ( $row = $stmt->fetch(PDO::FETCH_NUM) ) {
                  $id = $row[0];
                  $urlname = $row[1];
                  $urllabel = $row[2];
                  $urldesc = $row[3];
                  $userid = $row[4];
                  $username = $row[5];
                  $urldate = $rown[6];
                  $ruleid = $row[7];
                  $urltype = $row[8];
                  
               ?>
                  <?php if ($urltype == "user" && $roletype != "architect") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/user/".$username."/".$urlname.".png"; ?>
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                           <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                           
                        <a href="<?php echo $filename; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                        <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
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
                           <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
   
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
                           <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                       
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
                           <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                        
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
                     <?php if ( !file_exists($filename) ) {
                       $filename = "images/html.png";
                     } ?>
                     <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                      <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                       
                      <a href="<?php echo $urldesc; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                      <img src="<?php echo $filename; ?>"  title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                      <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                      <p> <?php echo $urldesc; ?> </p>
                      </a>                        
                    </li>                            
                  <?php } ?>    
                                       
                  <?php if ($urltype == "poll") { ?>
                     <?php $filename = "images/poll.png"; ?> 
                     <?php if ( file_exists($filename) ) { ?>
                        <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                           <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                       
                       <a href="<?php echo $urldesc."&ruleid=".$ruleid; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                       <img src="<?php echo $filename; ?>" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $urllabel." - ".$username; ?> </h4> 
                       <p> <?php echo $urldesc; ?> </p>
                       </a>                        
                        </li>    
                                              
                     <?php } ?>  
                  <?php } ?>    

                  <?php if ($urltype == "tool") { ?>
                     <?php $filename = "images/".$_SESSION['programname']."/tool/".$urlname.".png"; ?>
                     <?php if ( !file_exists($filename) ) {
                       $filename = "images/html.png";
                     } ?>
                     <li data-name=<?php echo "'programurl".$id."'"; ?> data-inset="true" >
                       <input readonly="true" type="hidden" id="<?php echo 'programurl'.$id.'_urltype';?>" value=<?php echo '"'.$urltype.'"'; ?> >
                        
                       <a href="<?php echo $urldesc; ?>" title=<?php echo '"'.$urllabel.'"'; ?> data-ajax=FALSE rel="external">  
                       <img src="images/<?php echo $_SESSION['programname']; ?>/tool/<?php echo $urlname; ?>.png" title=<?php echo $urllabel; ?> alt="<?php echo $urllabel; ?>" class="ui-li-thumb">  
                       <h4 class="ui-li-heading"> <?php echo $urllabel; ?> </h4> 
                       <p> <?php echo $urldesc; ?> </p>
                       </a>      
                                         
                    </li>                          
                  <?php } ?>    
                            
               <?php } ?>
               
               </ul>
            </div>

      <script> writeFooter(); </script>

    </section>
  </div>
<!-- End: Programurl Page -->

<!-- Begin: InsertURL Page -->
<section id="pageInsertURL" data-role="page">

   <script> writeHeader("backlink", "home"); </script>
   
   <div class="content" data-role="content">
   
      <form id="url" action="programurl_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
            
           <fieldset data-role="controlgroup">
            
            <legend>Resource</legend>
            
            <div data-role="fieldcontain">
               <label for="urllabel">Label: </label>
               <input type="text" id="urllabel" name="urllabel" class="urllabel" placeholder="Short Description" >
            </div>

            <div data-role="fieldcontain">
            <label for="urltype">Type:</label>                      
            <div data-role="controlgroup">   
              <select name="urltype" id="urltype" class="urltype" data-mini="true" >
                <?php if ( $urltype == "link" ) { ?>
                  <option value="link" selected="selected"> Link </option>
                  <option value="tool"> Tool </option>
                  <option value="poll"> Poll </option>
                <?php } else if ( $urltype == "poll" ) { ?>
                  <option value="link" > Link </option>
                  <option value="tool" > Tool </option>
                  <option value="poll" selected="selected"> Poll </option>
                <?php } else if ( $urltype == "tool" ) { ?>
                  <option value="link" > Link </option>
                  <option value="tool" selected="selected"> Tool </option>
                  <option value="poll" > Poll </option>               
                <?php } else if ( $urltype == "user" ) { ?>
                  <option value="user" selected="selected"> User Chart </option>
                  <option value="group" > Group Chart </option>               
                  <option value="program" > Program Chart </option>                             
                <?php } else if ( $urltype == "group" ) { ?>
                  <option value="user" > User Chart </option>
                  <option value="group" selected="selected"> Group Chart </option>               
                  <option value="program" > Program Chart </option>               
                <?php } else if ( $urltype == "program" ) { ?>
                  <option value="user" > User Chart </option>
                  <option value="group" > Group Chart </option>               
                  <option value="program" selected="selected"> Program Chart </option>               
                <?php } ?>   
              </select>
            </div>
            </div>
                        
            <div data-role="fieldcontain">
               <label for="urlname">URL icon: </label>
               <input type="text" id="urlname" name="urlname" class="urlname" value="html" >
            </div>
                                    
            <div data-role="fieldcontain">
               <label for="urldesc">URL: </label>
               <input type="text" id="urldesc" name="urldesc" class="urldesc" placeholder="http://contextualscience.org" >
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

</section>
<!-- End: InsertURL Page -->

</body>
   
<script>

$( '#pageProgramurl' ).on('pagebeforeshow', function(event) {
   localStorage.setItem("id", "");
});

$('#ProgramurlList li').click(function() {
   var id = $(this).attr('data-name');  
   localStorage.setItem("id", id);
}); 


$('#cancel').click(function() {
   $.mobile.changePage("#pageProgramurl");
   return true;
});

$( '#pageInsertURL' ).on('pagebeforeshow', function(event) {
  var id = localStorage.getItem("id");
  if ( id.length > 0 ) {
    urltype = document.getElementById(id + "_urltype").value;
  } else {
    urltype = "<?php echo $urltype; ?>";
  }
  document.getElementById("urltype").value = urltype;
});

</script>

</html>
