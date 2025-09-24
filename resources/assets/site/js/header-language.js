var header_language = {

	auxiliaries: {},

	elements: {
	    container: '#header-language',
		span: '#header-language span',
		menu: '#header-language-menu'
	},

	start: function() {
		header_language.events();
	},

	events: function() {
		$(document).on('click', ':not(' + header_language.elements.container + ' *)', header_language.hideMenu);
		$(header_language.elements.span).on('click', header_language.toggleMenu);
	},
	
	toggleMenu: function() {
		$(header_language.elements.menu).slideToggle('fast');
	},
	
	showMenu: function() {
		$(header_language.elements.menu).slideDown('fast');
	},
	
	hideMenu: function() {
		$(header_language.elements.menu).slideUp('fast');
	},

};