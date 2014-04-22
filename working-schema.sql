

CREATE TABLE programpolluser (
programpolluserid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
pollid int(11) NOT NULL,
userid int(11) NOT NULL,
polldate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
lastqseqno int(11) NOT NULL DEFAULT 0,
lastqdate timestamp,
qcount int(11) NOT NULL DEFAULT 0,
q01value int(11),
q02value int(11),
q03value int(11),
q04value int(11),
q05value int(11),
q06value int(11),
q07value int(11),
q08value int(11),
q09value int(11),
q10value int(11),
PRIMARY KEY (programpolluserid)
);

// Probably not needed
CREATE TABLE programrulepoll (
programrulepollid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
ruleid int(11) NOT NULL,
pollid int(11) NOT NULL,
PRIMARY KEY (programrulepollid)
);


CREATE TABLE poll (
pollid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
pollname varchar(30) NOT NULL,
qcount int(11) NOT NULL,
polldesc varchar(140) NOT NULL,
PRIMARY KEY (pollid),
UNIQUE KEY pollname (pollname)
);


CREATE TABLE pollq (
pollqid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
pollid int(11) NOT NULL,
qseqno int(11) NOT NULL,
qname varchar(30) NOT NULL,
qcount int(11) NOT NULL,
qinstruction varchar(256) NOT NULL,
qtext varchar(256) NOT NULL,
q01value int(11),
q01label varchar(30),
q02value int(11),
q02label varchar(30),
q03value int(11),
q03label varchar(30),
q04value int(11),
q04label varchar(30),
q05value int(11),
q05label varchar(30),
q06value int(11),
q06label varchar(30),
q07value int(11),
q07label varchar(30),
q08value int(11),
q08label varchar(30),
q09value int(11),
q09label varchar(30),
q10value int(11),
q10label varchar(30),
PRIMARY KEY (pollqid)
);



CREATE TABLE hit (
hitid int(11) NOT NULL auto_increment,
hitdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
hitip varchar(30),
urlname varchar(30) NOT NULL,
programid int(11),
userid int(11),
PRIMARY KEY (hitid)
);

CREATE TABLE programurl (
programurlid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
urltype varchar(30) NOT NULL DEFAULT "URL",
urlname varchar(30) NOT NULL,
urllabel varchar(30) NOT NULL,
urldesc varchar(140) NOT NULL,
urldate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
msgid int(11),
PRIMARY KEY (programurlid)
);

// Nedd to alter table to add/remove ruleid/rulename
CREATE TABLE msg (
msgid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
userid int(11) NOT NULL,
ruleid int(11) NOT NULL,
msgdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
rulename varchar(30),
ruledate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
msgtxt varchar(512) NOT NULL,
issent tinyint NOT NULL DEFAULT FALSE,
isread tinyint NOT NULL DEFAULT FALSE,
urldesc varchar(140),
PRIMARY KEY (msgid)
);


CREATE TABLE user (
userid int(11) NOT NULL auto_increment,
username varchar(20) NOT NULL,
password char(40) NOT NULL,
pushoveruser varchar(40),
fitbitkey varchar(40),
fitbitsecret varchar(40),
fitbitappname varchar(40),
PRIMARY KEY (userid),
UNIQUE KEY username (username)
);

CREATE TABLE program (
programid int(11) NOT NULL auto_increment,
programname varchar(30) NOT NULL,
isdefault tinyint NOT NULL DEFAULT FALSE,
PRIMARY KEY (programid),
UNIQUE KEY programname (programname)
);

CREATE TABLE rule (
ruleid int(11) NOT NULL auto_increment,
rulename varchar(30) NOT NULL,
ruledesc varchar(140) NOT NULL,
ruletype varchar(30) NOT NULL DEFAULT "program",
awardtype varchar(30) NOT NULL DEFAULT "gold",
pollname varchar(30) NOT NULL,
parentruleid int(11),
PRIMARY KEY (ruleid),
UNIQUE KEY rulename (rulename)
);

CREATE TABLE programrule (
programruleid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
ruleid int(11) NOT NULL,
rulehigh int(11) DEFAULT 0,
rulelow int(11) DEFAULT 0,
rulepoint int(11) DEFAULT 0,
PRIMARY KEY (programruleid)
);

CREATE TABLE programuser (
programuserid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
userid int(11) NOT NULL,
roletype varchar(30) NOT NULL DEFAULT 'participant',
msgtotalcount int(11) NOT NULL DEFAULT 0,
msgunreadcount int(11) NOT NULL DEFAULT 0,
ruleoptincount int(11) NOT NULL DEFAULT 0,
pointcount int(11) NOT NULL DEFAULT 0,
PRIMARY KEY (programuserid)
);

CREATE TABLE programruleuser (
programruleuserid int(11) NOT NULL auto_increment,
programid int(11) NOT NULL,
ruleid int(11) NOT NULL,
userid int(11) NOT NULL,
rulevalue int(11) NOT NULL DEFAULT 0,
rulehigh int(11),
rulelow int(11),
ruleuserdesc varchar(140)
PRIMARY KEY (programruleuserid)
);

CREATE TABLE userobs (
userobsid int(11) NOT NULL auto_increment,
userid varchar(30) NOT NULL,
programid varchar(30) NOT NULL,
obsname varchar(30) NOT NULL,
createdate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
obsvalue varchar(30),
obsdesc varchar(140),
obsdate timestamp NOT NULL,
obstype varchar(30) NOT NULL DEFAULT 'userobs'
PRIMARY KEY (userobsid)
);

CREATE TABLE userdiary (
userdiaryid int(11) NOT NULL auto_increment,
userid int(11) NOT NULL,
programid varchar(30) NOT NULL,
diarydate timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
diarytxt varchar(140),
PRIMARY KEY (userdiaryid)
);


CREATE TABLE question (
question_id int(11) NOT NULL auto_increment,
question_name varchar(30) NOT NULL,
question_seqno int(11) NOT NULL,
total_questions int(11) NOT NULL,
total_options int(11) NOT NULL,
question_instruction varchar(256) NOT NULL,
question_text varchar(256) NOT NULL,
option_01_value int(11),
option_01_label varchar(30),
option_02_value int(11),
option_02_label varchar(30),
option_03_value int(11),
option_03_label varchar(30),
option_04_value int(11),
option_04_label varchar(30),
option_05_value int(11),
option_05_label varchar(30),
option_06_value int(11),
option_06_label varchar(30),
option_07_value int(11),
option_07_label varchar(30),
option_08_value int(11),
option_08_label varchar(30),
option_09_value int(11),
option_09_label varchar(30),
option_10_value int(11),
option_10_label varchar(30),
PRIMARY KEY (question_id)
);

CREATE TABLE survey (
survey_id int(11) NOT NULL auto_increment,
survey_name varchar(30) NOT NULL,
question_seqno int(11) NOT NULL,
question_name varchar(30) NOT NULL,
PRIMARY KEY (survey_id)
);

CREATE TABLE survey_user (
survey_user_id int(11) NOT NULL auto_increment,
survey_id int(11) NOT NULL,
user_id int(11) NOT NULL,
survey_date date NOT NULL,
last_question_seqno int(11) NOT NULL,
total_questions int(11) NOT NULL,
PRIMARY KEY (survey_user_id)
);



CREATE TABLE program_tasklist (
program_tasklist_id int(11) NOT NULL auto_increment,
program_id int(11) NOT NULL,
task_date date NOT NULL,
task_name_01 varchar(30),
task_name_02 varchar(30),
task_name_03 varchar(30),
task_name_04 varchar(30),
task_name_05 varchar(30),
PRIMARY KEY (program_tasklist_id)
);

// do with programrulepoll
CREATE TABLE survey_task (
survey_task_id int(11) NOT NULL auto_increment,
task_name varchar(30) NOT NULL,
task_seqno int(11) NOT NULL,
total_tasks int(11) NOT NULL,
question_name varchar(30) NOT NULL,
question_seqno int(11) NOT NULL,
PRIMARY KEY (survey_task_id)
);

// do this with userobs
CREATE TABLE user_task (
user_task_id int(11) NOT NULL auto_increment,
program_name varchar(30) NOT NULL,
user_name varchar(30) NOT NULL,
task_name varchar(30) NOT NULL,
task_date DATE NOT NULL,
last_task_seqno int(11) NOT NULL,
total_tasks int(11) NOT NULL,
PRIMARY KEY (user_task_id)
);

load data local infile '/Users/stefanopicozzi/Downloads/user_tasks.csv' 
into table user_task
fields terminated by ','
ESCAPED BY '\\'
enclosed by '"'
LINES TERMINATED BY '\n'
(
program_name,
user_name,
task_name,
task_date,
last_task_seqno,
total_tasks 
)



INSERT INTO survey_task (
	task_name, 
	task_seqno, 
	total_tasks, 
	question_name, 
	question_seqno)
SELECT 
	"daily",
	1,
	1,
	question_name, 
	question_seqno
FROM question;

// do this with programrule
CREATE TABLE task (
task_id int(11) NOT NULL auto_increment,
task_name varchar(30) NOT NULL,
task_type varchar(30) NOT NULL,
PRIMARY KEY (task_id),
UNIQUE KEY task_name (task_name)
);

// do this with programruleuser
CREATE TABLE program_tasklist_user (
program_tasklist_user_id int(11) NOT NULL auto_increment,
program_id int(11) NOT NULL,
user_id int(11) NOT NULL,
task_date date NOT NULL,
task_complete_01 binary,
task_complete_02 binary,
task_complete_03 binary,
task_complete_04 binary,
task_complete_05 binary,
PRIMARY KEY (program_tasklist_user_id)
);



INSERT INTO survey_user 
	(survey_id, user_id, survey_date, last_question_seqno, total_questions) 
SELECT
	s.survey_id, u2.study1_user_id, "2013-09-07", 0, s.total_questions
FROM 
	survey_user s, 
	study1_users u1, 
	study1_users u2
WHERE s.user_id = u1.study1_user_id
 AND  u1.study1_username = 'ZZ99'
 AND  u2.study1_username != 'ZZ99';
 
INSERT INTO program_tasklist_user 
	(program_id, user_id, task_date) 
SELECT
	p.program_id, u.study1_user_id, p.task_date
FROM 
	program_tasklist p, 
	study1_users u
WHERE p.program_id = 1
 AND  u.study1_username != 'ZZ99';
 
  

load data local infile '/Users/stefanopicozzi/Downloads/questions.csv' 
into table question 
fields terminated by ','
ESCAPED BY '\\'
enclosed by '"'
LINES TERMINATED BY '\r'
(
question_name,
question_seqno,
total_questions,
total_options,
question_instruction,
question_text,
option_01_value,
option_01_label,
option_02_value,
option_02_label,
option_03_value,
option_03_label,
option_04_value,
option_04_label,
option_05_value,
option_05_label,
option_06_value,
option_06_label,
option_07_value,
option_07_label,
option_08_value,
option_08_label,
option_09_value,
option_09_label,
option_10_value,
option_10_label
)


