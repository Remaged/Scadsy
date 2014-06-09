$('.sc-attendance .row .header').click(function() {
	triggerHeader($(this));
});

function triggerHeader(header) {
	var row = header.parent();
	if(row.hasClass('active')) {
		row.removeClass('active').addClass('inactive');
		row.find('.content').slideUp(400, function() {
			onResize();
		}).html('');
	} else {
		row.removeClass('inactive').addClass('active');
		var data_url = row.attr('data-url');
		$.get(data_url, function(data) {
			row.find('.content').append(data).slideDown(400, function() {
				onResize();
			});
		});
	}		
}

$(document).on( "submit", ".attendance-today-form", function() {
	var target = document.getElementById("sc-right-box");
	var spinner = new Spinner().spin(target);
	var form = $(this);
	var header = $(this).closest('.row').find('.header');
	var action = form.attr('action');
	
	var values = form.serializeArray();

	values = values.concat(form.find('input[type=checkbox]:not(:checked)').map(
			function() {
				return {"name": this.name, "value": 'no'};
			}).get()
	);

	$.post(action, values, function(data) {
		triggerHeader(header);
		spinner.stop();
	});
	
	return false;
});
