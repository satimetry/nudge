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
      <section data-theme="a" id="pageNudgeAPI" data-role="page" data-fullscreen="false">

         <script> writeHeader("backhome", "settings"); </script>

         <div data-role="content">
            <div class="content-primary" id="ruleOptions">
 
      <form name="getfact" id="getfact" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/user" method="get">
         <div data-role="fieldcontain">
            
            <fieldset data-role="controlgroup">
               <legend>User Fact Get Example</legend>
               <div data-role="fieldcontain">
                  <label for="programid"> Program ID: </label>
                  <input type="text" class="programid" name="programid" id="programid" required autofocus value=1 />
               </div>
               <div data-role="fieldcontain">
                  <label for="groupid"> Group ID: </label>
                  <input type="text" name="groupid" id="groupid" required value=7 />
               </div>
               <div data-role="fieldcontain">
                  <label for="factname"> Fact Name: </label>
                  <input type="text" name="factname" id="factname" required value="activity" />
               </div>
            </fieldset>
            
            <center>
               <input type="submit" id="get" value="Get" data-inline="true"/>
            </center>
            
         </div>
      </form>

   <form name="donudge" id="donudge" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/nudge" method="get">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>Do Nudge Example</legend>
            <div data-role="fieldcontain">
               <label for="programid">  Program ID: </label>
               <input type="text" name="programid" id="programid" required autofocus value=1 />
            </div>
            <div data-role="fieldcontain">            
               <label for="groupid"> Group ID: </label>
               <input type="text" name="groupid" id="groupid" required value=7 />
            </div>
            <div data-role="fieldcontain">
               <label for="factname"> Fact Name: </label>
               <input type="text" name="factname" id="factname" required value="activity" />
            </div>
            <div data-role="fieldcontain">            
               <label for="rulename"> Rule Name: </label>
               <input type="text" name="rulename" id="rulename" required value="activity" />
            </div>
         </fieldset>
        
        <center>
         <input type="submit" id="get" value="Nudge" data-inline="true"/>
        </center>

   </form>   
      
   <form name="getfact" id="getfact" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/system" method="get">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>System Fact Get Example</legend>
            <div data-role="fieldcontain">
               <label for="programid">  Program ID: </label>
               <input type="text" name="programid" id="programid" required autofocus value=1 />
            </div>
            <div data-role="fieldcontain">            
               <label for="groupid"> Group ID: </label>
               <input type="text" name="groupid" id="groupid" required value=7 />
            </div>
            <div data-role="fieldcontain">
               <label for="factname"> Fact Name: </label>
               <input type="text" name="factname" id="factname" required value="activity" />
            </div>
         </fieldset>
        
        <center>
         <input type="submit" id="get" value="Get" data-inline="true"/>
        </center>

   </form>   

   <form name="createfact" id="createfact" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact" method="post">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>Fact Post Example</legend>
            <div data-role="fieldcontain">     
               <label for="id"> Program ID: </label>
               <input type="text" name="programid" id="programid" required autofocus value=1 />
            </div>
            <div data-role="fieldcontain">
               <label for="groupid"> Group ID: </label>
               <input type="text" name="groupid" id="groupid" required value=7 />
            </div>
            <div data-role="fieldcontain">
               <label for="factname"> Fact Name: </label>
               <input type="text" name="factname" id="factname" required value="activity" />
            </div>
            <div data-role="fieldcontain">
               <label for="factjson"> Fact JSON: </label>
               <input type="text" name="factjson" id="factjson"  
                 value="{ username: 'stefano' , obsname: 'activity' , obsdate: '2014-01-01' , obsvalue: 10001 , obsdesc: 'System generated from fitbit.com step-count download' }" 
                 required/>
            </div>
     </fieldset>
      
      <center>
         <input type="submit" id="create" value="Create" data-inline="true"/>
      </center>
      
   </form>

   <form name="deletefacts" id="deletefacts" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/del" method="GET">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>Fact Delete All Example</legend>
            <div data-role="fieldcontain">     
               <label for="id"> Program ID: </label>
               <input type="text" name="programid" id="programid" required autofocus value=1 />
            </div>
            <div data-role="fieldcontain">
               <label for="groupid"> Group ID: </label>
               <input type="text" name="groupid" id="groupid" required value=7 />
            </div>
            <div data-role="fieldcontain">
               <label for="factname"> Fact Name: </label>
               <input type="text" name="factname" id="factname" required value="activity" />
            </div>
      </fieldset>
      
      <center>
         <input type="submit" id="create" value="Delete" data-inline="true"/>
      </center>

   </form>   
      
   <form name="deletefact" id="deletefact" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/fact/del" method="POST">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>Fact Delete Example</legend>
            <div data-role="fieldcontain">         
               <label for="id"> Fact ID: </label>
               <input type="text" name="id" id="id" required autofocus value="1" />
             </div>
      </fieldset>
      
      <center>
         <input type="submit" id="create" value="Delete" data-inline="true"/>
      </center>

   </form>              
   
   <form name="createrule" id="createrule" action="http://nudgeserver-spicozzi.rhcloud.com/tnm/rest/rule" method="post">
      <div data-role="fieldcontain">
         <fieldset data-role="controlgroup">
            <legend>Rule File Post Example</legend>
            <div data-role="fieldcontain">
               <label for="programid"> Program ID: </label>
               <input type="text" name="programid" id="programid" required autofocus value=1 />
            </div>
            <div data-role="fieldcontain">  
               <label for="groupid">  Group ID: </label>
               <input type="text" name="groupid" id="groupid" required value=7 />
            </div>
            <div data-role="fieldcontain">  
               <label for="rulenameid">  Rule Name: </label>
               <input type="text" name="rulename" id="rulename" required value="activity" />
            </div>
            <div data-role="fieldcontain">  
               <label for="ruletxt">  Rule Text: </label>
               <textarea cols=60 rows=20 name="ruletxt" id="ruletxt" required >

import java.util.HashMap;
import org.json.JSONObject;
import java.util.Date; 
import java.text.SimpleDateFormat; 
import com.satimetry.nudge.Output;

global java.util.HashMap output;
global SimpleDateFormat inSDF;
global SimpleDateFormat outSDF;

function void print(String txt) {
   System.out.println(txt);
}

// Declare inside drl so we can manipulate objects naturally
declare Participant
  @role( fact )
  id : String @key
  dayofweek : String
end

// Declare inside drl so we can manipulate objects naturally
declare Activity
  @role( event )
  @timestamp ( stepDate )
  id : String @key
  stepDate : Date @key
  stepCount : Integer
end

declare UserRule
  @role( fact )
  id : String @key
  ruleName : String @key
end

rule "rulePrintJSON"
   salience 2000
   when
      $input : JSONObject() from entry-point DEFAULT
   then
      System.out.println($input.toString());
      System.out.println($input.get("obsdate"));
end

rule "ruleInsertActivity"
  salience 2000
  when
    $input : JSONObject() from entry-point DEFAULT 
  then
    inSDF = new SimpleDateFormat("yyyy-M-d");
    Date date = inSDF.parse( $input.get("obsdate").toString() );
    Activity activity = new Activity($input.get("username").toString(), date);
    activity.setStepCount( Integer.parseInt($input.get("obsvalue").toString()) );
    insert(activity);
    print(drools.getRule().getName() + "->" + activity.getId() + "-" + activity.getStepDate() + "-" + activity.getStepCount() );
end

rule "ruleInsertParticipant"
  salience 1000
  when
    $input : JSONObject() from entry-point DEFAULT 
    not Participant( id == $input.get("username").toString() )
  then
    Date today = new Date();
    String dayofweek = new SimpleDateFormat("EE").format(today);
    Participant $participant = new Participant( $input.get("username").toString() );
    $participant.setDayofweek(dayofweek);
    insert( $participant );
    print(drools.getRule().getName() + "->" + $participant.getId() );
end

rule "ruleHighStepCount"
  salience -1000
  no-loop true
  when
     $participant : Participant()
     $stepCountTotal : Number( intValue > 0) from accumulate(
      Activity( $stepCount : stepCount >= 10000, $participant.id == id ) over window:time( 30d ),
          count( $stepCount ) )
  then
      Date today = new Date(); 
      JSONObject joutput = new JSONObject();
      joutput.put("id", $participant.getId());
      joutput.put("rulename", drools.getRule().getName());
      joutput.put("ruledate", today); 
      joutput.put("rulemsg", "Nudge says that you exceeded 10,000 steps " + $stepCountTotal + " times in the past 30 days");
      joutput.put("ruledata", $stepCountTotal);
      Output $output = new Output(joutput.toString());
      insert($output);
      print(drools.getRule().getName() + "->" + $stepCountTotal);
end

rule "ruleAverageStepCount"
  salience -1000
  no-loop true
  when
     $participant : Participant()
     $stepCountAverage : Number( intValue > 0) from accumulate(
      Activity( $stepCount : stepCount > 0, $participant.id == id ) over window:time( 7d ),
          average( $stepCount ) )
  then
      Date today = new Date(); 
      JSONObject joutput = new JSONObject();
      joutput.put("id", $participant.getId());
      joutput.put("rulename", drools.getRule().getName());
      joutput.put("ruledate", today);      
      joutput.put("rulemsg", "Nudge says that you averaged " + 
         String.format("%.2f", $stepCountAverage) + 
         " steps per day over the last 7 days");
      joutput.put("ruledata", $stepCountAverage);
      Output $output = new Output(joutput.toString());
      insert($output);
      print(drools.getRule().getName() + "--->" + $stepCountAverage + "-" + joutput.get("ruledate") );
end


            </textarea>
         </div>
      </fieldset>
      
      <center>         
         <input type="submit" id="create" value="Create" data-inline="true"/>
      </center>
      
   </form>
       

 
      </br>   
      <a href=rest/rule/0 >Rule 0</a>
      <a href=rest/rule/1 >Rule 1</a>
      <a href=rest/rule/2 >Rule 2</a>
      <a href=rest/rule/3 >Rule 3</a>
      </br>
      <a href=rest/fact/0 >Fact 0</a>
      <a href=rest/fact/1 >Fact 1</a>
      <a href=rest/fact/2 >Fact 2</a>
      <a href=rest/fact/3 >Fact 3</a>
         
   </div>
   
   <script> writeFooter(); </script>

</section>
<!-- End: NudgeAPI Page -->

   </body>
</html>

          