function selectAll() {
	$('.checkBoxJs').prop( "checked", true );
	//$( "#.." ).prop( "checked", true );
	$('#checkBoxSelect').text('Deselecteer alles');
	$('#checkBoxSelect').attr('onclick','deselectAll()');
}

function deselectAll() {
	$('.checkBoxJs').prop( "checked", false );
	$('#checkBoxSelect').text('Selecteer alles');
	$('#checkBoxSelect').attr('onclick','selectAll()');
	// $( "#.." ).prop( "checked", true );
}