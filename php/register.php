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

<!-- Begin: Register Page -->
<div data-theme="a" id="pageRegister" data-role="page"><section>

   <script> writeHeader("backsettings", "home"); </script>
 
   <div class="content" data-role="content">
            
      <form id="register" action="register_submit.php" method="get"  rel="external" data-ajax="false"> 

         <fieldset data-role="controlgroup">

          <legend>Enrolment</legend>

         <center>         
          <div data-role="fieldcontain">
            <input type="text" class="username" name="username" id="username" value="" placeholder="Username" minlength=4 autofocus required>
            <input type="password" class="password" name="password" id="password" value="" autocomplete="off" placeholder="Password" required>
          </div>

          <div data-role="controlgroup">         
               <select name="programid" id="programid" class="programid"  data-mini="true" >
                  <script> 
                  for (var i=0 ; i < programJSON.length; i++) {
                     if (programJSON[i].isdefault == 1) {
                        document.write("<option value=" + programJSON[i].programid + " selected=selected>");
                     } else {
                        document.write("<option value=" + programJSON[i].programid + " ");                        
                     }
                     document.write("<var class='obsdesc2'>" + programJSON[i].desc + "</var></option>");
                  }
                  </script>
               </select>                     
            <input type="hidden" class="programname" name="programname" id="programname" value="">
         </div>
         
            <div data-role="controlgroup">     
               <select name="roletype2" id="roletype2" class="roletype2" disabled="disabled"  data-mini="true" >
                  <option value="administrator"> Administrator </option>
                  <option value="architect"> Architect </option>
                  <option value="participant" selected="selected"> Participant </option>
               </select>
               <input type="hidden" class="roletype" name="roletype" id="roletype" value="participant" >
            </div>
          </center>                
         </fieldset>            

           <center>
              <input type="submit" value="Enrol" name="register" id="register" data-inline="true">
           </center>

         </div>
         </form>

   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Register Page -->

   </body>

<script>

$('#pageRegister').on('pagebeforeshow', function(event) {
});


$('#register').submit(function() {  
	var username = document.getElementById("username").value;
   var password = document.getElementById("password").value;
   var roletype = document.getElementById("roletype").value;
   var programid = document.getElementById("programid").value;

   localStorage.setItem("username", username);
   localStorage.setItem("password", password);
   localStorage.setItem("roletype", roletype);
   localStorage.setItem("programid", programid);
   for (var i=0 ; i < programJSON.length; i++) {
      if (programJSON[i].programid == programid) {
         programname = programJSON[i].name;
         localStorage.setItem("programname", programname);       
      }
   }
   
   // $('.programname').empty();
   // $('.programname').append(programname);
   document.getElementById("programname").value = programname;
   return true;
});
</script>

</html>
          