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
 
<!-- Begin: Help page -->
<div data-theme="a" id="pageHelp" data-role="page" data-fullscreen="false" ><section>
   
   <script> writeHeader("home", "settings")</script>

   <div data-role="content">
      <div class="content-primary" id="Settings">
         <ul data-role="listview"  id="SettingsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> <h4>Help Menu </h4> </li>
            <li> <a href="#pageAbout">About</a> </li>
            <li> <a href="#pageDocs" >Docs<span class="ui-li-count"> 3 </span></a> </li>
            <li> <a href="#pageFAQ">FAQ</a> </li>
            <li> <a href="#pageIntro">Example</a> </li>
            <li> <a href="#pageDemo">Demonstration</a> </li>
            <li> <a href="#pageStoryBoard">Story Board </a> </li>
            <li> <a href="#pageGlossary">Glossary </a> </li>
            <li> <a href="#pageAccount">Integration </a> </li>
         </ul>
      </div>
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Help section -->

<!-- Begin: Docs page -->
<div data-theme="a" id="pageDocs" data-role="page" data-fullscreen="false" ><section>
   
   <script> writeHeader("backhelp", "home")</script>

   <div data-role="content">
      <div class="content-primary" id="Settings">
         <ul data-role="listview"  id="SettingsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> <h4>Docs </h4> </li>
            <li> <a href="docs/Coachee-GettingStartedGuide.pdf" download="Coachee-GettingStartedGuide.pdf" data-ajax="false" >Coachee</a> </li>
            <li> <a href="docs/Coach-GettingStartedGuide.pdf" download="Coach-GettingStartedGuide.pdf" data-ajax="false" >Coach</a> </li>
            <li> <a href="docs/TheNudgeMachine.pdf" download="TheNudgeMachine.pdf" data-ajax="false" >Presentation</a> </li>
         </ul>
      </div>
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Docs section -->

<!-- Begin: Glossary page -->
<div data-theme="a" id="pageGlossary" data-role="page" data-fullscreen="false" ><section>
   
   <script> writeHeader("backhelp", "home")</script>

   <div data-role="content">
      <div class="content-primary" id="Settings">
         <ul data-role="listview"  id="SettingsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider"> <h4>Glossary </h4> </li>
            <li> <a href="#pageTerms">System Terminology </a> </li>
            <li> <a href="#pageABA">Applied Behavioral Analysis </a> </li>
            <li> <a href="#pageGAS">Goal Attainment Scaling </a> </li>
            <li> <a href="#pageBehavEco">Behavioral Economics </a> </li>
         </ul>
      </div>
   </div>
   
   <script> writeFooter(); </script>

</section></div>
<!-- End: Glossary section -->


<!-- Begin: About Page -->
<div data-theme="a" id="pageAbout" data-role="page"><section>

   <script>writeHeader("backhelp", "home")</script>

   <div class="content" data-role="content">
      <h3>About</h3>
 
<div style="color:white;"> 
<p>
The Nudge Machine is a behavioral insight platform for coaches and coachees.
It provides an instrumentation and measurement framework for behavioral interventions 
enabling coachees to longitudinally track progress and coaches to tailor instruction.
The system integrates both persuasive content to engage coachees with analytic capalities to inform coaches.
</p>
<p>
At its core is a rules based event stream engine by which coaches can discover and test behavioral hypotheses.
Such insight can then be actioned to nudge coachees toward goal directed desirable behavioral outcomes.
The system's behavior is itself controlled via rules permitting coachees to opt out of discrete elements as they wish.
</p>
<p>
Its architecture can scale up to large-scale population wide interventions and scale down to programs consisting of just a few participants. 
The engine can drive interventions of a fixed, scheduled format or those using signal contingent momentary assessments.
Instrumentation includes support for an on-board polling mechanism and integration to external survey providers and
wearable sensor technologies. The measurement framework can be configured to support gamification strategies.
</p>
<p>
The Nudge Machine connects coaches and coachees to support their goals both inside the classroom and in 
the context of their daily lives.
</p>
</div>

   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: About Page -->

<!-- Begin: Account Page -->
<div data-theme="a" id="pageAccount" data-role="page"><section>

   <script>writeHeader("backhelp", "home")</script>

   <div class="content" data-role="content" >
      <h3>Integration</h3>

<div style="color:white;"> 
<p>
The Nudge Machine can integrate with various third party wearable sensor and notification technologies.
Two such examples are pushover.net and Fitbit. Pushover.net is a smartphone notification application that
enables Nudge to send messages to your phone. Fitbit is a provider of wearable activity monitors which can send
activity data back to a central website base station. Integrating to such systems requires the individual user to download,
install and/or register and authenticate to these respective external systems. Once successful, these systems return back
a key which can be recorded inside Nudge, thereby enabling the Nudge system to pull down or send information to/from
these systems. Relevant third party attributes are recorded in the Account menu.
</p>

<h4>pushover.net</h4>

<p>
pushover.net runs on iPhone or Android devices. It can be downloaded to your phone via the relevant app store for a small fee.
Once you have installed the app, register/login to the https://pushover.net website.
On the top right hand corner of this page you will see your user key. Copy/paste this key and record it
in the pushover.net user: field in the Account details section.
Once saved, Nudge will be able to send notifications to the pushover.net app installed on your phone.
You can then manage and access the messages using the capabilities of the pushover.net app.
Incidentally, you can also inspect and copy-paste the pushover.net user key from the configuration menu of the app.
</p>

<h4>Fitbit</h4>
Integration to Fitbit requires registering an app which unfortunately takes a few steps but once completed
Nudge will be able to pull down your activity data and track and chart progress reports. 
To do this login to the developer website at http://dev.fit.com . Click the Register an App tab and enter the following:
</p>

Application Name: TheNudgeMachine <br/>
Description: The Nudge Machine integration application <br/>
Application Website: http://www.thenudgemachine.com <br/>
Organization: emergitect.com <br/>
Organization Webiste: http://www.emergitect.com <br/>
Application Type: Browser <br/>
Callback URL: http://www.thenudgemachine.com <br/>
Default Access Type: Read & Write <br/>

<p>
Upon pressing save, Fitbit will respond back with a Fitbit key and Fitbit secret.
Now return to the Account menu and enter the following:
</p>

Fitbit key: the fitbit user key returned above <br/>
Fitbit secter: the fitbit secret return above <br/>
Fitbit appname: the Application Name you entered above <br/>

<p>
</p>
</div>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: Account Page -->

<!-- Begin: Intro Page -->
<div data-theme="a" id="pageIntro" data-role="page" ><section>

   <script>writeHeader("backhelp", "home")</script>

   <div class="content" data-role="content" >
      <h3>Examples</h3>
<div style="color:white;">  
      <p>
Examples of such interventions include Mindfulness Based Stress Reduction (MBSR) or those based on Acceptance and Commitment therapy (ACT).

The commonality amongst such programs is that they consist of a facilitated, structured and scheduled agenda over a set time period attended
by a group of participants. 

<p>
In Nudge terminology, the facilitator is known as the <b>Change Architect</b>, 
the intervention as a <b>program</b> and attendees as <b>participants</b> organised as a <b>group</b>.  

Research shows that in evidence based progroms such as MBSR and ACT, there is a practice effect. 
The more engaged participants are in adhering to program requirements, the better the outcomes. 
Examples of such engagement include course attendance, attention to content and practice such as mindful meditation.
</p>

The benefits of The Nudge Machine include encouraging adherance to program requirements by sending reminder notifications
and the recording and tracking of performance against course goals. These are all known as <i><b>nudges</b></i>. 
Nudges are configurable, customizable and optional such that any event associated with the program can be used as the 
source of a nudge. Participants can opt-in or opt-out of any nudge. The nudge signalling method is also configurable
and can include a message posted to the website (default), a notification issued via Pushover.net, email and SMS.

<p>
For example, in an MBSR program a nudge could be associated with a commitment to practice mindful meditation for 10 minutes daily every 3 days out of 5. 
Actual meditation is captured as an observation enabling The Nudge Machine to measure performance against the participants's goals.
Non-adherance to that goal could then trigger a nudge.
</p>

<p>
Nudges can also consist of the delivery of course content. For example if the Change Architect identifies a useful article
of relevance to the program, a nudge pointing to a link to that content can be delivered to participants. 
This feature generalises to the capacity of The Nudge Machine to enable the Change Architect to deliver customised content at any time to any participants.
</p>
      
</div>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: Intro Page -->

<!-- Begin: Demo Page -->
<div data-theme="a" id="pageDemo" data-role="page"><section>

   <script>writeHeader("backhelp", "home")</script>
   
   <div class="content" data-role="content">
      <h3>Demonstration</h3>
      
<div style="color:white;"> 
<p>
A demonstration program known as "fitbit" has ben set up to show the extensibility and usability of the system. 
The purpose of the fitbit program is to encourage greater levels of physical activity. 
</p>

<p>
In this program, goals can take the form of e.g. number of steps per day measured using a fitbit wearable sensor device. 
The participant wears a Fitbit device which tracks step activity. This data is downloaded to the 
central Fitbit website using an automatic blue-tooth based data tranfser system supplied by Fitbit. 
The Nudge Machine pulls down this data on a regular scheduled basis and then apply nudges against these observations. 
A nudge can be of the form, e.g., alert me when my activity levels drop below 2000 steps more than 5 times over the past 10 days. 
</p>

<p>
Note that this demonstration system shows that the minimum requirement for a <i>nudge-able</i> program 
is simply some kind of purpose, a measurable goal associated with that purpose and method of observing and recording 
behaviour against that goal. In addition, nudges can (optionally) be directed to a designated Change Architect (e.g. a wellness coach)
enabling a role for a practitioner to assist the participant in how they engage in this program.
</p>

<p>
To access this content, first assume the role of a participant.  To do this, login as user=stephanie with password=password 
for the "Fitbit Activity Monitoring" program. 
A login for the Change Architect has also been established. To assume this role, login using user=coach with password=password. 
As "coach" check out the Participants page and inspect the user lists and click to issue a nudge. Some adminsitrator role
functions are also accessible, using user=admin, password=password. To get started, click the Home icon at the top right
of this page and then choose Login from the menu list.

</div>      
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: Demo Page -->

<!-- Begin: StoryBoard Page -->
<div data-theme="a" id="pageStoryBoard" data-role="page"><section>

   <script>writeHeader("backhelp", "home")</script>

   <div class="content" data-role="content">
      <h3>Story Board</h3>

      <h4>Spot Poll</h4>
<div style="color:white;"> 
<p>
The spot poll use case showcases a number of Nudge Machine features. To follow an example do the following.
First check that program=fitbit. Then login as coach/password. Visit the Participants page and click participant=stefano.
Nudge this participant and ensure that the nudge message has radio button=poll and pollq.php?pollid=1 in the URL field.
Message text and URL label can be anything you like.
</p>

<p>
Now login as stefano/password and click the Poll page. You should see a entry for the poll you created. Click this entry 
and step through the poll. Now go to the configuration section and choose Rules, then select Program and look for the ruleManual 
entry. Set the option flag to out and save the changes. Now revisit the Poll page and the poll entry will be removed. Reset the
ruleManual option to opt-in and verify the Poll entry reappears. Check also the Nudge page to inspect the Poll nudge message.
</p>

<p>
Now login as stephanie/password. You should note that the Poll nudge and related Poll record do not appear for this participant.
This feature shows how the coach can create a nudge that prompts a specific participant to complete a poll. The participant can
at anytime opt-out of this request.
</p>

      <h4>Rule Management</h4>
<p>
Rules underpin all aspects of The Nudge Machine.  This design principle is repeated throughout the system and
is what makes for a coherent application architecture and user experience. Rules describe actions that the system
can take based on certain conditions, and are implemented separately. For example a program wide rule may be to
remind all participants in the program to complete a daily survey.
</p>

<p>
To create a rule, check that your are in the fitbit program, and then login as admin/password.
Visit the rule <a href="http://www.thenudgemachine.com/rule.php?roletype=administrator">Creation</a> page 
located in the configuration section and create a new rule of type=program by clicking the plus icon. 
You have now created a system wide rule as an <b>Administrator</b>.
</p>

<p>
To assign a rule to a program, check that your are in the fitbit program, and then login as coach/password.
Visit the rule <a href="http://localhost/nudge/php/programrule.php?roletype=architect">Assignment</a> page 
located in the configuration section then click the rule you created previously and accept the prompt. 
As the <b>Change Architect</b> you have now applied that rule to all participants in your program.
</p>

<p>
To inspect the rule, check that your are in the fitbit program, and then login as stefano/password.
Visit the program wide rule <a href="http://localhost/nudge/php/programruleuser.php?ruletype=program">Settings</a> page 
located in the configuration section then click the rule created previously. 
As the <b>Participant</b> you can now choose to opt-out/in of that rule.
</p>
</div>   
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: StoryBoard Page -->

<!-- Begin: GAS Page -->
<div data-theme="a" id="pageGAS" data-role="page"><section>
   
   <script>writeHeader("backhelp", "home")</script>
      
   <div data-role="content">
      <div class="content-primary" id="Terms">
         <ul data-role="listview" data-filter="true" id="TermsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               Goal Attainment Scaling
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
1. Identify overall objective
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Client and coach discuss and agree on the general goal(s) of the program (e.g. improve physical fitness)
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
2. Identify specific problem areas to be addressed
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Requires prioritisation of problem areas (e.g. physical inactivity) and reduction to observable and reportable components 
(e.g. preferred form of exercise, frequency)
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
3. Identify behaviours that would indicate improvement
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Involves outlining the operational detail needed for the scale to be a useful instrument in evaluating performance 
(e.g. defining “exercise” in terms of completed gym sessions)
                     </p>
                  </div>
               </div>
            </li>
                        
            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
4. Determine how goal attainment will be measured
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Decisions made regarding the collection of goal attainment data: Who will collect it? 
In what setting it will be gathered? (e.g. exercise diary completed by client)                     
                     </p>
                  </div>
               </div>
            </li>
            
            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
5. Select “Expected Outcome” level of performance
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
A critical step. Both the client and coach appraise and agree on a level of attainment 
that is both meaningful and realistic for the client given their history and current situation                     
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
6. Identify alternative levels of attainment
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
In addition to the “Expected Outcome”, four other levels of attainment 
are identified in order to quantify greater and lesser levels of performance                    
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
7. Check for overlapping goals and gaps between levels
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Overlapping goals can be used but they must be mutually exclusive and internally consistent. 
Gaps between levels are not permissible and can be addressed by defining a behavioural range for each goal level
                     </p>                  
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h5>
<div  style="white-space:normal;">
8. Ascertain current level of attainment
</div>
                  </h5>
                  <div  style="white-space:normal;"
                     <p>
Discuss past and present goal attainment with the client to determine the GAS level that is “current”. 
A timetable for future evaluations should also be agreed at this point                     </p>                  
                  </div>
               </div>
            </li>
                                    
         </ul>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: GAS Page -->

<!-- Begin: Terms Page -->
<div data-theme="a" id="pageTerms" data-role="page"><section>
   
   <script>writeHeader("backhelp", "home")</script>
      
   <div data-role="content">
      <div class="content-primary" id="Terms">
         <ul data-role="listview" data-filter="true" id="TermsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               Terminology
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Insight
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
The Nudge Machine is a behavioral insight platform because it can provide insight into what Participants are doing through the
course of a behavior intervention and to make this information manageable at scale. For example, rules can be configured that 
can assist the Change Architect make effective triage decisions as to which Participants needs the most help at any time.
A rule could be as selective as e.g. identify which Participants over the last 4 weeks have missed their lower-threshold 
daily goal target more than 8 times. Such insight is then actionable as the Change Architect could then e.g. nudge more
desirable behavior by providing content tailored to these specific Participants. Participants also benefit from the insight
gleened from inspecting their own and group-wide progress charts and other data visualizations made accessible inside the system.
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Nudges
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
A core capability of The Nudge Machine is the issuance of nudges. A nudge is the consequence of the firing of a rule and may 
represent any programmable event. For example, the sending of an SMS message containing certain tailored content to 
a specific Participant.
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Observations
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
The minimum and sufficient requirement to use The Nudge Machine is some observable and measurable behavior, also known as an event,
that is of relevance to some behavorial purpose or goal, e.g. increase activity, smoking cessation etc. 
This could a sensor generated event  such as step activity captured using a wearable sensor or 
the self-report of a behavior of interest, e.g. minutes spent in mindfulness meditation.
The Nudge Machine can be extended to absorb data capture from any sensor with a published API. 
For example, a fitbit connector has already been developed. 
The system includes data entry pages to enable Participants to manually log journal and behavior data.
                     </p>
                  </div>
               </div>
            </li>
                        
            <li>
               <div data-role="collapsible">
                  <h4>
Programs
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
A behavior change intervention is known as a program. The Nudge Machine is multi-tenanted in the sense that it can support many programs.
A new program archtetype is created by the Administrator. A specific program instance is then created from the architype by the Change Architect.
                     </p>
                  </div>
               </div>
            </li>
            
            <li>
               <div data-role="collapsible">
                  <h4>
Roles
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
The system supports three different roles known as Participant, Change Architect and Administrator. Administrators create and 
manage system wide assets such as program archetypes and rules. Change Architects manage a specific instance of a change program.
Participants enrol into a program as managed by the Change Architect.
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Rules
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
The behavior of the Nudge Machine itself is controlled by rules. Rules are of the form if-this-then-that. There are many types
of rules covering system aspects including what surveys are issued, which content is published, how particpants are prompted
and even what goals should be set. Change Architects determined what rules apply to what programs and what the default settings should be.
Participants can opt-in or out of any rule at any time. The machine inside The Nudge Machine consists of a rules engine that
reasons over events (inputs) to then generate new events (outputs). These outputs then become the nudges that the Participant experiences, 
e.g. in an ecological momentary assessment context, this could be a prompt to complete a spot survey.
                     </p>
                  </div>
               </div>
            </li>
                                    
         </ul>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: Terms Page -->
            
            
<!-- Begin: BehavEco Page -->
<div data-theme="a" id="pageBehavEco" data-role="page"><section>
   
   <script>writeHeader("backhelp", "home")</script>
      
   <div data-role="content">
      <div class="content-primary" id="ProgramRuleUser">
         <ul data-role="listview" data-filter="true" id="ProgramRuleUserList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               Behavioral Economics
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Bounded rationality
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
The boundedly rational individual is one who is seeking to do the best that they can for themselves (they are ‘optimising’) but, 
in contrast to the rational individual, the cognitive skills, attention and/or willpower that they bring to the task are limited. 
This is not to say that the world is populated by individuals who are either always rational or always boundedly rational, 
since the same individual may act rationally in one decision-making scenario but be only boundedly rational in another scenario.
                     </p>
                  </div>
               </div>
            </li>
            
            <li>
               <div data-role="collapsible">
                  <h4>
Herd behaviour
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
It has been observed that, when information is imperfect, many people can converge on the same choice of action as a 
result of copying the behaviour of others. Herding is deemed to be non-rational when no particular logic is deployed, 
resulting in the bandwagon effect. But herding can be rational if an individual believes the person or people 
whose behaviour they are copying is/are better informed than they are. See also information cascade below.                     
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Inattention
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This term refers to the tendency of individuals to restrict their attention to a subset of the information or options available
 to them. Note that it can be rational to ignore information: under the assumption that the rational individual will give their 
 attention to information up to the point at which the cost of attention equals the expected benefit of that attention, 
 then some information may be rationally ignored. However, boundedly rational individuals may ignore or fail to give 
 adequate attention to some information, such as the ‘small print’ attached to some transactions, leading them to poor outcomes. 
 For policy-making purposes, it can be important to distinguish between rational inattention and inattention that is the 
 product of bounded rationality.                     
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Information cascade
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This is a form of herd behaviour (see above). It occurs when an individual imitates the choice behaviour of predecessors 
even if the little information the individual already holds points to a different choice.                   
                     </p>
                  </div>
               </div>
            </li>
                                    
            <li>
               <div data-role="collapsible">
                  <h4>
Nudging
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
Nudging refers to a behavioural remedy that is grounded in the observation that biased decision-making 
can lead to outcomes that are not in an individual’s best interests. It involves persuading (rather than telling) 
individuals to change their behaviour through a variety of prompts that change the intuition people bring to bear 
on decision-making. A classic example is the redesign of a refectory – placing fatty foods to the rear of the 
display where they remain available but are more difficult to access – with a view to encouraging healthier eating habits. 
See also weak/soft paternalism below.
                     </p>
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Optimism/pessism bias
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This bias is produced when an individual under/over-estimates the likelihood of adverse events occurring. 
Optimism bias can lead consumers to believe that potentially harmful products are substantially safer than they actually are, 
leading them to voluntarily expose themselves to greater risk than would be the case if they had more accurately assessed 
the products at issue.
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Prospect theory
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This is a theory proposed by Kahneman and Tversky in 19791 to address the
descriptive failures of rational choice theory (see below). Central propositions are that: individuals tend not to 
treat probabilities with the rigorous mathematical logic of probability theory; they tend to prefer outcomes that are 
certain over those with probabilities attached (see the certainty effect above); preferences are often dependent on a 
reference point (see below); greater weight tends to be attached to losses than to equivalent size gains 
(see the reflection effect below); and the way in which a problem is framed (see above) can exert an influence on 
judgement and decision-making.
                  </div>
               </div>
            </li>

            <li>
               <div data-role="collapsible">
                  <h4>
Reflection effect
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This refers to one of prospect theory’s (see above) central propositions according to which the individual evaluates 
gains and losses differently, with greater weight assigned to losses than to equivalent size gains, relative to the 
present position or to expectations. Where this is the case, people will tend to be more averse to losses than 
they are attracted to equal size gains when faced with risky prospects (loss aversion).
                     </p>
                  </div>
               </div>
            </li>
                                                              
            <li>
               <div data-role="collapsible">
                  <h4>
Weak/soft paternalism
                  </h4>
                  <div  style="white-space:normal;"
                     <p>
This term refers to a family of approaches to policy in the face of the bounded rationality of some consumers; 
these include: libertarian-paternalism, asymmetric paternalism and debiasing through law. 
At the core of these approaches is the idea that, through relatively modest interventions, the behaviour of 
boundedly rational individuals can be brought into closer conformity with the standard model of rationality. 
Since such interventions do not involve restrictions on choice, all three approaches claim to create benefits for 
boundedly rational individuals while imposing little or no harm on rational individuals. 
                     </p>
                  </div>
               </div>
            </li>
            
            
         </ul>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: BehavEco Page -->

<!-- Begin: ABA Page -->
<div data-theme="a" id="pageABA" data-role="page"><section>
   
   <script>writeHeader("backhelp", "home")</script>
      
   <div data-role="content">
      <div class="content-primary" id="ProgramRuleUser">
         <ul data-role="listview" data-filter="true" id="ProgramRuleUserList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               Applied Behavioral Analysis
            </li>


<li> 
<div data-role="collapsible">
<h4> Applied Behavioral Analysis </h4>
<p><div style="white-space:normal;">

Behavior analysis is concerned with understanding how environmental events change behavior, 
applied behavior analysis is concerned with using environmental events to change behvior in desirable ways.
<a href=http://www.amazon.com/First-Course-Applied-Behavior-Analysis/dp/1577664728/ref=sr_1_5?s=books&ie=UTF8&qid=1355114845&sr=1-5&keywords=applied+behaviour+analysis>Chance (2006)</a>

</div></p> 
</div> 
</li>


<li> 
<div data-role="collapsible">
<h4> Radical Behaviorism </h4>
<p><div style="white-space:normal;">

Radical behaviorism considers everything an organism does as behavior, wherver it be "public" behavior observable by others or
"private" behavioral events such as thinking and feeling that can only be directly observed by the person doing it. 

</div></p> 
</div> 
</li>

<li> 
<div data-role="collapsible">
<h4> Functional Contextualism </h4>
<p><div style="white-space:normal;">

A particular philosophy of science that emphasizes two essential elements in radical behaviorism: 
The first is that behavior must always be understood in relation to the setting, or context, in which it takes place. 
The second is that in order to understand and influence behavior, we need to study its function- that is, what it is aimed at.
<a href=http://relationalframetheory.wikispaces.com/Functional+Contextualism>relationalframetheory</a>
<br/>
Functional contextualists seek to predict-and-influence psychological events with precision, scope and depth.
This approach reveals a strong adherence to contextualism's extremely practical truth criterion and can be likened to the enterprise of science or engineering, 
in which general rules and principles are used to predict and influence events. 
Rules or theories that do not contribute to the achievement of one's practical goals are ignored or rejected.   
<a href=http://contextualscience.org/truth_criterion>wiki</a>

</div></p> 
</div> 
</li>

<li> 
<div data-role="collapsible">
<h4> Pragmatic Truth Criterion </h4>
<p><div style="white-space:normal;">

For contextualists the truth and meaning of an idea lies in its function or utility, not in how well it is said to mirror reality. 
The truth criterion of contextualism is thus dubbed successful working, 
whereby an analysis is said to be true or valid insofar as it leads to effective action, or achievement of some goal.  
<a href=http://contextualscience.org/truth_criterion>contextualscience</a>

</div></p> 
</div> 
</li>





            
            
         </ul>
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: ABA Page -->


<!-- Begin: FAQ Page -->
<div data-theme="a" id="pageFAQ" data-role="page"><section>
   
   <script>writeHeader("backhelp", "home")</script>
      
   <div data-role="content">
      <div class="content-primary" id="Terms">
         <ul data-role="listview" data-filter="true" id="TermsList" data-icon="arrow-r" data-inset="true" >
            <li data-role="divider">
               Frequently Asked Questions
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to enrol
</h5>

<p>
<div style="white-space:normal;">
First time users need to enrol in order to use this system. 
The enrolment function is located in the Settings Menu located at http://www.thenudgemachine.com/settings.php
Then select the Enrol menu option at http://www.thenudgemachine.com/register.php and complete the form.
The system just requires a unique string as username, e.g. your University ID "u1234567" and a password.
Ensure that you select the correct program as advised by your coach.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to login
</h5>

<p>
<div  style="white-space:normal;">
Once enrolled, users can login to the system.
The login function is located in the Home Menu located at http://www.thenudgemachine.com/nudge/php/index.php
Then select the Login menu option at http://www.thenudgemachine.com/login.php and complete the form.
Ensure that you select the same program as you entered at enrolment time.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to configure goals
</h5>

<p>
<div  style="white-space:normal;">
The goal configuration function is located in the Settings Menu located at http://www.thenudgemachine.com/settings.php
Then select the Goals menu option at http://www.thenudgemachine.com/programgoal.php?ruletype=gashigh
Goals follow the goal attainment scale (GAS) model and so form a 3-level hierarchy represented as higher order goals
then lower order goals then the final 5 category GAS scale itself.
You can navigate down the goal hierarchy be clicking the goal item itself. You configure a goal at a specific level
by clicking the "gear" configuration icon located on the right most side of the goal item. Once you click the configuration icon
you can edit the goal description for the higher and lower order goals. For the 5 GAS goals you also enter a high and low target 
that represents the thresholds for goals attainment at that level. Ensure that the low and high targets across the 5 GAS goals
completely cover the range of outcomes but do not overlap.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to record goals
</h5>

<p>
<div  style="white-space:normal;">
The goal self-report recording function is located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Goals menu option at http://www.thenudgemachine.com/goal.php?ruletype=gaslow
You can then self-report on your goal attainment by clicking the "r-arrow" icon located on the right most side of the goal item.
The page will tell you the last time you self-reported your goasl attainment and also allows you to enter in the data and time
which is otherwise defaulted to 'now'. Please ensure that the Date, Time and Response are all completed then click submit to record your result. 
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to verify goal was recorded
</h5>

<p>
<div  style="white-space:normal;">
System and user entered events are persisted as "observations" in this system and can be inspected. 
A GAS goal self-report event is one such example.
The data observation function is located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Data menu option at: http://www.thenudgemachine.com/index.php#pageDataEntry and then Observations at: http://www.thenudgemachine.com/userobs.php
You will now see the last 20 observations tagged with a timestamp and description.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to record an observation
</h5>

<p>
<div  style="white-space:normal;">
Users can self-report observations using the data observation function.
This is located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Data menu option at: http://www.thenudgemachine.com/index.php#pageDataEntry and then Observations at: http://www.thenudgemachine.com/userobs.php
You will now see the last 20 observations tagged with a timestamp and description. Now click the "plus" icon on the right side on the page header.
Complete thr form to record your observation then press Add.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to record a journal
</h5>

<p>
<div  style="white-space:normal;">
Users can record a journal or diary entry using the data diary function.
This is located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Data menu option at: http://www.thenudgemachine.com/index.php#pageDataEntry and then Diary at: http://www.thenudgemachine.com/userdiary.php
You will now see the last 20 diary entries tagged with a timestamp and description. Now click the "plus" icon on the right side on the page header.
Complete thr form to record your diary entry then press Add.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
What are charts
</h5>

<p>
<div  style="white-space:normal;">
The system creates graphs and charts which are updated on a regular basis for each program.
This is located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Charts menu option at: http://www.thenudgemachine.com/index.php#pageCharts
Various submenus then direct your to User, Group or Program wide charts.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
What are nudges
</h5>

<p>
<div  style="white-space:normal;">
The Coach may choose to nudge/prompt/reminder Coachees during the course of the program.
These notifications are located in the Home Menu located at http://www.thenudgemachine.com/index.php
Then select the Nudges menu option at: http://www.thenudgemachine.com/msg.php
When you click on a nudge the unread count will be reduced and popup will appear with the full nudge text message
including a Go-To_Site button, as e.g. some notifications may be to prompt you to complete a poll.
</div>
</p>

               </div>
            </li>

            <li>
               <div data-role="collapsible">
<h5>
How to nudge
</h5>

<p>
<div  style="white-space:normal;">
Coaches can nudge all or an individual coachee.
This function is located in the Home Menu at http://www.thenudgemachine.com/index.php
Then select the Coachees menu option at: http://www.thenudgemachine.com/programuser.php?roletype=participant
To nudge a specific coachee, click the coachee of interest, a popup will appear then click the Nudge button.
A form will now appear in which the Coach can enter a message and optionally a pointer to a resource of interest.
This can be a pointer to a Link or to complete a Poll. 
Record a standard Link style resource by giving it some short name in the "URL Label:" field 
and then entering in the full URL in the "URL:" field.
To issue a nudge to complete a spot Poll, you would instead selecte Poll as your Resource "Type:". 
The "URL Label:" can be anything you like, e.g. "Sleep Spot Poll", however "URL:" field entry should be something
like "pollq.php?pollid=1"  The "pollid=" part should reflect the ID number of the Poll you want to nudge.
This number can be found by visiting the Polls Manue clocated under the Config Menu at: http://www.thenudgemachine.com/poll.php?roletype=architect
Upon selecting the Polls menu you will see a list of polls each with their URL string.
To nudge all coaches, instead of selecting a specific Coachee, click the "plus" icon at the right hand side of the page footer.
The rest of the instructions are as before.
</div>
</p>

               </div>
            </li>
            <li>
               <div data-role="collapsible">
<h5>
How to create a resource
</h5>

<p>
<div  style="white-space:normal;">
Coaches can create links to resources and content.
This function is located in the Home Menu at http://www.thenudgemachine.com/index.php
Then select the Resources menu option at: http://www.thenudgemachine.com/index.php#pageResources
Then select the Link menu at: http://www.thenudgemachine.com/programurl.php?urltype=link
To add a link to a new resource, click the "add" icon at the right side of the page header.
A form will now appear in which the Coach can enter the resource details.
The "Label:" can be anything you like, e.g. "Meditation Web Page".
The "URL:" field entry should be the URL link to the resource just as you would enter in a browser, e.g.
http://www.smh.com.au"
Leave the "URL icon:" field as per the default entry.
</div>
</p>

               </div>
            </li>                                    
         </ul>
         
         
   </div>
   
   <script> writeFooter(); </script>
         
</section></div>
<!-- End: FAQ Page -->


 </body>
 
<script>

$('#login').click(function() {
   $.mobile.changePage('login.php'); 
});
        
</script>

   
</html>

          