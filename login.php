<?php session_start() ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<!--[if IE 7 ]>       <html class="no-js ie ie7 lte7 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 8 ]>       <html class="no-js ie ie8 lte8 lte9" lang="en-US"> <![endif]-->
<!--[if IE 9 ]>       <html class="no-js ie ie9 lte9>" lang="en-US"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" lang="en-US"> <!--<![endif]-->
 
<html lang="en">
<head> 
	<title>Login</title>
	    
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
     
   <!-- Begin: Login Page -->
   <div id="pageLogin" data-role="page"><section>

      <script> writeHeader("backhome", "settings"); </script>

      <div class="content" data-role="content">

         <form id="login" action="login_submit.php" method="get" rel="external" data-ajax="false">
            <fieldset data-role="controlgroup">

               <legend>Login</legend>
               <center>
                  
               <div data-role="fieldcontain">
                  <input type="text" name="username" id="username"  placeholder="Username" minlength=4 autofocus required>
                  <input type="password" name="password" id="password" placeholder="Password" required>
               </div>
                  
               <div data-role="controlgroup">    
                  <select name="programid" id="programid" class="programid" data-mini="true">
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
               
               </center> 
            </fieldset>

            <center>
               <input type="submit" name="login" id="login" value="Login" data-inline="true">
            </center>
         </form>

         <form id="register" action="register.php" method="get" rel="external" data-ajax="false">
               <center>
                  <input type="submit" name="register" id="register" value="New user enrolment ..." data-inline="true">
               </center>
         </form>
         
      </div>
      
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Login Page -->

</body> 
         
<script>

$('#login').submit(function() {
   var username = document.getElementById("username").value;
   var password = document.getElementById("password").value;
   var programid = document.getElementById("programid").value;

   localStorage.setItem("username", username);
   localStorage.setItem("password", password);
   localStorage.setItem("programid", programid);
   for (var i=0 ; i < programJSON.length; i++) {
      if (programJSON[i].programid == programid) {
         programname = programJSON[i].name;
         localStorage.setItem("programname", programname);       
      }
   }
   
   document.getElementById("programname").value = programname;
   return true;
});

$('#pageLogin').on('pagebeforeshow', function(event) {

   localStorage.setItem("msgidlist", "msg000,");
   
   if (localStorage.getItem("username") != null) {
      var username = localStorage.getItem("username");
      document.getElementById("username").value = username;
   }
      
   if (localStorage.getItem("password") != null) {      
      var password = localStorage.getItem("password");
      document.getElementById("password").value = password;
   }

      
   if (localStorage.getItem("programname") != null) {         
      var programname = localStorage.getItem("programname");
      document.getElementById("programname").value = programname;
      $(".programnameclass").empty();
      if (programname != null) {
         $(".programnameclass").append(programname);
      } else {
         $(".programnameclass").append("default program");         
      }
   }

   if (localStorage.getItem("roletype") != null) {         
      var roletype = localStorage.getItem("roletype");
   }

});

</script>

</html>
