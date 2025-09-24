var overlay = {

	auxiliaries: {
		headerOverlayOpened: false,
		wrapperOverlayOpened: false
	},

	elements: {
		overlay: '#header-overlay, #wrapper-overlay',
		headerOverlay: '#header-overlay',
		wrapperOverlay: '#wrapper-overlay'
	},

	start: function() {},
	
	events: function() {},
	
	show: function(callback) {
		overlay.showHeaderOverlay();
		overlay.showWrapperOverlay(callback);
	},
	
	hide: function(callback) {
		overlay.hideHeaderOverlay();
		overlay.hideWrapperOverlay(callback);
	},
	
	showHeaderOverlay: function(callback) {
		if(!overlay.auxiliaries.headerOverlayOpened) {
			header.removeShadow();
			$(overlay.elements.headerOverlay).fadeIn('fast', function() {
				overlay.auxiliaries.headerOverlayOpened = true;
				if(callback) callback();
			});
		}
	},
	
	hideHeaderOverlay: function(callback) {
		if(overlay.auxiliaries.headerOverlayOpened) {
			if(!sides.auxiliaries.sideOpened) {
				$(overlay.elements.headerOverlay).fadeOut('fast', function(){
					header.addShadow();
					overlay.auxiliaries.headerOverlayOpened = false;
					if(callback) callback();
				});
			} else {
				if(callback) callback();
			}
		}
	},
	
	showWrapperOverlay: function(callback) {
		if(!overlay.auxiliaries.wrapperOverlayOpened) {
			$(overlay.elements.wrapperOverlay).fadeIn('fast', function() {
				overlay.auxiliaries.wrapperOverlayOpened = true;
				if(callback) callback();
			});
		}
	},
	
	hideWrapperOverlay: function(callback) {
		if(overlay.auxiliaries.wrapperOverlayOpened) {
			if(!sides.auxiliaries.sideOpened) {
				$(overlay.elements.wrapperOverlay).fadeOut('fast', function(){
					overlay.auxiliaries.wrapperOverlayOpened = false;
					if(callback) callback();
				});
			} else {
				if(callback) callback();
			}
		}
	}

};