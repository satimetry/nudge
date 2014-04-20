#!/usr/bin/Rscript

# Batch control script
Sys.setenv(NOAWT = "true")

#rooturl <<- "http://localhost:8080/tnm/rest"
rooturl <<- "http://nudgeserver-spicozzi.rhcloud.com/tnm/rest"
rootdir <<- "/Users/stefanopicozzi/websites/nudge/R/lifecoach/dofitbit"
imagesdir <<- "/Users/stefanopicozzi/websites/nudge/images"
setwd(rootdir)
ppi <<- 300

source("common.R")

# Do programid=1 and activity observations
programid <<- 1
obsname <<- 'activity'

# Get programusers enrolled for this programid
programusers <- getProgramuser(rooturl, programid)

for (programuser in programusers) {

   userid <<- programuser["userid"]

   if ( userid != 7 ) { next }

   print(paste("--->INSERTOBS --", userid, sep = ""))
   source("dofitbitobs.R", echo = TRUE )
   
   print(paste("--->APPLYNUDGES --", userid, sep = ""))
   source("dofitbitnudges.R", echo = TRUE )
      
   print(paste("--->PUSHNOTIFICATION :", userid, sep = ""))
   source("dofitbitnotifications.R", echo = TRUE )
   
   print(paste("--->PLOTS :", userid, sep = ""))
   source("dofitbitplots.R", echo = TRUE )
   
}
