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
