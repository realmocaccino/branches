var multiple_select = {

	elements: {
		selects: 'select[multiple], select.transform',
		reloadSelects: '.select-reload'
	},
	
	start: function() {
		$(multiple_select.elements.selects).each(function() {
			multiple_select.transform(this);
		});
		
		$(document).trigger('multipleSelectsTranformed');
		
		multiple_select.events();
	},
	
	events: function() {
	    $('body').on('change', multiple_select.elements.reloadSelects, multiple_select.reload);
	},
	
	transform: function(select) {
		var firstOption = $(select).children().first();
		
		$(select).select2({
			minimumResultsForSearch: Infinity
		});
		
		if(firstOption.is(':disabled')) firstOption.remove();
		
		var select2container = $(select).next();
		
		var input = $(select2container).find('.select2-search__field');
		/*if(!input.attr('placeholder')) input.css('width', '100%').attr('placeholder', input.parents('.select2-container').prev().data('placeholder'));*/

		$(select2container).find('.select2-selection__rendered').removeAttr('title');
		$(select2container).find('.select2-selection__choice').hide();
	},
	
	reload: function() {
		var url = window.location.href;
		var newYear = $(this).val(); // Replace with the desired new year

		// Create a new URL object
		var parsedUrl = new URL(url);

		// Update the path to replace the year
		parsedUrl.pathname = parsedUrl.pathname.replace(/\/\d{4}$/, '/' + newYear);

		// Update or append the year in the query string
		if (parsedUrl.searchParams.get('year')) {
			parsedUrl.searchParams.set('year', newYear);
		} else {
			parsedUrl.searchParams.append('year', newYear);
		}

		// Remove the page query string
		parsedUrl.searchParams.delete('page');

		// Append the year to the end of the URL if it doesn't exist in the path
		if (!parsedUrl.pathname.includes(newYear)) {
			parsedUrl.pathname += '/' + newYear;
		}

		// Get the modified URL
		window.location.href = parsedUrl.href;
	}
};