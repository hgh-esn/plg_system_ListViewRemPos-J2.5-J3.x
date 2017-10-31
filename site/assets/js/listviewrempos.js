/**
 *
 * @package	   Joomla.Site
 * @subpackage com_content
 * System 	   Plugin
 * @copyright  Hans-Guenter Heiserholt {@link http://www.web-hgh.de}
 * @author     Hans-Guenter Heiserholt / Created on 21-Sep-2014
 * @license    GNU/GPL Public License version 2 or later
 */
  
/* 
 * JavaScript behavior to allow remember/set the selected positionen in Joomla Listview
 */
    var cname = 'LVRP_tmpCookie';
		
	var valx = 0;
	var valy = 0;
	  
//   alert('cookiename=' + cname);
  
function LVRP_getPos() {

/*
 * This funtion is called bei the HTML-Document to get the act. coordinates
 */
 
   setCookie(cname, window.pageXOffset + "," + window.pageYOffset, 1);
}

function LVRP_scroll2Pos() {
	
    if(getCookie(cname)) {
		/* 	
		 * Wichtig, damit bei der "nur Aktualisierung" der Seite 
		 * die Funktion nicht ausgeführt wird.
		 */
		if (chkCookie(cname) === true) {
//			alert('LVRP_scroll2Pos: valx= ' + valx	+ ' valy=' + valy);
			window.scrollTo(valx, valy);						
		}	
		delCookie(cname);   // löschen temporäres Cookie
	}
}

function setCookie(name, value, exdays) {
 
//   alert('fkt:setCookie: ' + name + ' ' + value + ' ' + exdays);
 
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));   // exdays = 1 day
    var expires = 'expires='+d.toUTCString();
    document.cookie = name + '=' + value + '; ' + expires;
}

function getCookie(name) {
	
    var name = name + '=';
	var ca = document.cookie.split(';');
	
	for (var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) != -1) {
//  			alert('fkt:getCookie: ' + 'name-lenght= ' + name.length + ' c-lenght= ' + c.length);
			return c.substring(name.length, c.length);
		}
    }
    return '';
}

function delCookie(name) {
//    alert('fkt:delCookie:' + name);
//    document.cookie =  name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
      setCookie(name,'',-1);
}

function chkCookie(name) {

//  alert('fkt:chkCookie:' + name);	

	/*
	 * the cookie-value is stored as: x,y
	 */
	
	var val = getCookie(name);
	pos = val.search(',');                         // find the delimiter

//	alert("fkt:chkCookie: Pos= " + pos + " Window-Offset: " + valx + "/" + valy);
	
	if (pos > -1) {
		valx = val.substr(0,pos);
		valy = val.substr(pos+1,val.length);
		return true;
	} else {
		alert ('Error by chkCookie - wrong delimiter.');
		return false;
	}
}