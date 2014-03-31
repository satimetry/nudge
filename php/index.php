<?php
include('include/sessionlight.php');
// include('include/db.php');
// include('include/hit.php');
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

      <!-- Begin: Home Page -->
      <div id="pageHome" data-theme="a" data-role="page" data-ajax="false"  >
         
         <script> writeHeader("info", "settings"); </script>


            <div data-role="content">
               <div class="content-primary" id="Home">
                  <ul  data-role="listview" id="HomeList" data-inset="true" data-icon="arrow-r">
                     <li data-role="divider">
                        <h4><var style="font-size:15px;font-style:normal;" class="welcome">welcome</var></h4>
                     </li>
 
                     <li>
                        <a href="login.php" data-ajax="false">Login </a>
                     </li>
                     
                     <?php if ( $_SESSION['roletype'] == "architect" ) { ?>
                     <li>
                        <a href="programuser.php?roletype=participant" data-ajax="false" >Coachees <span class="ui-li-count">
                           <var style="font-style:normal;" class="usercount"></var>
                           </span></a>
                     </li>
                     <?php } ?>
                     
                     <li data-name="nudge">
                        <a href="msg.php" data-ajax="false">Nudges <span class="ui-li-count">
                           <var style="font-style:normal;" class="msgunreadcount"></var>
                           </span></a>
                     </li>
                     <li>
                        <a href="goal.php?ruletype=gashigh" data-ajax="false">Goals <span class="ui-li-count">
                           3  
                           </span></a>
                     </li>
                     <li>
                        <a href="#pageCharts">Charts <span class="ui-li-count">
                           <var style="font-style:normal;" class="chartcount"></var>
                           </span></a>
                     </li>
                     <li>
                        <a href="#pageDataEntry">Data <span class="ui-li-count">
                           <script>
                              document.write(program.dataentrycount);
                           </script></span></a>
                     </li>

                     <li>
                        <a href="programurl.php?urltype=poll" data-ajax="false">Polls <span class="ui-li-count">
                           <var style="font-style:normal;" class="pollcount"></var>
                           </span></a>
                     </li>

                     <li>
                        <a href="#pageResources" >Resources <span class="ui-li-count">
                           <script>
                              document.write("3");
                           </script></span></a>
                     </li>
                                                
                  </ul>
               </div>
            </div>

         <script> writeFooter(); </script>

      </div>
      <!-- End: Home Page -->
      
      <!-- Begin: Charts Page -->
      <div data-theme="a" id="pageCharts" data-role="page" ><section>
      
         <script> writeHeader("backhome", "settings"); </script>

         <div data-role="content">
            <div class="content-primary" id="Chart">
               <ul data-role="listview"  id="ChartList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Charts </h4>
                  </li>
                  <li>
                     <a href="programurl.php?urltype=user" data-ajax="false">User Charts <span class="ui-li-count">
                        <script>
                           document.write(program.chartusercount);
                        </script> </span> </a>
                  </li>
                  <li>
                     <a href="programurl.php?urltype=group" data-ajax="false">Group Charts <span class="ui-li-count">
                        <script>
                           document.write(program.chartgroupcount);
                        </script> </span> </a>
                  </li>
                  <li>
                     <a href="programurl.php?urltype=program" data-ajax="false">Program Charts <span class="ui-li-count">
                        <script>
                           document.write(program.chartprogramcount);
                        </script> </span> </a>
                  </li>
               </ul>
            </div>
         </div>
 
         <script> writeFooter(); </script>

      </section></div>
      <!-- End: Charts Page -->

      <div data-theme="a" id="pageResources" data-role="page"><section>

         <script> writeHeader("backhome", "settings"); </script>
         
         <div data-role="content">
            <div class="content-primary" id="Resource">
               <ul data-role="listview"  id="ResourceList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Resources </h4>                    
                  </li>
                  
                     <li>
                        <a href="programurl.php?urltype=link" data-ajax="false">Links <span class="ui-li-count">
                           <var style="font-style:normal;" class="linkcount"></var>
                           </span></a>
                     </li>
                     
                     <li>
                        <a href="programurl.php?urltype=tool" data-ajax="false">Tools <span class="ui-li-count">
                           <script>
                              document.write(program.toolcount);
                           </script></span></a>
                     </li>

                     <li>
                        <a href="#pageExtras">Extras<span class="ui-li-count">
                           <script>
                              document.write(program.extrascount);
                           </script></span></a>
                     </li>
                  
               </ul>
            </div>
         </div>

         <script> writeFooter(); </script>

      </section></div>
      <!-- End: Resource Page -->
      
      <div data-theme="a" id="pageDataEntry" data-role="page"><section>

         <script> writeHeader("backhome", "settings"); </script>
         
         <div data-role="content">
            <div class="content-primary" id="DataEntry">
               <ul data-role="listview"  id="DataEntryList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Data Entry </h4>
                  </li>
                  <li>
                     <a href="userdiary.php" data-ajax="false">Diary </a>
                     <img src="images/diary.png"  alt="Diary" class="ui-li-thumb"> 
                  </li>
                  <li>
                     <a href="userobs.php" data-ajax="false">Observations </a>
                     <img src="images/obs.png" alt="Diary" class="ui-li-thumb"> 
                  </li>
               </ul>
            </div>
         </div>

         <script> writeFooter(); </script>

      </section></div>
      <!-- End: DataEntry Page -->

      <!-- Begin: Extras Page -->
      <div data-theme="a" id="pageExtras" data-role="page"><section>

         <script> writeHeader("backhome", "settings"); </script>

         <div data-role="content">
            <div class="content-primary" id="Experimental">
               <ul data-role="listview"  id="ExperimentalList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Extras </h4>
                  </li>
	
<script> 
if (program.extrascount > 0 ) {
   for (var i = 0; i < program.extrasitem.length; i++) {
	  document.write('<li> <a href="');
	  document.write(program.extrasitem[i].href + '" ');
	  document.write(' data-ajax=\"false\"> ' + program.extrasitem[i].name);
	  document.write(" </a> </li>");
   }
}
</script>

               </ul>
            </div>
         </div>

         <script> writeFooter(); </script>

      </section></div>
      <!-- End: Extras Page -->

      <!-- Begin: WordCloud Page -->
      <section data-theme="a" id="pageWordCloud" data-role="page">

         <script> writeHeader("backextras", "settings"); </script>
         
         <?php

         require ('include/cloud.php');

         // get contents of a file into a string
         $filename = "data/comments.txt";
         $handle = fopen($filename, "r");
         $contents = fread($handle, filesize($filename));
         fclose($handle);

         $text_content = $contents;
         /*
          "This is a very long text which I want to represent in " .
          "my tag cloud. Normally this data would come from a database " .
          "but this is irrelevant for this example. What is important is that " .
          "the tag cloud data may come from any source you can imagine, like " .
          "a computed variable, CSV file, database, or even another web page";
          */
         ?>

         <center>
            <?php
            $cloud = new PTagCloud(50);
            $cloud -> addTagsFromText($text_content);
            $cloud -> setWidth("300px");
            echo $cloud -> emitCloud();
         ?>
         </center>

         <script> writeFooter(); </script>

      </section>
      <!-- End: WordCloud Page -->

      <!-- Begin: RandomPhrase Page -->
      <section data-theme="a" id="pageRandomPhrase" data-role="page">

         <script> writeHeader("backextras", "settings"); </script>

         <?php

         // get contents of a file into a string;
         $filename = "data/phrases.txt";
         $allqts = array();
         $handle = fopen($filename, "r");
         if ($handle) {
            $i = 0;
            while (($line = fgets($handle)) !== false) {
               if (strlen($line) > 1) {
                  $allqts[$i] = $line;
                  $i = $i + 1;
               }
            }
         } else {
            // error opening the file.
         }
         fclose($handle);

         // Gets the Total number of Items in the array
         $totalqts = (count($allqts));
         // Subtracted 1 from the total because '0' is not accounted for otherwise
         $nmbr = (rand(0, ($totalqts - 1)));
         $quote = $allqts[$nmbr];
         ?>
         <textarea disabled="disabled" cols="40" rows="8" name="textarea-10" id="textarea-10" style="color:black;">
		<?php echo "$quote"; ?>		
	</textarea>
         
         <script> writeFooter(); </script>

      </section>
      <!-- End: RandomPhrase Page -->

</body>

<script>

$('#HomeList li').click(function() {
   var id = $(this).attr('data-name');
   if ( id == "nudge" ) {
      var msgidlist = localStorage.getItem("msgidlist");
      if (msgidlist.length > 7) {
         var url = "refresh_submit.php?msgidlist=\"" + msgidlist +"\"";
// NOT WORKING
//alert(url);
//$.mobile.loadPage(url);
//.pagecontainer.("load", url);
//window.location.href = url;
      }      
   }
}); 

$('#pageHome').on('pagebeforeshow', function(event) {

   var programname = "";
   var username = "";
                           
   <?php if ( isset($_SESSION['programname']) ) { ?> 
      programname = "<?php echo $_SESSION['programname']; ?>";
      localStorage.setItem("programname", programname);
   <?php } ?>

   <?php if ( isset($_SESSION['programid']) ) { ?>
      programid = "<?php echo $_SESSION['programid']; ?>";
      localStorage.setItem("programid", programid);
   <?php } ?>

   if (localStorage.getItem("programname") != null ) {
      programname = localStorage.getItem("programname");
   }

   if (localStorage.getItem("username") != null ) {
      username = localStorage.getItem("username");
   }
                  
   <?php if ( isset($_SESSION['ruleoptincount']) ) { ?>
      user.ruleoptincount = "<?php echo $_SESSION['ruleoptincount']; ?>";
   <?php } ?>

   <?php if ( isset($_SESSION['msgunreadcount']) ) { ?>
      user.msgunreadcount = "<?php echo $_SESSION['msgunreadcount']; ?>";
   <?php } ?>
   $('.msgunreadcount').empty();
   if (user.msgunreadcount != null) {
      $('.msgunreadcount').append(user.msgunreadcount + " unread");
   }

   <?php if ( isset($_SESSION['usercount']) ) { ?>
      user.usercount = "<?php echo $_SESSION['usercount']; ?>";
   <?php } ?>
   $('.usercount').empty();
   if (user.usercount != null ) {
      $('.usercount').append(user.usercount);
   }
      
   <?php if ( isset($_SESSION['chartcount']) ) { ?>
            user.chartcount = "<?php echo $_SESSION['chartcount']; ?>";
   <?php } ?>
   $('.chartcount').empty();
   if (user.chartcount != null ) {
      $('.chartcount').append(user.chartcount);
   }
   
   <?php if ( isset($_SESSION['pollcount']) ) { ?>
      user.pollcount = "<?php echo $_SESSION['pollcount']; ?>";
   <?php } ?>
   $('.pollcount').empty();
   if (user.pollcount != null ) {
      $('.pollcount').append(user.pollcount);
   }
   
   <?php if ( isset($_SESSION['linkcount']) ) { ?>
      user.linkcount = "<?php echo $_SESSION['linkcount']; ?>";
   <?php } ?>
   $('.linkcount').empty();
   if (user.linkcount != null ) {
      $('.linkcount').append(user.linkcount);
   }
   
   <?php if ( isset($_SESSION['pointcount']) ) { ?>
      user.pointcount = "<?php echo $_SESSION['pointcount']; ?>";
   <?php } ?>   
   if (user.pointcount != null ) {
      localStorage.setItem("pointcoint", user.pointcount);
   }

   $('.welcome').empty();         
   if (programname != null) {
      $('.welcome').append("Welcome to the " + programname + " program" );
   } else {
      $('.welcome').append("Please login or enrol");
   }
         
});

</script>

</html>
