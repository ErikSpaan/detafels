$(function() {
	var date = new Date();
	var hours = date.getHours();
	if (( hours >= 0 ) && ( hours < 6 )) { 
		greeting = 'Goedenacht' 
	} else if (( hours >= 6 ) && ( hours < 12 )) { 
		greeting = 'Goedemorgen' 
	} else if (( hours >= 12 ) && ( hours < 18 )) { 
		greeting = 'Goedemiddag' 
	} else if (( hours >= 18 ) && ( hours < 24 )) { 
		greeting = 'Goedenavond' 
	}
	$('#greetingJs').text(greeting);
});