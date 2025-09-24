var tooltip = {

	elements: {
		item: '[title]'
	},

	start: function() {
		$(tooltip.elements.item).each(tooltip.create);
	
		tooltip.events();
	},
	
	events: function() {
		$(header_search.elements.results).on('searchCompleted', function() {
			$(header_search.elements.results + ' ' + tooltip.elements.item).each(tooltip.create);
		});
		
		$(document).on('dialogCreated', function() {
			$(dialog.elements.container + ' ' + tooltip.elements.item).each(tooltip.create);
		});
		
		$(document).on('ratingCreated ratingUpdated reviewCreated reviewDeleted', function() {
			$(tooltip.elements.item).each(tooltip.create);
		});
	},
	
	create: function() {
		if(!isMobile.phone || $(this).data('tooltip-mobile')) {
			tippy(this, {
				placement: $(this).data('tippy-placement') || 'top',
				theme: 'light'
			});
		}
	}
	
};