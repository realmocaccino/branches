var slider = {
	
	elements: {
		item: '.splide'
	},

	start: function() {
		$(slider.elements.item).each(slider.create);
		
		slider.events();
	},
	
	events: function() {},
	
	create: function() {
		new Splide(this, {
			type: 'loop',
			gap: 40,
			speed: 800,
			easing: 'ease',
			lazyLoad: 'nearby',
			flickPower: 285,
			dragMinThreshold: {
				mouse: 0,
				touch: 15
			},
			perPage: $(this).data('perPage'),
			breakpoints: $(this).data('breakpoints')
		}).mount();
	}
	
};