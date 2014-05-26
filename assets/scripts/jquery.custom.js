$(function(){
	
	// If an element has a show attribute, set the hover function
	$('*[show]').hover(function() {
		$show = $( this ).attr("show");
		$($show).show();
	}, function() {
		$show = $( this ).attr("show");
		$($show).hide();
	});
	
	// For the sc-table's, automaticly assign the alternate rows
	$(".sc-table tbody tr").each(function(count) {
		if(count % 2 == 0) {
			$(this).addClass('alternative');
		}
	});

});

// Show notifications
function showNotification($type, $text) {
	var msgBox = $('<div style="display:none;" class="sc-msg sc-msg-'+$type+'">'+$text+'</div>');
	
	if($('.sc-msg').length == 0) {
		$("#sc-page").prepend(msgBox);
	} else {
		$('.sc-msg').last().after(msgBox);
	}
		
	msgBox.fadeIn('slow').delay(5000).fadeOut('slow');
}

// Pause execution
function pauseExec(ms) {
	ms += new Date().getTime();
	while (new Date() < ms){}
} 