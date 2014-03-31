# Send notification

# Get user details for userid
user <- getUser(rooturl, userid)
username <- user['username']
pushoveruser <- user['pushoveruser']

msgs <- getMsg(rooturl, programid, userid)
for (msg in msgs) {
   msgtxt <- paste(msg["msgtxt"], ". To opt-out from nudges visit: ", "http://www.satimetry.com/rulesettings.php", sep = "")       
   # getPushover(pushoveruser, msgtxt)
   print(msgtxt)
   # Set issent for this msgid
   setMsgissent(rooturl, msgid=msgDF[i, "msgid"]) 
}
