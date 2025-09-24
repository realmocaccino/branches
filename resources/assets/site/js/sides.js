var sides = {

	auxiliaries: {
		animationSpeed: 150,
		currentSideOpened: null,
		previousSidePosition: null,
		sideOpened: false
	},

	elements: {
		sides: {
			site: {
				direction: 'left',
				container: '#mobile-side-site'
			},
			user: {
				direction: 'right',
				container: '#mobile-side-user'
			}
		}
	},

	start: function() {
		sides.events();
	},
	
	events: function() {
		$('body').on('click', header.elements.mobileMenuButtonContainer, function(event) {
			sides.show(sides.elements.sides.site, event);
		});
		$('body').on('click', header.elements.userPicture, function(event) {
			if(window.innerWidth <= 991) sides.show(sides.elements.sides.user, event);
		});
		$('body').on('click', overlay.elements.overlay, function(event) {
			if(sides.auxiliaries.currentSideOpened) sides.hide(event);
		});
		if(isMobile.phone) {
			$(sides.elements.sides.site.container).swipe({
				swipeLeft: function(event) {
					sides.hide(event);
				}
			});
			$(sides.elements.sides.user.container).swipe({
				swipeRight: function(event) {
					sides.hide(event);
				}
			});
			$(overlay.elements.overlay).swipe({
				swipeStatus: function(event, phase, direction) {
					if(phase == 'end' && direction == 'left') {
						if(sides.auxiliaries.currentSideOpened.container == '#mobile-side-site') sides.hide(event);
					} else if(phase == 'end' && direction == 'right') {
						if(sides.auxiliaries.currentSideOpened.container == '#mobile-side-user') sides.hide(event);
					}
				}
			});
		}
	},
	
	show: function(side, event) {
		event.preventDefault();
		
		$(document).trigger('sideOpening');
		
		overlay.show();

		var animateOptions = {};
		animateOptions[side.direction] = 0;
		sides.auxiliaries.previousSidePosition = $(side.container).css(side.direction);
		
		$(side.container).show().animate(animateOptions, sides.auxiliaries.animationSpeed, function() {
			sides.auxiliaries.sideOpened = true;
			sides.auxiliaries.currentSideOpened = side;
			
			$(document).trigger('sideOpened');
		});
	},
	
	hide: function(event) {
		sides.auxiliaries.sideOpened = false;
		
		$(document).trigger('sideClosing');
		
		overlay.hide();
		
		var animateOptions = {};
		animateOptions[sides.auxiliaries.currentSideOpened.direction] = sides.auxiliaries.previousSidePosition;
		sides.auxiliaries.previousSidePosition = null;
		
		$(sides.auxiliaries.currentSideOpened.container).animate(animateOptions, sides.auxiliaries.animationSpeed, function() {
			$(this).hide();
			
			sides.auxiliaries.currentSideOpened = null;
			
			$(document).trigger('sideClosed');
		});
	},
	
	replaceUserContent: function(content) {
		if(content) $(sides.elements.sides.user.container).html(content);
	}
	
};
