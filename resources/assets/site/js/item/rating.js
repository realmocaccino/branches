var item_rating = {
	
	auxiliaries: {},
	
	elements: {
		item: '.item-rating'
	},
	
	start: function() {
		item_rating.events();
	},
	
	events: function() {},
	
	update: function(id, item) {
		var element = item_rating.elements.item + '-' + id;
		
		if($(element).length) {
			$(element).replaceWith(item);
			$(element + ' ' + score.elements.scores).each(score.create);
			$(element + ' ' + chart.elements.charts).each(chart.create);
		}
	},
	
	delete: function(id) {
		var element = item_rating.elements.item + '-' + id;
		
		if($(element).length) {
			$(element).parent().fadeOut('fast', function() {
				$(this).remove();
			});
		}
	}
	
};