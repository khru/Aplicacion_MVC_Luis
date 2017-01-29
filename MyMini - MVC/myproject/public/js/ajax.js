/* Autor: Luis Cavero Martínez */

/* CONSTANTS =============================*/

//Request state
var READY_STATE_UNINITIALIZED = 0;
var READY_STATE_LOADING = 1;
var READY_STATE_LOADED = 2;
var READY_STATE_INTERACTIVE = 3;
var READY_STATE_COMPLETE = 4;

//Default Server AJAX-Responses url
var defaultServerUrl = "http://192.168.33.44/ajax.php";

/* AJAX UTILITIES ========================*/

//Obtains the request object
function getRequest() {
	if(window.XMLHttpRequest) {
		return new XMLHttpRequest();
	} else if(window.ActiveXObject) {
		return new ActiveXObject("Microsoft.XMLHTTP");
	} else {
		alert("Tu navegador no soporta AJAX"); 
	}
}//getRequest

//Send an AJAX request
function sendRequest(method, ajaxFunct, serverFunct, input) {
	//Basic debug
	var method = method || '';
	var ajaxFunct = ajaxFunct || '';
	var serverFunct = serverFunct || '';
	var input = input || '';

	var sendData = null;
	request = getRequest();

	//The url includes all data
	if(method == 'GET'){
		var url = defaultServerUrl + "?function=" + serverFunct;
		//If form, multiple inputs
		if(input.tagName == 'FORM'){
			for(var i=0; i<input.length; i++){
				if(input[i].type != "submit"){
					url += "&" + input[i].name + "=" + input[i].value;
				}	
			}
		}else{
			//Not form, just one input
			url += "&" + input.name + "=" + input.value;
		}
		
	//Data are sent by request.send
	}else if(method == 'POST'){

		var url = defaultServerUrl;
		//If form, multiple inputs
		if(input.tagName == 'FORM'){
			sendData  = "function=" + encodeURIComponent(serverFunct);
			sendData += "&nocache=" + Math.random();
			for(var i=0; i<input.length; i++){
				if(input[i].type != "submit"){
						sendData += "&" + input[i].name + "=" + encodeURIComponent(input[i].value);
				}
			}	
		//Not form, just one input
		}else{
			sendData  = "function=" + encodeURIComponent(serverFunct);
			sendData += "&nocache=" + Math.random();
			sendData += "&" + input.name + "=" + encodeURIComponent(input.value);
		}

	}else{
		alert('No se permite ese método de envío de datos');
	}
	
	//Request procedures
	if(request){
		request.onreadystatechange = ajaxFunct;
	    request.open(method, url, true);
	    //Post headers
	    if(method == 'POST'){
	    	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	    }
	    request.send(sendData);
	}
}//sendRequest

/* STATE-CHANGE FUNCTIONS ========================*/

//Checks the nick availability
function checkLogin() {
	//Display containers
	var nickChecked = document.getElementById('checkUsuario');
	var msgNickChecked = document.getElementById('msgCheckUsuario');

	if(request.readyState == READY_STATE_COMPLETE) {	    
	    if(request.status == 200) {
	    	var text = "";
	    	var msg = "";
	    	//Remove the previous response (if exists)
	    	if(nickChecked.innerHTML){
	    		nickChecked.innerHTML = text;
	    	}

	    	if(msgNickChecked.innerHTML){
	    		msgNickChecked.innerHTML = msg;
	    	}
	    	switch(request.responseText){
	    		//Server response with styles
	    		case "-1": msg = "<span style='color:red; font-weight:bold'>No se ha recibido el usuario</span>"; 
	    			text = "<span style='color:red'>×<span>"; break;
	    		case  "0": msg = ""; text = "<span style='color:green'>✓<span>"; break;
	    		case  "1": msg = "<span style='color:red; font-weight:bold'>No existe un usuario con ese email</span>"; 
	    			text = "<span style='color:red'>×<span>"; break;
	    		case  "2": msg = "<span style='color:red; font-weight:bold'>No existe un usuario con ese nick</span>"; 
	    			text = "<span style='color:red'>×<span>"; break;
	    	}
	    	//Display response
	    	nickChecked.innerHTML = text;
	    	msgNickChecked.innerHTML = msg;
	    } else {
	    	alert("Ha habido un error, inténtelo más tarde");
	    }
	}
}//checkNick

/* INIT ========================*/

//The main function
function init() {
	

}//init

//All start here
window.onload = init;