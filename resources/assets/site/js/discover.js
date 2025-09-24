var discover = {

	auxiliaries: {},

	elements: {
		container: '#discover',
		form: '#discover-form',
		select: '#discover-select'
	},

	start: function() {
		discover.events();
	},

	events: function() {
		$(discover.elements.select).on('select2:select select2:unselect', discover.reload);
	},
	
	reload: function(ev) {
		$(discover.elements.form).submit();
	},

};