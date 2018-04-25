/* Отсчёт оставшегося времени для хода */
$.ajax({}
	
	type: 'POST',
	url: '/index.php',
	data: 'name=John&time=2pm',
	dataType: 'text',
	success: function ($answer) {
		$('$result').text(answer);
	}

});