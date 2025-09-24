var awards = {

	elements: {
		container: '#awards',
		yearSelect: '#awards-yearSelect',
	},

	start: function() {
		awards.events();
	},
	
	events: function() {
	    $(awards.elements.yearSelect).change(awards.changeYear);
	},
	
	changeYear: function() {
		window.location = window.location.href.replace(/\/[^\/]*$/, '/' + this.value);
	}

};
