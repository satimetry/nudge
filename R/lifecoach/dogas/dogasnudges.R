# Pull down observations and apply all rules
Sys.setenv(NOAWT = "true")

library(httr)
library(rjson)
library("RMySQL")
library("Rdrools6")
ls("package:Rdrools6", all = TRUE)
lsf.str("package:Rdrools6", all = TRUE)

sqlStmt <- paste(
  " SELECT polldate AS obsdate, q01value AS obsvalue ",
  "  FROM programpolluser",
  "  WHERE pollid = ", pollid,
  "   AND  programid = ", programid,
  "   AND  userid = ", userid, 
  "  ORDER BY obsdate", sep = "")

obsDF <- c()
obsDF <- dbGetQuery(con, sqlStmt)

if ( nrow(obsDF) < 1 ) {
#  obsDF <- cbind( c("0000-00-00 00:00:00"), c("0") )
  obsDF <- cbind( c("2014-03-15 00:00:00"), c("2") )
}
colnames(obsDF) = c("obsdate", "obsvalue")

inputDF <- cbind( id = c(user), gastype, obsDF)
input.columns <- colnames(inputDF)
output.columns <-c ("id", "rulename", "ruledate", "rulemsg", "ruledata")

rules <- readLines("dogas.drl")
mode <- "STREAM"
rules.session <- rulesSession(mode, rules, input.columns, output.columns)
outputDF <- runRules(rules.session, inputDF)

# Apply opt-outs

sqlStmt <- paste(
   " SELECT r.rulename FROM programruleuser pru, rule r",
   " WHERE pru.userid = ", userid, 
   " AND pru.programid = ", programid,
   " AND  pru.ruleid = r.ruleid",
   " AND  r.rulename != 'ruleManual'",
   " AND  pru.rulevalue = 1", sep = "")

optionsListDF <- dbGetQuery(con, sqlStmt)
Sys.sleep(2)

optionsListDF <- optionsListDF[order(optionsListDF$rulename),]
outputDF <- data.frame(lapply(outputDF, as.character), stringsAsFactors=FALSE)
outputDF <- outputDF[order(outputDF$rulename),]
#userOptionsDF <- subset(outputDF, rulename %in% optionsListDF )
userOptionsDF <- outputDF

smsDF <- cbind(userOptionsDF, smstxt = userOptionsDF$rulename)
smsDF <- data.frame(lapply(smsDF, as.character), stringsAsFactors = FALSE)

today <- Sys.Date()
print(today)
for (i in 1:nrow(smsDF)) {
   
   print(smsDF[i, "smstxt" ])  
   
   username <- smsDF[i, "username"]
   rulename <- paste("'", smsDF[i, "rulename" ], "'", sep="")
   ruledate <- paste("'", smsDF[i, "ruledate" ], "'", sep="")
   msgtxt <- paste("'", smsDF[i, "rulemsg" ], "'", sep="")
   urldesc <- paste("'", smsDF[i, "ruledata" ], "'", sep="")
   
   sqlStmt <- paste(
      " INSERT INTO msg (programid, userid, rulename, ruledate, msgtxt, urldesc)",
      "  VALUES (", 
      programid, ", ",
      userid, ", ",
      rulename, ", ",
      ruledate, ", ",
      msgtxt, ", ",      
      urldesc, " ",
      "); ", 
      sep = "")

   print(sqlStmt)
   result <- dbGetQuery(con, sqlStmt)
   Sys.sleep(1)
   result <- dbGetQuery(con, "COMMIT;")
}


