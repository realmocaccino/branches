var scrolling = {

	elements: {
		body: 'body'
	},

	start: function() {
		scrolling.events();
	},
	
	events: function() {
		$(document).on('dialogOpened sideOpening', scrolling.disable);
		$(document).on('dialogClosing sideClosing', scrolling.enable);
	},
	
	enable: function() {
		if(!sides.auxiliaries.sideOpened) $(scrolling.elements.body).css('overflow', 'auto');
	},

	disable: function() {
		$(scrolling.elements.body).width($(scrolling.elements.body).width()).css('overflow', 'hidden');
		$(header.elements.container).width($(scrolling.elements.body).width());
	}

};
