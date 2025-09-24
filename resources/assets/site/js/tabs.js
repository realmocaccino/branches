var tab = {
	
	elements: {
		item: '.tabs'
	},

	start: function() {
		$(tab.elements.item).each(tab.create);
		
		tab.events();
	},
	
	events: function() {},
	
	create: function() {
		var options = $(this).data('tabs') ? JSON.parse($(this).data('tabs')) : {};

		var instance = $.ionTabs(this, options);
	}
	
};