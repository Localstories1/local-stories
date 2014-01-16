
function collectionToArray(col) {
	a = new Array();
	for (i = 0; i < col.length; i++)
		a[a.length] = col[i];
	return a;
}
Array.prototype.in_array = function(valeur) {
	for (var i in this) { if (this[i] == valeur) return i;}
	return -1;
}
function addChamps(idForm) {

	monForm=document.getElementById(idForm);
	lst=collectionToArray(monForm.getElementsByTagName('input'));
	lst=lst.concat(collectionToArray(monForm.getElementsByTagName('select')));
	lst=lst.concat(collectionToArray(monForm.getElementsByTagName('textarea')));
	var lstVar=[];
 
	for (i=0;i<lst.length;i++) {

		lstVar[i]=lst[i].value;
	}
	return lstVar;
}
var WebsocketClass = function(host){ 

   this.socket = new WebSocket(host);
   this.console = document.getElementsByClassName('console')[0];
}; 
WebsocketClass.prototype = { 

   initWebsocket : function(){ 

           var $this = this; 

           this.socket.onopen = function(){ 

                   $this.onOpenEvent(this); 
           }; 

           this.socket.onmessage = function(e){ 

                   $this._onMessageEvent(e); 
           }; 

           this.socket.onclose = function(){ 

                   $this._onCloseEvent(); 
           }; 

           this.socket.onerror = function(error){ 

                   $this._onErrorEvent(error); 
           }; 

           this.console.innerHTML = this.console.innerHTML + 'websocket init <br />'; 
   }, 
   _onErrorEvent :function(err){ 

           console.log(err); 
           this.console.innerHTML = this.console.innerHTML + 'websocket error <br />'; 
   }, 
   onOpenEvent : function(socket){ 

           console.log('socket opened'); 
           this.console.innerHTML = this.console.innerHTML + 'socket opened Welcome - status ' + socket.readyState + '<br />'; 
   }, 
   _onMessageEvent : function(e){ 

          e = JSON.parse(e.data); 
	 var newArr = JSON.parse(e.msg);

	contentMessage.innerHTML = "";

	var uid="";
	var desc="";
	var img="";

	while (newArr.length > 0) {
	
		var arr=newArr.pop();
		uid=arr[i][0];
		desc=arr[i][1];
		img=arr[i][2];
		contentMessage.innerHTML += "<img src=\""+img+"\" /><input type=\"text\" value=\""+desc+"\" id=\""+uid+"\" name=\""+uid+"\" /><br />";
	}
	this.console.innerHTML = this.console.innerHTML + 'message event lanched <br />'; 
   }, 
   _onCloseEvent : function(){ 

           console.log('connection closed'); 

           this.console.innerHTML = this.console.innerHTML + 'websocket closed - server not running<br />'; 
   }, 
   sendMessage : function(){ 
	  
           var message = JSON.stringify(addChamps('request_a_service')); 

           this.socket.send(message); 

           this.console.innerHTML = this.console.innerHTML + 'websocket message send <br />'; 

   } 
}; 

var uId = 'nico'; /* pseudo de l'utilisateur*/ 
var button = document.getElementById('send_quote'); /* bouton d'envoi du message */
var contentMessage = document.getElementById('suppliers'); /* content */    
var socket = new WebsocketClass('ws://localhost:11345/serveur.php'); /* on instancie un objet WebsocketClass avec l'URL en paramètre */ 

if(button.addEventListener){ 

   button.addEventListener('click',function(e){ /* on écoute l'évènement 'click' sur le bouton permettant d'envoyer le message */ 

           e.preventDefault(); 

           socket.sendMessage(); /* on envoie un message vers le serveur*/ 

           return false; 

   }, true); 

} else{ 

   console.log('votre navigateur n\'accepte pas le addevenlistener'); 

}

