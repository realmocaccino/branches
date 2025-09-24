var ajax = {

	auxiliaries: {},

	elements: {
		button: '.ajax',
	},
	
	start: function() {
		ajax.events();
	},
	
	events: function() {
		$('body').on('click', ajax.elements.button, function(event) {
			event.preventDefault();
			
			ajax.send($(this).attr('href'));
		});
	},
	
	send: function(url, data, callback) {
	    loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: url,
				data: data,
				success: function(response) {
				    if(globals.isLoginPage(response)) {
				        globals.resendPostLogin = [url, data, callback];
				        
				        loading.hide('fast', function() {
				            dialog.openWithContent(response);
				        });
				    } else {
				        loading.hide('fast', function() {
						    callback(response);
					    });
				    }
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						alert.create('warning', errorThrown);
					});
				}
			});
		});
	}
	
};