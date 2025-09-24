var dialog = {

	auxiliaries: {
		hashName: 'dialog',
		biggerThanScreenClassName: 'dialogBiggerThanScreen',
		lastURL: null
	},

	elements: {
		button: '.dialog',
		container: '#dialog',
		content: '#dialog-content',
		form: '.dialog_ajax',
		closeButton: '.dialog-close',
		ads: '.adsbygoogle.adsbygoogle-noablate'
	},
	
	start: function() {
		dialog.events();
	},
	
	events: function() {
		$('body').on('click', dialog.elements.button, function(event) {
			event.preventDefault();
			
			dialog.open($(this).data('ajax-url') || $(this).attr('href'));
		});
		
		$('body').on('click', [overlay.elements.overlay, dialog.elements.closeButton].join(', '), function(event) {
			if(!$(event.target).hasClass('dialog-close') || $(event.target).parents(dialog.elements.container).length) {
				event.preventDefault();
				
				dialog.close();
			}
		});
		
		$('body').on('submit', dialog.elements.form, function(event) {
			event.preventDefault();
			
			dialog.send();
		});
		
		$('body').keyup(dialog.closeWhenEscKeyIsPressed);
		
		$(window).on('hashchange', dialog.closeWhenDialogHashIsGone);
	},
	
	addDialogHash: function() {
		window.location.hash = dialog.auxiliaries.hashName;
	},
	
	closeWhenEscKeyIsPressed: function(event) {
		if(event.keyCode == 27) dialog.close();
	},
	
	closeWhenDialogHashIsGone: function(event) {
		var oldURL = event.originalEvent.oldURL;
		var oldHash = oldURL.split('#')[1] || null;
		
		if(oldHash == dialog.auxiliaries.hashName) dialog.close();
	},
	
	close: function(callback) {
		$(document).trigger('dialogClosing');
		
		$(dialog.elements.container).fadeOut('fast', function() {
			//$(this).remove();
			
			overlay.hide(function() {
				if(callback) callback();
				
				$(document).trigger('dialogClosed');
			});
		});
	},
	
	open: function(page, width, height) {
		dialog.prioritizeDialogOverAds();

		if(page != dialog.auxiliaries.lastURL) {
		    dialog.createContainerThenOpen(page, width, height);
		} else {
		    dialog.openWithPreviousContainer();
		}
		
		dialog.auxiliaries.lastURL = page;
	},
	
	openWithContent: function(content, width, height) {
	    $(document).trigger('dialogCreating');

		loading.show('fast', function() {
		    dialog.appendDialogToTheBody();
		    
			if(width) $(dialog.elements.container).css('width', width);
			if(height) $(dialog.elements.container).css('height', height);

			$(dialog.elements.content).html(content);
		    $(document).trigger('dialogCreated');

	        loading.hide('fast', function() {
		        dialog.showDialog();
	        });
		});
	},
	
	createContainerThenOpen: function(page, width, height) {
	    $(document).trigger('dialogCreating');
	    
		loading.show('fast', function() {
		    dialog.appendDialogToTheBody();
		    
			if(width) $(dialog.elements.container).css('width', width);
			if(height) $(dialog.elements.container).css('height', height);

			$(dialog.elements.content).load(page, function(response) {
			    $(document).trigger('dialogCreated');

		        loading.hide('fast', function() {
			        dialog.showDialog();
		        });
		        
		        if(globals.isLoginPage(response)) dialog.auxiliaries.lastURL = '';
			});
		});
	},
	
	openWithPreviousContainer: function() {
	    loading.show('fast', function() {
	        loading.hide('fast', function() {
		        dialog.showDialog();
	        });
	    });
	},
	
	showDialog: function() {
	    $(document).trigger('dialogOpening');
	    
	    overlay.show();
        dialog.addDialogHash();
        
        $(dialog.elements.container).fadeIn('fast', function() {
	        if(!isMobile.phone) {
		        $(dialog.elements.container).css('margin-left', -($(this).outerWidth() / 2));
		        
		        if($(dialog.elements.container).outerHeight() < $(window).height()) {
			        $(dialog.elements.container).css('margin-top', -($(this).outerHeight() / 2));
		        } else {
			        $(dialog.elements.container).addClass(dialog.auxiliaries.biggerThanScreenClassName);
		        }
	        }
	        
	        $(document).trigger('dialogOpened');
        });
	},
	
	appendDialogToTheBody: function() {
	    $('body').append('<div id="dialog">' +
							'<a id="dialog-close" class="dialog-close" title="Fechar"></a>' +
							'<div id="dialog-content"></div>' +
						 '</div>');
	},

	prioritizeDialogOverAds: function() {
		setTimeout(function() {
			$(dialog.elements.ads).each(function() {
				$(this).css('z-index', 1);
			});
		}, 2000);
	}
	
};