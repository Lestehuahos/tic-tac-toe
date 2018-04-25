/* Отсчёт оставшегося времени для хода */
/*$.ajax({}
	
	type: 'POST',
	url: '/room/connect',
	data: 'name=John&time=2pm',
	dataType: 'text',
	success: function ($answer) {
		$('$result').text(answer);
	}

});
*/

/* AJAX-функция таймаута */					
function countdown() {

	var xmlHttp;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		xmlHttp = new XMLHttpRequest();

	} else if (window.ActiveXObject) { // IE 8 and older
		xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

	}
	else{
		//alert('Ошибка');
	}
	//var data = "query_id=" + 92;
    xmlHttp.open("POST", "/countdown.php", true); 
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
    xmlHttp.send();
	xmlHttp.onreadystatechange = display_data;
	function display_data() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
			
				if(xmlHttp.responseText == 'success') {
					location="/main";
				}
				else {
					document.getElementById("timer").innerHTML = xmlHttp.responseText;	
				}
			} 
		}
	}
}