<?php
include("include/sessionlight.php");
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
 
<!-- Begin: About page -->
<div data-theme="a" id="pageAbout" data-role="page" data-fullscreen="false"><section>

   <script> writeHeader("backsettings", "home"); </script>
         
   <div class="content" data-role="content">
      <div class="content-primary" id="about">      
         <ul data-role="listview"  id="AboutList" data-inset="true" >

            <li data-role="divider">
               <h4>System Settings</h4>
            </li>            

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a">
                     author
                  </div>
                  <div  class="ui-block-b" >
                     Stefano Picozzi
                  </div>                                   
            </li>  

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a">
                     version
                  </div>
                  <div  class="ui-block-b" >
                     0.1
                  </div>                                   
            </li> 
            
            <li data-role="divider">
               <h4>Client Side Settings</h4>
            </li>            

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a">
                     username
                  </div>
                  <div  class="ui-block-b" >
                     <script> document.write(localStorage.getItem("username")); </script>
                  </div>                                   
            </li>  

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a">
                     password
                  </div>
                  <div  class="ui-block-b" >
                     <script> document.write(localStorage.getItem("password")); </script>
                  </div>                                   
            </li>  
                             
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     programname
                  </div>
                  <div  class="ui-block-b" >
                     <script> document.write(localStorage.getItem("programname")); </script>
                  </div>                                   
            </li>                   
                             
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     programid
                  </div>
                  <div  class="ui-block-b" >
                     <script> document.write(localStorage.getItem("programid")); </script>
                  </div>                                   
            </li>                   

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     roletype
                  </div>
                  <div  class="ui-block-b" >
                     <script> document.write(localStorage.getItem("roletype")); </script>
                  </div>                                   
            </li>  
            
            <li data-role="divider">
               <h4>Server Side Settings</h4>
            </li>            

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     username
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['username']; ?>
                  </div>                                   
            </li>  

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     userid
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['userid']; ?>
                  </div>                                   
            </li>  
            
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     programname
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['programname']; ?>
                  </div>                                   
            </li>   
                       
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     programid
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['programid']; ?>
                  </div>                                   
            </li>   

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     roletype
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['roletype']; ?>
                  </div>                                   
            </li> 
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     toolcount
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['toolcount']; ?>
                  </div>                                   
            </li> 
            
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     msgunreadcount
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['msgunreadcount']; ?>
                  </div>                                   
            </li> 
            
            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     ruleoptincount
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['ruleoptincount']; ?>
                  </div>                                   
            </li>    

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     pointcount
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['pointcount']; ?>
                  </div>                                   
            </li>

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     msgidlist
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $_SESSION['msgidlist']; ?>
                  </div>                                   
            </li>

            <li data-inset="true" >  
               <div class="ui-grid-a">     
                  <div class="ui-block-a" >
                     database
                  </div>
                  <div  class="ui-block-b" >
                     <?php echo $mysql_hostname.":".$mysql_port."/".$mysql_dbname; ?>
                  </div>                                   
            </li>
                                                                                             
         </ul>
      </div
      
   </div>

   <script> writeFooter(); </script>

</section></div>
<!-- End: About section -->



   </body>
</html>

          