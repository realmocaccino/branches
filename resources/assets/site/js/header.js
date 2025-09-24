var header = {

	auxiliaries: {
		withoutBorderClassName: 'header-withoutBorder',
	    withShadowClassName: 'header-withShadow',
		noShadowClassName: 'header-withoutShadow',
		searchMobileView: 'search-mobile-view',
		userTooltipTimer: null
	},

	elements: {
		container: '#header',
		mobileMenuButtonContainer: '#header-menu-mobile',
		brandContainer: '#header-brand',
		menuContainer: '#header-menu',
		searchContainer: '#header-search',
		mobileSearchButtonContainer: '#header-search-mobile-button-container',
		mobileSearchButton: '#header-search-mobile-button',
		userContainer: '#header-user',
		userIcon: '#header-user-icon',
		userPicture: '#header-user-picture',
		userTooltip: '#header-user-tooltip'
	},

	start: function() {
		header.events();
	},

	events: function() {
		$(header.elements.userContainer).on({
			mouseenter: function() {
				header.showUserTooltip();
				
				clearInterval(header.auxiliaries.userTooltipTimer);
			},
			mouseleave: function() {
				header.auxiliaries.userTooltipTimer = setTimeout(function() { header.hideUserTooltip() }, 50);
			}
		}, [header.elements.userIcon, header.elements.userPicture, header.elements.userTooltip].join(', '));
	
		$([header.elements.userIcon, header.elements.userPicture, header.elements.userTooltip].join(', ')).click(function() {
			setTimeout(function() { header.hideUserTooltip() }, 50);
		});
		
		$(header.elements.mobileSearchButtonContainer).on('click', header.toggleMobileSearchView);
		
		$(window).scroll(header.handleBorderAndShadow);
	},

	handleBorderAndShadow: function() {
	    if($(header.elements.container).offset().top > 0) {
	        $(header.elements.container).addClass(header.auxiliaries.withoutBorderClassName).addClass(header.auxiliaries.withShadowClassName);
	    } else {
	        $(header.elements.container).removeClass(header.auxiliaries.withoutBorderClassName).removeClass(header.auxiliaries.withShadowClassName);
	    }
	},
	
	addShadow: function() {
		$(header.elements.container).removeClass(header.auxiliaries.noShadowClassName);
	},
	
	removeShadow: function() {
		$(header.elements.container).addClass(header.auxiliaries.noShadowClassName);
	},
	
	showUserTooltip: function() {
		if(window.innerWidth > 991) $(header.elements.userTooltip).stop().fadeIn('fast');
	},
	
	hideUserTooltip: function() {
		if(window.innerWidth > 991) $(header.elements.userTooltip).stop().fadeOut('fast');
	},
	
	replaceUserPicture: function(content) {
		if(content) {
			$(header.elements.userContainer).fadeOut('fast', function() {
				$(this).html(content).fadeIn('slow');
			});
		}
	},
	
	toggleMobileSearchView: function() {
	    $([header.elements.mobileMenuButtonContainer, header.elements.brandContainer, header.elements.mobileSearchButtonContainer, header.elements.menuContainer, header.elements.userContainer, header.elements.searchContainer, header_search.elements.submit, header_search.elements.reset].join(', ')).toggleClass(header.auxiliaries.searchMobileView);
	    $(header_search.elements.field).focus();
	}
	
};