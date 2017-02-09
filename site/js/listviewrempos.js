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

        cname = 'tmp_lastpos';
        
function getDocPos() {

/* window.scrollto(0,400); */
//    alert('listviewrempos: pageXOffset: ' + window.pageXOffset + ', pageYOffset: ' + window.pageYOffset);  
   
// var cname = 'tmp_lastpos';
   var cvalue = window.pageYOffset;
   var exdays = 1;
   
   delete_cookie(cname);
   setCookie(cname, cvalue, exdays);
}

function setCookie(cname, cvalue, exdays) {
 
//  alert('setCookie: ' + cname + ' ' + cvalue + ' ' + exdays);
 
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));   // exdays = 1 day
    var expires = 'expires='+d.toUTCString();
    document.cookie = cname + '=' + cvalue + '; ' + expires;
}

function getCookie(cname) {
	
    var name = cname + '=';
	var ca = document.cookie.split(';');
	
	for (var i=0; i<ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1);
		if (c.indexOf(name) != -1) {
// 			alert('getCookie: ' + 'name-lenght= ' + name.length + ' c-lenght= ' + c.length);			   
			return c.substring(name.length, c.length);
		}
    }
    return '';
}
function delete_cookie(name) {
  document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function go2pos() {
        
	var a = getCookie(cname);  
  
//	alert('Qookie geladen: ' + a);   
//	alert('Dokument geladen: jetzt wird gescrollt');
        
	window.scrollTo(0, a);
//  delete_cookie(cname);   darf nicht gelöscht werden ! sonst wird nicht gescrollt. 
}
/*
function checkCookie() {

    var user = getCookie('username');
    if (user != '') {
        alert('Welcome again ' + user);
    } else {
        user = prompt('Please enter your name:', '');
        if (user != '' && user != null) {
            setCookie('username', user, 365);
        }
    }
}
*/