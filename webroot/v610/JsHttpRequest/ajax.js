// JavaScript Document
function AJAX() {
	this.url = null;
	this.request = null;
	this.xml = null;
	
if (window.XMLHttpRequest) {
//IE7, Mozilla, Safari
this.request = new XMLHttpRequest();
//this.request.overrideMimeType('text/xml');
} else {
if (window.ActiveXObject) {
//IE5.5, IE6
this.request = new ActiveXObject("Microsoft.XMLHTTP");
} else {
this.request = false;
alert("Your browser doesn\'t support AJAX");
}
}
			
	/*
	if(window.XMLHttpRequest) {
		this.request = new XMLHttpRequest();
		this.request.overrideMimeType('text/xml');
	} else {
		if (window.ActiveXObject) {
			this.request = new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	*/
}

AJAX.prototype.Open = function(method, url, asynchronous) {
	this.url = url;
	this.request.open(method, url, asynchronous);
}

AJAX.prototype.SetContentType = function(ContentType) {
	this.request.setRequestHeader("Content-Type", ContentType);
}

AJAX.prototype.SetRequestHeader = function(Type, Content) {
	this.request.setRequestHeader(Type, Content);
}

AJAX.prototype.Send = function(text) {
	this.request.send(text);
}

AJAX.prototype.OnStateChange = function(func, divID) {
	var request = this.Request();
	this.request.onreadystatechange = function() {
		if (request.readyState == 4) {
			if (request.status == 200) {
				func(request, divID);
			} else {
				alert("Error returned status code: " + request.status + " " + request.statusText);
			}
		}
	}
}

AJAX.prototype.Request = function() {
	return this.request;
}

AJAX.prototype.ReadyState = function() {
	return this.request.readyState;
}

AJAX.prototype.Status = function() {
	return this.request.status;
}

AJAX.prototype.ResponseText = function() {
	return this.request.responseText;
}

AJAX.prototype.ResponseXML = function() {
	return this.request.responseXML;
}

AJAX.prototype.getAllResponseHeaders = function() {
	return this.request.getAllResponseHeaders();
}

AJAX.prototype.getXML = function() {
	if (window.ActiveXObject)
		this.xml = new ActiveXObject("Microsoft.XMLDOM");
	else
		this.xml = document.implementation.createDocument("", "", null);		
	
}