window.onload = function() {
	for (var i=0; i<9; i++) {
		document.getElementById('game').innerHTML+='<div class="block" id="' + i + '"></div>';
	}
	
	var hod = 0;
	
	document.getElementById('game').onclick = function(event) {
		console.log(event);
		if (event.target.className == 'block') {
			if(hod%2==0) {
				event.target.innerHTML = 'x';
				var id = event.target.id;
				location.href = "/room/move/"+id;
			}
			else {
				event.target.innerHTML = '0';
				var id = event.target.id;
				location.href = "/room/move/"+id;
			}
			hod++;
			checkWinner();
		}
	}
	
	function checkWinner() {
		var allblock = document.getElementsByClassName('block');
		if (allblock[0].innerHTML=='x' && allblock[1].innerHTML=='x' && allblock[2].innerHTML=='x') alert("Победили крестики!");
		if (allblock[3].innerHTML=='x' && allblock[4].innerHTML=='x' && allblock[5].innerHTML=='x') alert("Победили крестики!");
		if (allblock[6].innerHTML=='x' && allblock[7].innerHTML=='x' && allblock[8].innerHTML=='x') alert("Победили крестики!");
		if (allblock[0].innerHTML=='x' && allblock[3].innerHTML=='x' && allblock[6].innerHTML=='x') alert("Победили крестики!");
		if (allblock[1].innerHTML=='x' && allblock[4].innerHTML=='x' && allblock[7].innerHTML=='x') alert("Победили крестики!");
		if (allblock[2].innerHTML=='x' && allblock[5].innerHTML=='x' && allblock[8].innerHTML=='x') alert("Победили крестики!");
		if (allblock[0].innerHTML=='x' && allblock[4].innerHTML=='x' && allblock[8].innerHTML=='x') alert("Победили крестики!");
		if (allblock[2].innerHTML=='x' && allblock[4].innerHTML=='x' && allblock[6].innerHTML=='x') alert("Победили крестики!");
		//нолики
		if (allblock[0].innerHTML=='0' && allblock[1].innerHTML=='0' && allblock[2].innerHTML=='0') alert("Победили нолики!");
		if (allblock[3].innerHTML=='0' && allblock[4].innerHTML=='0' && allblock[5].innerHTML=='0') alert("Победили нолики!");
		if (allblock[6].innerHTML=='0' && allblock[7].innerHTML=='0' && allblock[8].innerHTML=='0') alert("Победили нолики!");
		if (allblock[0].innerHTML=='0' && allblock[3].innerHTML=='0' && allblock[6].innerHTML=='0') alert("Победили нолики!");
		if (allblock[1].innerHTML=='0' && allblock[4].innerHTML=='0' && allblock[7].innerHTML=='0') alert("Победили нолики!");
		if (allblock[2].innerHTML=='0' && allblock[5].innerHTML=='0' && allblock[8].innerHTML=='0') alert("Победили нолики!");
		if (allblock[0].innerHTML=='0' && allblock[4].innerHTML=='0' && allblock[8].innerHTML=='0') alert("Победили нолики!");
		if (allblock[2].innerHTML=='0' && allblock[4].innerHTML=='0' && allblock[6].innerHTML=='0') alert("Победили нолики!");
		

	}
	
}

/* AJAX-функция таймаута */					
function countdown() {

	var xmlHttp;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		xmlHttp = new XMLHttpRequest();

	} else if (window.ActiveXObject) { // IE 8 and older
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

	}
	else{
		alert('Ошибка');
	}
    xmlHttp.open("POST", "/room/connect", true); 
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
    xmlHttp.send();
	xmlHttp.onreadystatechange = display_data;
	function display_data() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById("timer").innerHTML = xmlHttp.responseText;
			} 
		}
		else {
			//alert("Ошибка");
		}
	}
}


/* AJAX-функция отсчета времени хода */					
function move_countdown() {

	var xmlHttp;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		xmlHttp = new XMLHttpRequest();

	} else if (window.ActiveXObject) { // IE 8 and older
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

	}
	else{
		alert('Ошибка');
	}
    xmlHttp.open("POST", "/room/wait", true); 
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
    xmlHttp.send();
	xmlHttp.onreadystatechange = display_data;
	function display_data() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				document.getElementById("timer_2").innerHTML = xmlHttp.responseText;	
			} 
		}
		else {
			//alert("Ошибка");
		}
	}
}