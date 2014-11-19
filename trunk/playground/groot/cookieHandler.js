function createCookie(name, value, secs) { 
  if (secs) { 
    var date = new Date(); 
    date.setTime(date.getTime()+(secs*1000)); 
    var expires = "; expires="+date.toGMTString(); 
  } 
  else var expires = ""; 
  document.cookie = name + "=" + value+expires + "; path=/"; 
} 



function readCookie(name) { 
  var nameEQ = name + "="; 
  var ca = document.cookie.split(';'); 
  for(var i=0; i < ca.length; i++) { 
    var c = ca[i]; 
    while (c.charAt(0) == ' ') c = c.substring(1, c.length); 
    if (c.indexOf(nameEQ) == 0) 
      return c.substring(nameEQ.length, c.length); 
  } 
  return null; 
} 



function eraseCookie(name) { 
    createCookie(name, "", -1); 
} 





function clearSC() {
	console.log("clearSC START:");
	//eraseCookie("chosenProducts");
	var temp = readCookie("PHPSESSID");
	document.write(temp);
}