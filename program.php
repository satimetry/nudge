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

<!-- Begin: Program Page -->
<div data-theme="a" id="pageProgram" data-role="page"><section>

  <script> writeHeader("backsettings", "home"); </script>

   
   <div class="content" data-role="content">
   
         <form id="program" action="program_submit.php" method="get"  rel="external" data-ajax="false"> 
            <div data-role="fieldcontain">
           <fieldset data-role="controlgroup">
            
           <legend>Program</legend>

            <select class="programname" name="programname" id="programname">
               
<script> 
for (var i = 0; i < programJSON.length; i++) {
   document.write('<option value=\"' + programJSON[i].name + '\"> ' + programJSON[i].desc + '</option>');
}
</script>
            </select>
           </fieldset>
            
           <center>
              <input type="submit" name="submit" value="Select Program" id="submit" data-inline="true">
           </center>
         </div>
         </form>

   </div>
   
   <script> writeFooter(); </script>

<script>

$('#program').submit(function() {
   var programname = $(this).find(":selected").val();
   localStorage.setItem("programname", programname);
   return true;
});

</script>

</section></div>
<!-- End: Program Page -->

   </body>

</html>

