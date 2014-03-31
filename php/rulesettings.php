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

      <!-- Begin: Rule Page -->
      <div data-theme="a" id="pageRule" data-role="page"><section>

       <script> writeHeader("backsettings", "home"); </script>
         
         <div data-role="content">
            <div class="content-primary" id="Rule">
               <ul data-role="listview" id="RuleList" data-icon="arrow-r" data-inset="true" >
                  <li data-role="divider">
                     <h4>Rules</h4>
                  </li>
                  
                  <li>
                     <a href="programruleuser.php?ruletype=group" data-ajax="false">Group </a>
                  </li>
                  
                  <li>
                     <a href="programruleuser.php?ruletype=program" data-ajax="false">Program </a>
                  </li>
                  
                  <li>
                     <a href="programruleuser.php?ruletype=poll" data-ajax="false">Poll </a>
                  </li>
                  
                  <li>
                     <a href="programruleuser.php?ruletype=system" data-ajax="false">System </a>
                  </li>
                                                             
               </ul>
            </div>
         </div>

      <script> writeFooter(); </script>

      </section></div>
      <!-- End: Rule Page -->

 

   </body>

   <script>
      $('#pageRule').on('pagebeforeshow', function(event) {
         var username = localStorage.getItem("username");
         var programname = localStorage.getItem("programname");
         $('.welcome').empty();
         //  if (username && programname) {
         //     $('.welcome').append("Welcome " + username + " to the " + programname + " program." );
         //   } else
         if (programname) {
            $('.welcome').append("Welcome to the " + programname + " program");
         } else {
            $('.welcome').append("Please login or register");
         }
      });

   </script>

</html>
