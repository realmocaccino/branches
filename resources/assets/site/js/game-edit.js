var game_edit = {
	
	elements: {
		form: '#form-game-edit',
		release: '#form-game-edit-release',
		modesContainer: '#form-game-edit-modes',
		errorMessages: '.help-block',
	},
	
	start: function() {
	    game_edit.events();
	    
		if(document.querySelector(game_edit.elements.form)) {
			game_edit.checkModesMessage();
			game_edit.maskRelease();
		}
	},
	
	events: function() {},
	
	maskRelease: function() {
		document.querySelector(game_edit.elements.release).MaskIt('00/00/0000');
	},
	
	checkModesMessage: function() {
		if($(game_edit.elements.modesContainer + ' ' + game_edit.elements.errorMessages).length > 0) {
			location.hash = game_edit.elements.modesContainer;
		}
	}
	
};
