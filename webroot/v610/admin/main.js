// v5.10 -> jan. 18, 2005
// load htmlarea
_editor_url = "../";                     // URL to htmlarea files
var win_ie_ver = parseFloat(navigator.appVersion.split("MSIE")[1]);
if (navigator.userAgent.indexOf('Mac')        >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Windows CE') >= 0) { win_ie_ver = 0; }
if (navigator.userAgent.indexOf('Opera')      >= 0) { win_ie_ver = 0; }
if (win_ie_ver >= 5.5) {
	 document.write('<scr' + 'ipt src="' +_editor_url+ 'editor.js"');
	 document.write(' language="Javascript1.2"></scr' + 'ipt>');  
} else { document.write('<scr'+'ipt>function editor_generate() { return false; }</scr'+'ipt>'); }

browserName = navigator.appName; 
browserVer = parseInt(navigator.appVersion); 

ns3up = (browserName == "Netscape" && browserVer >= 3); 
ie4up = (browserName.indexOf("Microsoft") >= 0 && browserVer >= 4); 