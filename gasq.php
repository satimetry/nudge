<?php

include("include/session.php");
include('include/hit.php');

if ( isset($_GET['pollid']) ) {
   $pollid = $_GET['pollid'];
   $_SESSION['pollid'] = $pollid;
}

if ( isset($_GET['ruleid']) ) {
    $ruleid = $_GET['ruleid'];
    $_SESSION['ruleid'] = $_GET['ruleid']; 
}

if ( !isset($_GET['pollid']) && !isset($_GET['ruleid']) ) {
   $message = 'You must select a poll to access this page';
   header('Location: index.php');
}

try {

   $dbh = new PDO("mysql:host=$mysql_hostname;port=$mysql_port;dbname=$mysql_dbname", $mysql_username, $mysql_password);
   /*** $message = a message saying we have connected ***/

   /*** set the error mode to excptions ***/
   $dbh -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   if ( $ruleid > 0 ) {
      $stmt = $dbh->prepare("
      SELECT
         p.pollid AS :pollid
      FROM poll p,
           rule r
      WHERE p.pollname = r.pollname
       AND  p.programid = :programid
       AND  r.ruleid = :ruleid;
       ");      
      
      $pollid = ""; 
      $stmt->bindParam(':ruleid', $ruleid, PDO::PARAM_STR);  
      $stmt->bindParam(':pollid', $pollid, PDO::PARAM_STR);  
      $stmt->bindParam(':programid', $programid, PDO::PARAM_STR);  
         
      $stmt->execute();
      $count = $stmt -> rowCount();
      $row = $stmt->fetch(PDO::FETCH_NUM);
   
      if ( $count > 0 ) {
         $pollid = $row[0];
      } else {
         $_SESSION['message'] = 'No poll record found'; 
         header("Location: error.php");
      }
   }

   $stmt = $dbh->prepare("
      SELECT
         pru.ruleuserdesc AS :ruleuserdesc,
         r.parentruleid AS :parentruleid
      FROM programruleuser pru,
           poll p,
           rule r
      WHERE pru.programid = :programid
       AND  p.programid = :programid
       AND  pru.userid = :userid
       AND  p.pollid = :pollid
       AND  r.ruletype = 'gaslow'
       AND  pru.ruleid = r.ruleid
       AND  r.pollname = p.pollname;
       ");
   
   $ruleuserdesc = "";
   $parentruleid = "";
   
   $stmt->bindParam(':programid', $programid, PDO::PARAM_STR);     
   $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);     
   $stmt->bindParam(':pollid', $pollid, PDO::PARAM_STR);     
   $stmt->bindParam(':ruleuserdesc', $ruleuserdesc, PDO::PARAM_STR);     
   $stmt->bindParam(':parentruleid', $parentruleid, PDO::PARAM_STR);  
   
   $stmt->execute();
   $count = $stmt -> rowCount();
   $row = $stmt->fetch(PDO::FETCH_NUM);
   
   if ( $count > 0 ) {
      $lowerordergoal = $row[0];
      $parentruleid = $row[1];
   }

   if ( $parentruleid > 0 ) {
               
      $stmt = $dbh->prepare("
         SELECT
         pru.ruleuserdesc AS :ruleuserdesc
         FROM programruleuser pru,
           rule r
         WHERE pru.programid = :programid
         AND  pru.ruleid = r.ruleid
         AND  pru.userid = :userid
         AND  r.ruleid = :parentruleid;       
       ");

      $ruleuserdesc = "";
   
      $stmt->bindParam(':programid', $programid, PDO::PARAM_STR);     
      $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);     
      $stmt->bindParam(':parentruleid', $parentruleid, PDO::PARAM_STR);           
      $stmt->bindParam(':ruleuserdesc', $ruleuserdesc, PDO::PARAM_STR);     
   
      $stmt->execute();
      $count = $stmt -> rowCount();
      $row = $stmt->fetch(PDO::FETCH_NUM);
   
      if ( $count > 0 ) {
         $higherordergoal = $row[0];
      }
          
      $stmt = $dbh->prepare("
         SELECT
         pru.ruleuserdesc AS :ruleuserdesc
         FROM programruleuser pru,
           rule r
         WHERE pru.programid = :programid
         AND  r.parentruleid = :ruleid
         AND  pru.ruleid = r.ruleid
         AND  pru.userid = :userid
         AND  r.rulename LIKE 'gas%';
         ORDER BY rulename DESC;
       ");
       
      $ruleuserdesc = "";
      
      $stmt->bindParam(':programid', $programid, PDO::PARAM_STR);     
      $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);     
      $stmt->bindParam(':ruleid', $ruleid, PDO::PARAM_STR);     
      $stmt->bindParam(':ruleuserdesc', $ruleuserdesc, PDO::PARAM_STR);     

      $stmt->execute();
      $i = 0;
      while ( $row = $stmt->fetch(PDO::FETCH_NUM) ) {
         $qlabel[$i] = $row[0];
         $i++;
      }      
   }

   /*** prepare the select statement ***/
   $stmt = $dbh->prepare("
      SELECT
         pq.qname AS :qname,
         pq.qinstruction AS :qinstruction,
         pq.qtext AS :qtext,
         pq.qseqno AS :qseqno,
         pq.qcount AS :qcount,
         pq.q01value AS :q01value,
         pq.q02value AS :q02value,                  
         pq.q03value AS :q03value,
         pq.q04value AS :q04value,
         pq.q05value AS :q05value,
         pq.q06value AS :q06value,
         pq.q07value AS :q07value,                  
         pq.q08value AS :q08value,
         pq.q09value AS :q09value,
         pq.q10value AS :q10value,         
         pq.q01label AS :q01label,
         pq.q02label AS :q02label,                  
         pq.q03label AS :q03label,
         pq.q04label AS :q04label,
         pq.q05label AS :q05label,
         pq.q06label AS :q06label,
         pq.q07label AS :q07label,                  
         pq.q08label AS :q08label,
         pq.q09label AS :q09label,
         pq.q10label AS :q10label,
         p.qcount AS :qtotalcount,
         p.polldesc AS :polldesc,         
         p.pollname AS :pollname         
      FROM pollq pq, poll p
      WHERE pq.programid = :programid
       AND  pq.pollid = p.pollid
       AND  p.pollid = :pollid
       AND  pq.pollid = :pollid
      ORDER BY qseqno;
   ");

   $qname = "";
   $qinstruction = "";
   $qtext = "";
   $qseqno = "";
   $qcount = "";
   $q01value = "";
   $q02value = "";              
   $q03value = "";
   $q04value = "";
   $q05value = "";
   $q06value = "";
   $q07value = "";              
   $q08value = "";
   $q09value = "";
   $q10value = "";   
   $q01label = "";
   $q02label = "";              
   $q03label = "";
   $q04label = "";
   $q05label = "";
   $q06label = "";
   $q07label = "";              
   $q08label = "";
   $q09label = "";
   $q10label = "";
   $qtotalcount = "";
   $polldesc = "";
   $pollname = "";
      
   $stmt->bindParam(':pollid', $pollid, PDO::PARAM_STR);     
   $stmt->bindParam(':programid', $programid, PDO::PARAM_STR);     
   $stmt->bindParam(':qname', $qname, PDO::PARAM_STR);     
   $stmt->bindParam(':qtext', $qtext, PDO::PARAM_STR);
   $stmt->bindParam(':qinstruction', $qinstruction, PDO::PARAM_STR);
   $stmt->bindParam(':qseqno', $qseqno, PDO::PARAM_STR);
   $stmt->bindParam(':qcount', $qcount, PDO::PARAM_STR);      
   $stmt->bindParam(':q01value', $q01value, PDO::PARAM_STR);
   $stmt->bindParam(':q02value', $q02value, PDO::PARAM_STR);
   $stmt->bindParam(':q03value', $q03value, PDO::PARAM_STR);
   $stmt->bindParam(':q04value', $q04value, PDO::PARAM_STR);
   $stmt->bindParam(':q05value', $q05value, PDO::PARAM_STR);
   $stmt->bindParam(':q06value', $q06value, PDO::PARAM_STR);
   $stmt->bindParam(':q07value', $q07value, PDO::PARAM_STR);
   $stmt->bindParam(':q08value', $q08value, PDO::PARAM_STR);
   $stmt->bindParam(':q09value', $q09value, PDO::PARAM_STR);
   $stmt->bindParam(':q10value', $q10value, PDO::PARAM_STR);
   $stmt->bindParam(':q01label', $q01label, PDO::PARAM_STR);
   $stmt->bindParam(':q02label', $q02label, PDO::PARAM_STR);
   $stmt->bindParam(':q03label', $q03label, PDO::PARAM_STR);
   $stmt->bindParam(':q04label', $q04label, PDO::PARAM_STR);
   $stmt->bindParam(':q05label', $q05label, PDO::PARAM_STR);
   $stmt->bindParam(':q06label', $q06label, PDO::PARAM_STR);
   $stmt->bindParam(':q07label', $q07label, PDO::PARAM_STR);
   $stmt->bindParam(':q08label', $q08label, PDO::PARAM_STR);
   $stmt->bindParam(':q09label', $q09label, PDO::PARAM_STR);
   $stmt->bindParam(':q10label', $q10label, PDO::PARAM_STR);                  
   $stmt->bindParam(':qtotalcount', $qtotalcount, PDO::PARAM_STR);                  
   $stmt->bindParam(':polldesc', $polldesc, PDO::PARAM_STR);                  
   $stmt->bindParam(':pollname', $pollname, PDO::PARAM_STR);                  
   
   $i = 0;                  
   /*** execute the prepared statement ***/
   $stmt->execute();
   $count = $stmt -> rowCount();
   
   while ($row = $stmt->fetch(PDO::FETCH_NUM)) {

      $qname[$i] = $row[0];
      $qinstruction[$i] = $row[1];
      $qtext[$i] = $row[2];
      $qseqno[$i] = $row[3];
      $qcount[$i] = $row[4];
      $q01value[$i] = $row[5];
      $q02value[$i] = $row[6];              
      $q03value[$i] = $row[7];
      $q04value[$i] = $row[8];
      $q05value[$i] = $row[9];
      $q06value[$i] = $row[10];
      $q07value[$i] = $row[11];              
      $q08value[$i] = $row[12];
      $q09value[$i] = $row[13];
      $q10value[$i] = $row[14];      
      $q01label[$i] = $row[15];
      $q02label[$i] = $row[16];              
      $q03label[$i] = $row[17];
      $q04label[$i] = $row[18];
      $q05label[$i] = $row[19];
      $q06label[$i] = $row[20];
      $q07label[$i] = $row[21];
      $q08label[$i] = $row[22];
      $q09label[$i] = $row[23];
      $q10label[$i] = $row[24];
      $qtotalcount[$i] = $row[25];
      $polldesc[$i] = $row[26];
      $pollname[$i] = $row[27];
      $userpollname = $row[27];
      
      if ( isset($higherordergoal) ) { if ( strlen($higherordergoal) > 0 ) { $polldesc[$i] = $higherordergoal; } }      
      if ( isset($lowerordergoal) ) { if ( strlen($lowerordergoal) > 0 ) { $qtext[$i] = $lowerordergoal; } }
   
      if ( isset( $qlabel[0]) ) { $q01label[$i] = $qlabel[0]; }
      if ( isset( $qlabel[1]) ) { $q02label[$i] = $qlabel[1]; }
      if ( isset( $qlabel[2]) ) { $q03label[$i] = $qlabel[2]; }
      if ( isset( $qlabel[3]) ) { $q04label[$i] = $qlabel[3]; }
      if ( isset( $qlabel[4]) ) { $q05label[$i] = $qlabel[4]; }
              
      $pollqJSON[$i] = " {";
      $pollqJSON[$i] = $pollqJSON[$i].'"qname" : "'.$qname[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"qinstruction" : "'.$qinstruction[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"qtext" : "'.$qtext[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"qseqno" : "'.$qseqno[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"qcount" : "'.$qcount[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q01value" : "'.$q01value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q01label" : "'.$q01label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q02value" : "'.$q02value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q02label" : "'.$q02label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q03value" : "'.$q03value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q03label" : "'.$q03label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q04value" : "'.$q04value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q04label" : "'.$q04label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q05value" : "'.$q05value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q05label" : "'.$q05label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q06value" : "'.$q06value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q06label" : "'.$q06label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q07value" : "'.$q07value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q07label" : "'.$q07label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q08value" : "'.$q08value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q09label" : "'.$q08label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q09value" : "'.$q09value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q09label" : "'.$q09label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q10value" : "'.$q10value[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"q10label" : "'.$q10label[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"qtotalcount" : "'.$qtotalcount[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"polldesc" : "'.$polldesc[$i].'", ';
      $pollqJSON[$i] = $pollqJSON[$i].'"pollname" : "'.$pollname[$i].'"  ';
      $pollqJSON[$i] = $pollqJSON[$i]." }"; 
      
      $i = $i + 1;
   }

   if ( $count < 1 ) {
      $_SESSION['message'] = 'This poll has not been configured.';
      header("Location: error.php");
   }

   $obsname = $userpollname;
   include("include/getlastobsdate.php");
                                                           
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
      <script src="js/nudge.js"></script>
      
      <script> var qidx = 0; </script>
   </head>
   <body>



<!-- Begin: GasQ Page -->
<div id="pageGasQ" data-role="page" data-cache="never">
<section >

   <script> writeHeader("backgaslow", "home"); </script>
     
   <div class="content" data-role="content">
   
      <form id="pollq" action="pollq_submit.php" method="get"  rel="external" data-ajax="false"> 
         <div data-role="fieldcontain">
                     
            <fieldset data-role="controlgroup">
               <legend style="font-weight:bold;" class="legend" id="legend" name="legend"></legend>

               <var style="text-align:left;" class="question" id="question" name="question"></var>
               <br/>
               <var style="font-size:11px;font-style:normal;" class="lastupdate" id="lastupdate" name="lastupdate"></var>

               <div data-role="fieldcontain">
                  <label for="polldate">Date:</label>
                  <input required type="date" name="polldate" id="polldate" value=<?php echo date('Y-m-d'); ?> style="text-align:center;" />
               </div>

               <div data-role="fieldcontain">
                  <label for="polltime">Time:</label>
                  <input required type="time" name="polltime" id="polltime" value=<?php putenv("TZ=Australia/Sydney"); echo date('H:i'); ?> style="text-align:center;" />
               </div>
                
               <div data-role="fieldcontain">              
                  <label for="q01">Response:</label>
                  <fieldset data-role="controlgroup" data-mini="true">
                     <label class="optlabel1" data-inline="true" for="q011" id="optlabel1"> optlabel1 </label>  
                     <input type="radio" name="q01" id="q011" value="0" checked="checked" />
                     <label class="optlabel2" data-inline="true" for="q012" id="optlabel2"> optlabel2 </label>  
                     <input type="radio" name="q01" id="q012" value="1" />
                     <label class="optlabel3" data-inline="true" for="q013" id="optlabel3"> optlabel3 </label>  
                     <input type="radio" name="q01" id="q013" value="2" />
                     <label class="optlabel4" data-inline="true" for="q014" id="optlabel4"> optlabel4 </label>  
                     <input type="radio" name="q01" id="q014" value="3" />
                     <label class="optlabel5" data-inline="true" for="q015" id="optlabel5"> optlabel5 </label>  
                     <input type="radio" name="q01" id="q015" value="4" />                    
                  </fieldset>                 
               </div>

            </fieldset>
 
            <center>
               <input type="button" id="next" name="next" class="next" value="Submit" data-inline="true">
            </center>
                     
         </div>
      </form>
      
   </div>
   
   <script> writeFooter(); </script>

</section>
</div>
<!-- End: GasQ Page -->

</body>

<script>

var pollq = eval( <?php echo json_encode($pollqJSON); ?> );
if ( pollq != null && pollq.length > 0) {
   for (var i = 0; i < pollq.length; i++) {
      pollqJSON[i] = eval( "(" + pollq[i] + ")" );
//      alert(JSON.stringify(pollqJSON[i]));
   }
} else {
   window.location.href = "error.php";
}

$('#GasQList li').click(function() {
}); 

$( document ).on( "pageinit", "#pageGasQ", function( event ) {
   qidx = 0;
//   window.localStorage.setItem("qidx", 0);
   responseJSON = "";
});

$('#next').click(function() {
      
   var optvaluelist = document.getElementsByName("q01");
   for (var j = 0; j < 5; j++) {              
      if (optvaluelist[j].checked) {
         optvalue = optvaluelist[j].value;
         break;
      }
   }
   
   polltime = document.getElementById('polltime').value;
   polldate = document.getElementById('polldate').value;
   polldatetime = polldate + ' ' + polltime + ':00';

   qtotalcount = pollqJSON[qidx].qtotalcount;
   polldesc = '"' + pollqJSON[qidx].polldesc + ' ' + pollqJSON[qidx].qtext + '"';
   pollname = '"' + pollqJSON[qidx].pollname + '"';
   polldate = '"' + polldatetime + '"';
   
   responseJSON += "\"q01value\" : " + optvalue;
      
   var programid = <?php echo $_SESSION['programid']; ?>;
   var userid = <?php echo $_SESSION['userid']; ?>;
   var pollid = <?php echo $pollid; ?>;
   var header = "";
      
   header += "\"programid\" :" + programid + ", ";
   header += "\"userid\" : " + userid + ", ";
   header += "\"pollid\" : " + pollid + ", ";
   header += "\"polldesc\" : " + polldesc + ", ";
   header += "\"pollname\" : " + pollname + ", ";
   header += "\"lastqseqno\" : " + qtotalcount + ", ";
   header += "\"qcount\" : " + qtotalcount + ", ";
   header += "\"polldate\" : " + polldate + ", ";
                    
   responseJSON = header + responseJSON;
   responseJSON = "{ " + responseJSON + " }";
   responseJSON = eval( "(" + responseJSON + ")" );

   responseJSON = JSON.stringify(responseJSON);
      
   url = "programpolluser_submit.php?responseJSON=" + responseJSON 
   window.location.href = url;
      
   return true;
});

$( '#popupPollQ' ).on( 'popupbeforeposition',function(event){
});

$( '#pageGasQ' ).on('pagebeforeshow', function(event) {   
   
   if ( pollqJSON == null ) {
      window.location.href = "error.php";
      return false;   
   }

//   qidx = parseInt(window.localStorage.getItem("qidx"));

   qidx = 0;
   var legend = pollqJSON[qidx].polldesc;
   var qtext = pollqJSON[qidx].qtext;
   var lastupdate = "Last updated: " + "<?php echo $lastpolldate; ?>";

   $('.lastupdate').empty();   
   $('.lastupdate').append(lastupdate);   
   
   $('.legend').empty();   
   if ( legend != null) {
      $('.legend').append(legend);   
   }
   
   $('.question').empty();   
   if ( qtext != null) {
      $('.question').append(qtext);  
   }
   
   optlabel1 = pollqJSON[qidx].q01label;
   optlabel2 = pollqJSON[qidx].q02label;
   optlabel3 = pollqJSON[qidx].q03label;
   optlabel4 = pollqJSON[qidx].q04label;
   optlabel5 = pollqJSON[qidx].q05label;

   document.getElementById("q011").value = pollqJSON[qidx].q01value;
   document.getElementById("q012").value = pollqJSON[qidx].q02value;
   document.getElementById("q013").value = pollqJSON[qidx].q03value;
   document.getElementById("q014").value = pollqJSON[qidx].q04value;
   document.getElementById("q015").value = pollqJSON[qidx].q05value;
   
   $(".optlabel1").empty();
   if ( optlabel1 != null ) { $(".optlabel1").text(optlabel1); }
   $(".optlabel2").empty();
   if ( optlabel2 != null ) { $(".optlabel2").text(optlabel2); }
   $(".optlabel3").empty();
   if ( optlabel3 != null ) { $(".optlabel3").text(optlabel3); }
   $(".optlabel4").empty();
   if ( optlabel4 != null ) { $(".optlabel4").text(optlabel4); }
   $(".optlabel5").empty();
   if ( optlabel5 != null ) { $(".optlabel5").text(optlabel5); }

});

</script>

</html>

