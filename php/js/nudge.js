

var obstypeJSON = new Array();
obstypeJSON[0] = {
   "name" : "activity",
   "metric" : "Number of steps"
};
obstypeJSON[1] = {
   "name" : "meditation",
   "metric" : "Minutes of meditation"
};
obstypeJSON[2] = {
   "name" : "yoga",
   "metric" : "Minutes of yoga"
};
obstypeJSON[3] = {
   "name" : "running",
   "metric" : "Minutes of running"
};
obstypeJSON[4] = {
   "name" : "poll",
   "metric" : "Completed poll"
};
obstypeJSON[5] = {
   "name" : "other",
   "metric" : "Other, please specify"
};

// Program global attributes section
// Add new JSON for each program

var programJSON = new Array();

programJSON[0] = {
   "programid" : 1,
   "name" : "fitbit",
   "desc" : "Fitbit Activity Monitoring",
   "isdefault" : 1,
   "linkcount" : 2,
   "dataentrycount" : 2,
   "toolcount" : 2,
   "extrascount" : 1,   
   "extrasitem" : [ 
         {"href" : "TheMatrix.php", "name" : "The Matrix"}, 
      ],
   "chartcount" : 3,
   "chartusercount" : 1,
   "chartgroupcount" : 0,
   "chartprogramcount" : 0,
};

programJSON[1] = {
   "programid" : 2,
   "name" : "study1",
   "desc" : "MLWW Study1 Program",
   "isdefault" : 0,
   "linkcount" : 7,
   "dataentrycount" : 2,
   "toolcount" : 2,
   "extrascount" : 2,
   "extrasitem" : [ 
   		{"href" : "#pageWordCloud", "name" : "World Cloud"}, 
   		{"href" : "#pageRandomPhrase", "name" : "Random Phrase"}, 
         {"href" : "TheMatrix.php", "name" : "The Matrix"}, 
   	],
   "chartcount" : 3,
   "chartusercount" : 11,
   "chartgroupcount" : 4,
   "chartprogramcount" : 11,
};

programJSON[2] = {
   "programid" : 3,
   "name" : "study2",
   "desc" : "MLWW Study2 Program",
   "isdefault" : 0,
   "linkcount" : 0,
   "dataentrycount" : 2,
   "toolcount" : 1,
   "extrascount" : 0,   
   "chartcount" : 3,
   "chartusercount" : 0,
   "chartgroupcount" : 0,
   "chartprogramcount" : 0,
};

programJSON[3] = {
   "programid" : 4,
   "name" : "mbsr",
   "desc" : "Mindfulness Based Stress Reduction",
   "isdefault" : 0,
   "linkcount" : 0,
   "dataentrycount" : 2,
   "toolcount" : 2,
   "extrascount" : 0,   
   "chartcount" : 3,
   "chartusercount" : 0,
   "chartgroupcount" : 0,
   "chartprogramcount" : 0,
};

programJSON[4] = {
   "programid" : 5,
   "name" : "lifecoach",
   "desc" : "The Coach in your Pocket",
   "isdefault" : 0,
   "linkcount" : 0,
   "dataentrycount" : 2,
   "toolcount" : 2,
   "extrascount" : 1,
   "extrasitem" : [ 
         {"href" : "TheMatrix.php", "name" : "The Matrix"}, 
      ],   
   "chartcount" : 3,
   "chartusercount" : 0,
   "chartgroupcount" : 0,
   "chartprogramcount" : 0,
};

var user = {
   "msgunreadcount": 0,
   "ruleoptincount" : 0,
   "chartcount" : 0,
   "pollcount" : 0,
   "linkcount" : 0,   
   "usercount" : 0
};

// Find or set program
var programidx = 0;
var programname = localStorage.getItem("programname");
if ( programname.length > 0) {
   for (var i=0 ; i < programJSON.length; i++) {
      if (programJSON[i].name == programname) { programidx = i; }
   }
} else {
   for (var i=0 ; i < programJSON.length; i++) {
      if (programJSON[i].isdefault == 1) { programidx = i; }
   }
}
      
var program = programJSON[ programidx ];

var pollqJSON = new Array();

function writeFooter() {
   
   username = "Anonymous";
   if ( localStorage.getItem("username") != null ) {
      if ( localStorage.getItem("username").length > 0 ) {
         username = localStorage.getItem("username");
      }
   }
   pointcount = 0;
   if ( localStorage.getItem("pointcoint") != null ) {
      pointcount = localStorage.getItem("pointcoint");
   }

   document.write('<footer style=\"background:url(\'images/strip.png\'); no-repeat;\" data-role=\"footer\" data-position=\"fixed\">');
   document.write('<var class=verysmallparagraph style=\"vertical-align:middle;text-align:left\">');
   document.write('&nbsp &nbsp <a data-ajax=\"false\" href=\"refresh_submit.php\"' + 
      ' data-role="button" data-icon=\"refresh\" data-iconpos=\"notext\" data-mini=\"true\"></a>');
   document.write('  <var style=\"font-size:9px;font-style:normal;font-weight:200;margin-left:10px;">Login: ' + 
      username + ' ' + pointcount + ' Points </var>');   
   document.write('&nbsp &nbsp &copy; <a href=\"mailto:StefanoPicozzi.gmail.com\">StefanoPicozzi@gmail.com</a>&nbsp ');        
//      document.write(' &nbsp <img style=\"width: 20px; height: 20px;\" alt=\"Flying Cockateil\" src=\"images/cockateil.png\"> &nbsp  &nbsp  &nbsp  &nbsp  &nbsp &nbsp  &nbsp  &nbsp ');
   document.write('  </var>');
   document.write('</footer>');
}

function writeHeader (left, right) {

   var leftlink = "settings.php";
   var lefticon = "gear";
   var rightlink = "index.php";
   var righticon = "home";
   
   if (left == "home")         { leftlink = "index.php";                     lefticon = "home";  }
   if (left == "info")         { leftlink = "help.php";                      lefticon = "info";  }
   if (left == "backhome")     { leftlink = "index.php";                     lefticon = "back";  }
   if (left == "backsettings") { leftlink = "settings.php";                  lefticon = "back";  }
   if (left == "backextras")   { leftlink = "#pageExtras";                   lefticon = "back";  } 
   if (left == "backdata")     { leftlink = "index.php#pageDataEntry";       lefticon = "back";  } 
   if (left == "backdiary")    { leftlink = "#pageUserDiary";                lefticon = "back";  } 
   if (left == "backobs")      { leftlink = "#pageUserObs";                  lefticon = "back";  }  
   if (left == "backrule")     { leftlink = "rulesettings.php";              lefticon = "back";  }    
   if (left == "backuser")     { leftlink = "programuser.php?roletype=participant"; lefticon = "back";  }   
   if (left == "backruleuser") { leftlink = "programruleuser.php?ruletype=user"; lefticon = "back";  }   
   if (left == "backlink")     { leftlink = "programurl.php?urltype=link";   lefticon = "back";  }   
   if (left == "backhelp")     { leftlink = "help.php";   lefticon = "back";  }   
   if (left == "backgaslow")   { leftlink = "goal.php?ruletype=gaslow";   lefticon = "back";  }   
   if (left == "backrulegas")  { leftlink = "programruleuser.php?ruletype=gas";   lefticon = "back";  }   

   if (right == "home")        { rightlink = "index.php";                    righticon = "home"; }   
   if (right == "settings")    { rightlink = "settings.php";                 righticon = "gear"; }
   if (right == "insertdiary") { rightlink = "#pageInsertUserDiary";         righticon = "plus"; }
   if (right == "insertobs")   { rightlink = "#pageInsertUserObs";           righticon = "plus"; }
   if (right == "insertrule")  { rightlink = "#pageInsertRule";              righticon = "plus"; }         
   if (right == "insertnudge") { rightlink = "#pageInsertNudgeAll";          righticon = "plus"; }         
   if (right == "matrixcheck") { rightlink = "#matrixcheck";                 righticon = "check"; }         
   if (right == "msgs")        { rightlink = "msg.php";                      righticon = "grid"; }         
   if (right == "accountinfo") { rightlink = "help.php#pageAccount";         righticon = "info"; }         
   
   document.write('<header style=\"background:url(\'images/strip.png\'); no-repeat;\" data-role=\"header\" data-position=\"inline\">');
   document.write('  <a data-ajax=\"false\" href=\"' + leftlink + '\" data-ajax="false" data-role="button" data-icon=\"' + lefticon + '\" data-iconpos=\"notext\">Help</a>');
   document.write('  <p class=smallparagraph style=\"text-align:center; font-weight:bold; font-style:italic;\">');
   document.write('  The Nudge Machine &nbsp <img style=\"width: 20px; height: 20px;\" alt=\"Flying Cockateil\" src=\"images/cockateil.png\"> </p> ');
   document.write('  <a id=\"' + right + '\" data-ajax=\"false\" href=\"' + rightlink + '\" data-transition=\"flip\" data-role=\"button\" data-icon=\"' + righticon + '\" data-iconpos=\"notext\" data-ajax=\"false\" class=\"ui-btn-right\">Settings</a>');
   document.write('</header>');
   document.write(' <var class=verysmallparagraph style=\"text-align:left;font-size:11px;font-style:normal;margin-left:10px;"> A behavioral insight platform for coaches and coachees. </var>');   

}

