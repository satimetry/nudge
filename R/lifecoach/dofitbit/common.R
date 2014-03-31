# Nudge common functions

library(httr)
library(rjson)
library('RCurl')

getPushover <- function(pushoveruser, msgtxt) {
   curl_cmd = paste(
      "curl -s",
      " -F \"token=acqa2Xgn6Fj7NsctUaxqPm8ngURksP\" ",
      " -F \"user=", pushoveruser, "\" ",
      " -F \"message=", msgtxt, "\" ",
      " https://api.pushover.net/1/messages.json", 
      sep = "")
   result <- tryCatch({
      system(curl_cmd)
   }, warning = function(w) {
      print("Warning")
      stop()
   }, error = function(e) {
      print("Error pushover.net")
      message(e)
      stop()
   }, finally = {
   })
}

getRulefile <- function(rooturl, programid, groupid, rulename) {
  rulefileJSON <- tryCatch({  
    getURL(paste(rooturl, "/rulefile?programid=", programid, "&groupid=", groupid, "&rulename=", rulename, sep=""))
  }, warning = function(w) {
    print("Warning")
  }, error = function(e) {
    print("Error getRulefile")
    message(e)
    stop()
  }, finally = {
  })
  rulefile <- fromJSON(rulefileJSON)
  return(rulefile)
}

getNudge <- function(rooturl, programid, groupid, rulename) {
  result <- tryCatch({  
    facts <- getURL(paste(rooturl, "/nudge?", "programid=", programid, "&groupid=", userid, "&rulename=", rulename, sep=""))
  }, warning = function(w) {
    print("Warning getNudge")
  }, error = function(e) {
    print("Error getNudge")
    message(e)
    stop()
  }, finally = {
  })
  print(result)
}

getFactDF <- function(rooturl, programid, groupid) {
  factJSON <- tryCatch({  
    getURL(paste(rooturl, "/fact/user?programid=", programid, "&groupid=", groupid, sep=""))
  }, warning = function(w) {
    print("Warning getProgramuserDF")
  }, error = function(e) {
    print("Error getProgramuserDF")
    message(e)
    stop()
  }, finally = {
  })
  facts <- fromJSON(factJSON)
  factDF = c()
  for (fact in facts ) {
    factDF <- cbind( factDF, c( id=fact$id, programid=fact$programid, groupid=fact$groupid, factjson=fact$factjson ) )
  }
  factDF <- t(factDF)
  return(factDF)
}

getFactsystem <- function(rooturl, programid, groupid) {
  factJSON <- tryCatch({  
    getURL(paste(rooturl, "/fact/system?programid=", programid, "&groupid=", groupid, sep=""))
  }, warning = function(w) {
    print("Warning getProgramuserDF")
  }, error = function(e) {
    print("Error getProgramuserDF")
    message(e)
    stop()
  }, finally = {
  })
  return(fromJSON(factJSON))
}

getFactsystemDF <- function(rooturl, programid, groupid) {
  factJSON <- tryCatch({  
    getURL(paste(rooturl, "/fact/system?programid=", programid, "&groupid=", groupid, sep=""))
  }, warning = function(w) {
    print("Warning getProgramuserDF")
  }, error = function(e) {
    print("Error getProgramuserDF")
    message(e)
    stop()
  }, finally = {
  })
  facts <- fromJSON(factJSON)
  return(as.data.frame(do.call(rbind, facts)))
   
#  facts <- fromJSON(factJSON)
#  factDF = c()
#  for (fact in facts) {
#    factDF <- cbind( factDF, c( id=fact$id, programid=fact$programid, groupid=fact$groupid, factjson=fact$factjson ) )
#  }
#  factDF <- t(factDF)
#  return(factDF)
}

delFact <- function(rooturl, programid, groupid) {
  result <- tryCatch({  
    getURL(paste(rooturl, "/fact/del?programid=",programid, "&groupid=", groupid, sep=""))
  }, warning = function(w) {
    print("Warning delFact")
  }, error = function(e) {
    print("Error delFact")
    message(e)
    stop()
  }, finally = {
  })
  return(result)
}

postFact <- function(rootusr, programid, groupid, userobsDF) {
  for (i in 1:nrow(userobsDF)) {
    
    #JSON <- paste("{ \"programid\" :", programid, ", \"groupid\" :", groupid, ", \"facttype\" : 0", ", \"factjson\" :\"", toString(toJSON(userobsDF[i,])), "\"  }", sep="")
    #curl.opts <- list(postfields = JSON, httpheader = c("Content-Type: application/json", "Accept: application/json"), useragent = "RCurl", ssl.verifypeer = FALSE)

    username <- groupid
    obsname <- userobsDF[i, "obsname"]
    obsdate <- userobsDF[i, "obsdate"]
    obsdate <- paste("\"", obsdate, "\"", sep="")
    obsvalue <- userobsDF[i, "obsvalue"]
    obsdesc <- "\"Generated using R sysbatch procedure\"";
    
    factjson <- paste('{ \"username\":', username, 
                      ', \"obsname\":', obsname, 
                      ', \"obsdate\":', obsdate, 
                      ', \"obsvalue\":', obsvalue,
                      ', \"obsdesc\":', obsdesc, '}' )
    
    #  params <- paste("programid=", programid, "&groupid=", userid, "&factjson=", factjson, sep="")
    #  url <- paste("curl -X POST --data '", params, "' ", rooturl, "/fact", sep="")
    
    result <- tryCatch({      
      # postForm( paste(rooturl, "/fact", sep=""), .opts = curl.opts )
      postForm( paste(rooturl, "/fact", sep=""), programid=programid, groupid=userid, factjson=factjson, style="POST"  )
      # system(url)
    }, warning = function(w) {
      print("Warning postMsg")
    }, error = function(e) {
      print("Error postMsg")
      message(e)
      stop()
    }, finally = {
    })
  }
  return(result)
}

getProgramuser <- function(rooturl, programid) {
   programuserJSON <- tryCatch({  
      getURL(paste(rooturl, "/programuser/user?programid=", programid, sep=""))
   }, warning = function(w) {
      print("Warning getProgramuser")
   }, error = function(e) {
      print("Error getProgramuser")
      message(e)
      stop()
   }, finally = {
   })
   programusers <- fromJSON(programuserJSON)
   return(programusers)
}

getProgramuserDF <- function(rooturl, programid) {
   programuserJSON <- tryCatch({  
      getURL(paste(rooturl, "/programuser/user?programid=", programid, sep=""))
   }, warning = function(w) {
      print("Warning getProgramuserDF")
   }, error = function(e) {
      print("Error getProgramuserDF")
      message(e)
      stop()
   }, finally = {
   })
   programusers <- fromJSON(programuserJSON)
   programuserDF = c()
   for (programuser in programusers) {
      programuserDF <- cbind( programuserDF, c( userid=programuser$userid, roletype=programuser$roletype ) )
   }
   programuserDF <- t(programuserDF)
   programuserDF <- subset(programuserDF, programuserDF[,"roletype"] == "participant")  
   return(programuserDF)
}

getUser <- function(rooturl, userid) {
   userJSON <- tryCatch({  
      getURL(paste(rooturl, "/user/user?userid=", userid, sep=""))
   }, warning = function(w) {
      print("Warning")
   }, error = function(e) {
      print("Error getUser")
      message(e)
      stop()
   }, finally = {
   })
   users <- fromJSON(userJSON)
   return(users)
}

getRule <- function(rooturl, rulename) {
  ruleJSON <- tryCatch({  
    getURL(paste(rooturl, "/rule?rulename=", rulename, sep=""))
  }, warning = function(w) {
    print("Warning")
  }, error = function(e) {
    print("Error getRule")
    message(e)
    stop()
  }, finally = {
  })
  rules <- fromJSON(ruleJSON)
  return(rules)
}

postUserobs <- function(rooturl, userobs) {
   
   JSON <- paste("{ \"programid\" :", userobs["programid"], ", \"userid\" :", userobs["userid"], ", \"obsname\" :", userobs["obsname"], ", \"obsvalue\" :", userobs["obsvalue"], ", \"obsdesc\" :", userobs["obsdesc"], ", \"obsdate\" :", userobs["obsdate"], ", \"obstype\" : \"userobs\" }", sep="")
   curl.opts <- list(postfields = JSON, httpheader = c("Content-Type: application/json", "Accept: application/json"), useragent = "RCurl", ssl.verifypeer = FALSE)
   
   result <- tryCatch({      
      postForm( paste(rooturl, "/userobs", sep=""), .opts = curl.opts )
   }, warning = function(w) {
      print("Warning postUserobs")
   }, error = function(e) {
      print("Error postUserobs")
      message(e)
      stop()
   }, finally = {
   })
   return(result)
}

delUserobs <- function(rooturl, programid, userid) {
   
   result <- tryCatch({  
      getURL(paste(rooturl, "/userobs/del?programid=", programid, "&userid=", userid, "&obsname=", "activity", sep=""))
   }, warning = function(w) {
      print("Warning")
   }, error = function(e) {
      print("Error delUserobs")
      message(e)
      stop()
   }, finally = {
   })
   
   return(result)
}

getUserobs <- function(rooturl, programid, userid, obsname) {
   userobsJSON <- tryCatch({  
      getURL(paste(rooturl, "/userobs/user?programid=", programid, "&userid=", userid, "&obsname=", obsname, sep=""))
   }, warning = function(w) {
      print("Warning getUserobs")
   }, error = function(e) {
      print("Error getUserobs")
      message(e)
      stop()
   }, finally = {
   })
   userobss <- fromJSON(userobsJSON)
   return(userobss)
}

getUserobsDF <- function(rooturl, programid, userid, obsname) {
   userobsJSON <- tryCatch({  
      getURL(paste(rooturl, "/userobs/user?programid=", programid, "&userid=", userid, "&obsname=", obsname, sep=""))
   }, warning = function(w) {
      print("Warning")
   }, error = function(e) {
      print("Error getUserobsDF")
      message(e)
      stop()
   }, finally = {
   })
   userobss <- fromJSON(userobsJSON)
   userobsDF <- c()
   for (userobs in userobss) {
      obsdate <- toString(as.POSIXlt( as.numeric(userobs$obsdate)/1000, origin="1970-01-01 00:00:00" ))
      userobsDF <- cbind( userobsDF, c( id=userobs$userobsid, username=userobs$userid, obsname=userobs$obsname, obsdate=obsdate, obsvalue=userobs$obsvalue ) )
   }
   userobsDF <- t(userobsDF)
   return(userobsDF)
}

getOptinruleviewDF <- function(rooturl, programid, userid) {
   optinruleviewJSON <- tryCatch({  
      getURL(paste(rooturl, "/optinruleview/user?programid=", programid, "&userid=", userid, sep=""))
   }, warning = function(w) {
      print("Warning")
   }, error = function(e) {
      print("Error getOptinruleviewDF")
      message(e)
      stop()
   }, finally = {
   })
   optinruleviews <- fromJSON(optinruleviewJSON)
   optinruleviewDF = c()
#   lapply(optinruleview, function(rulename=optinruleview$rulename) { cbind( optinruleviewDF, c(rulename) ) } )
   for (optinruleview in optinruleviews) {
      optinruleviewDF <- cbind( optinruleviewDF, c( rulename=optinruleview$rulename ) )
   }
   optinruleviewDF <- t(optinruleviewDF)
   optinruleviewDF <- optinruleviewDF[order(optinruleviewDF[, "rulename"]),]
   return(optinruleviewDF)
}

getMsgDF <- function(rooturl, programid, userid) {
   msgJSON <- tryCatch({  
      getURL(paste(rooturl, "/msg/isnotsent?programid=", programid, "&userid=", userid, sep=""))
   }, warning = function(w) {
      print("Warning getMsgDF")
   }, error = function(e) {
      print("Error getMsgDF")
      message(e)
      stop()
   }, finally = {
   })
   msgs <- fromJSON(msgJSON)
   msgDF <- c()
   for (msg in msgs) {
      msgdate <- toString(as.POSIXlt( as.numeric(msg$ruledate)/1000, origin="1970-01-01 00:00:00" ))
      msgDF <- cbind( msgDF, c( msgid=msg$msgid, userid=msg$userid, rulename=msg$rulename, msgdate=msgdate, msgtxt=msg$msgtxt ) )
   }
   msgDF <- t(msgDF)
   return(msgDF)
}

getMsg <- function(rooturl, programid, userid) {
   msgJSON <- tryCatch({  
      getURL(paste(rooturl, "/msg/isnotsent?programid=", programid, "&userid=", userid, sep=""))
   }, warning = function(w) {
      print("Warning getMsg")
   }, error = function(e) {
      print("Error getMsg")
      message(e)
      stop()
   }, finally = {
   })
   msgs <- fromJSON(msgJSON)
   return(msgs)
}

postMsg <- function(rootusr, msg) {
   JSON <- paste("{ \"programid\" :", msg["programid"], ", \"userid\" :", msg["userid"], ", \"ruleid\" :", msg["ruleid"], ", \"rulename\" :", msg["rulename"], ", \"ruledate\" :", msg["ruledate"], ", \"msgtxt\" :", msg["msgtxt"], " }", sep="")
   curl.opts <- list(postfields = JSON, httpheader = c("Content-Type: application/json", "Accept: application/json"), useragent = "RCurl", ssl.verifypeer = FALSE)
   print(JSON)
   result <- tryCatch({      
      postForm( paste(rooturl, "/msg", sep=""), .opts = curl.opts )
   }, warning = function(w) {
      print("Warning postMsg")
   }, error = function(e) {
      print("Error postMsg")
      message(e)
      stop()
   }, finally = {
   })
   
   return(result)
}

setMsgissent <- function(rooturl, msgid) {
      msgJSON <- tryCatch({  
      getURL(paste(rooturl, "/msg/issent?msgid=", msgid, sep=""))
   }, warning = function(w) {
      print("Warning")
   }, error = function(e) {
      print("Error setMsgissent")
      message(e)
      stop()
   }, finally = {
   })
}