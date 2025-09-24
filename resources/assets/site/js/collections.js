var collections = {

	elements: {
	    container: '#game-buttons-collections',
		button: '#game-buttons-collections-plus',
	    tooltip: '#game-buttons-collections-tooltip',
	    buttons: '.game-buttons-collections-tooltip-button',
	    createCollectionForm: '#game-buttons-collections-tooltip-createCollectionForm',
	    totalCollectionsChecked: '#game-buttons-collections-totalCollectionsChecked'
	},

	start: function() {
		collections.events();
		
		if($(collections.elements.button).length) collections.checkButton();
	},
	
	events: function() {
		$(collections.elements.container).on('click', collections.elements.buttons, collections.attachOrRemoveRequest);
		$(collections.elements.container).on('submit', collections.elements.createCollectionForm, collections.createCollectionRequest);
	},
	
	attachOrRemoveRequest: function(event) {
	    event.preventDefault();

		if($(event.target).data('ajax-url')) ajax.send($(event.target).data('ajax-url'), {}, collections.updateButtons);
	},

	checkButton: function() {
	    if($(collections.elements.totalCollectionsChecked).data('value')) {
	        $(collections.elements.button + ' em').removeClass('fa-plus').addClass('fa-check');
	    } else {
	        $(collections.elements.button + ' em').removeClass('fa-check').addClass('fa-plus');
	    }
	},
	
	createCollectionRequest: function(event) {
	    event.preventDefault();
	    
	    if($(event.target).data('ajax-url')) ajax.send($(event.target).data('ajax-url'), $(event.target).serializeArray(), collections.updateButtons);
	},
	
	openPremiumDialog: function(content) {
	    dialog.openWithContent(content, isMobile.phone ? '90%' : 524, 600);    
	},

	updateButtons: function(response) {
	    if(response.success) {
	        alert.create(!response.error ? 'info' : 'warning', response.message);

	        if(response.success) {
                $(collections.elements.tooltip).html(response.content);
		    } else if(response.error) {
			    switch(response.error) {}
		    }

		    collections.checkButton();

			if(response.isCustom || isMobile.phone) {
				$(document).trigger('openDropdown', collections.elements.button);
			} else {
				$(document).trigger('positionDropdown', collections.elements.button);
			}
		} else {
		    collections.openPremiumDialog(response);
		}
	},

};