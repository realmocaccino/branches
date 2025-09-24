var mode = {

    auxiliaries: {
        darkClassName: 'dark',
        lightClassName: 'light'
    },
	
	elements: {
		button: '#header-mode',
        holder: 'body'
	},

	start: function() {
		mode.events();
        mode.handleModeWhenPageIsLoaded();
	},
	
	events: function() {
	    $(document).on('click', mode.elements.button, function(event, element) {
            mode.setMode();
	    });
	},

    handleModeWhenPageIsLoaded: function() {
        savedMode = localStorage.getItem('mode');

        if (savedMode === mode.auxiliaries.darkClassName) {
            mode.setDarkMode();
        } else if (savedMode === mode.auxiliaries.lightClassName) {
            mode.setLightMode();
        }
    },

    isDarkMode: function() {
        return document.querySelector(mode.elements.holder).classList.contains(mode.auxiliaries.darkClassName);
    },

    isLightMode: function() {
        return document.querySelector(mode.elements.holder).classList.contains(mode.auxiliaries.lightClassName);
    },

    setMode: function() {
        if(mode.isDarkMode()) {
			mode.setLightMode();
            mode.saveAsLightMode();
		} else {
			mode.setDarkMode();
            mode.saveAsDarkMode();
		}

        $(document).trigger('modeChanged');
    },

    saveAsDarkMode: function() {
	    localStorage.setItem('mode', mode.auxiliaries.darkClassName);
	},

    saveAsLightMode: function() {
	    localStorage.setItem('mode', mode.auxiliaries.lightClassName);
	},

    setDarkMode: function() {
		document.querySelector(mode.elements.holder).classList.remove(mode.auxiliaries.lightClassName);
        document.querySelector(mode.elements.holder).classList.add(mode.auxiliaries.darkClassName);
    },

    setLightMode: function() {
		document.querySelector(mode.elements.holder).classList.remove(mode.auxiliaries.darkClassName);
        document.querySelector(mode.elements.holder).classList.add(mode.auxiliaries.lightClassName);
    },

};