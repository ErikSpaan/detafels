function maxLengthCheck(object) {
	if (object.value.length > object.maxLength)
	  object.value = object.value.slice(0, object.maxLength)
  }
  
function message() {
	$('#message').fadeOut();  
}
  
$(function() {
	total = $('.faultsJs').length;
	$('#button2').attr('value', 'Toevoegen ('+total+')');
});


function showSums() {
	var totalFaults = 0;
	var totalTimeExceed = 0;
	var sums = 0;
	checkboxFault = $('#checkboxFaultJs').is(':checked');
	checkboxTime = $('#checkboxTimeJs').is(':checked');
	if ( checkboxFault == true && checkboxTime == false ) {
		// $('.faultsJs').each(function(index, value){
		$('.faultsJs').each(function(){
			if( $(this).text() > 0 ) {
				totalFaults++;
			}
		});
		sums+= totalFaults;
	}
	if ( checkboxTime == true && checkboxFault == false ) {
		timeFrame = $('#timeFrameJs').val();
		// $('.timeJs').each(function(index, value){
		$('.timeJs').each(function(){
			if( parseInt($(this).text()) >= timeFrame ) {
				totalTimeExceed++;
			}
		});
		sums+= totalTimeExceed;
	}
	if ( checkboxFault == false && checkboxTime == false ) {
		sums += total;
	}
	if ( checkboxFault == true && checkboxTime == true ) {
		timeFrame = $('#timeFrameJs').val();
		$('.timeJs').each(function(index, value){
			if( parseInt($(value).text()) >= timeFrame ) {
				totalTimeExceed++;
			} else if ( $('.faultsJs:eq('+index+')').text() > 0 )  {
				totalTimeExceed++;
			} 	
		});
		sums = totalTimeExceed;
	}
	$('#button2').attr('value', 'Toevoegen ('+sums+')');
}

function seconds(time) {
	timeFrame = parseInt($('#timeFrameJs').val());
	if ( timeFrame > 0 && time == -1 ) {
		timeFrame -= 1;
		$('#timeFrameJs').val(timeFrame);
	} else if ( time == 1 && timeFrame < 1000 ) {
		timeFrame += 1;
		$('#timeFrameJs').val(timeFrame);
	}
	showSums();
}