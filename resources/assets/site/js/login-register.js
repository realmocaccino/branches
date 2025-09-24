var login_register = {

	elements: {},
	
	start: function() {
		login.start();
		register.start();
		tabs.start();
	}

};

var login = {
	
	elements: {
		errorContainer: '#login-register-error-login',
		form: '#form-login',
		formEmail: '#form-login-email',
		formPassword: '#form-login-password'
	},
	
	start: function() {
		$(document).on('dialogCreated', login.events);
	},
	
	events: function() {
		$(login.elements.form).on('submit', login.sendRequest);
	},
	
	sendRequest: function(event) {
		event.preventDefault();

		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(login.elements.form).data('ajax-url'),
				data: {
					email: $(login.elements.formEmail).val(),
					password: $(login.elements.formPassword).val()
				},
				success: function(response) {
					loading.hide('fast', function() {
						if(response.error) {
							$(login.elements.errorContainer).text(response.error).fadeIn('fast');
						} else {
							dialog.close(function() {
								header.replaceUserPicture(response.header_user);
								if(isMobile.phone) sides.replaceUserContent(response.side_user);
							});
							if(globals.resendPostLogin.length) {
							    ajax.send(
							        globals.resendPostLogin[0],
							        globals.resendPostLogin[1],
							        globals.resendPostLogin[2]
							    );
							    
							    globals.resendPostLogin = [];
							} else {
							    $.ajax({
								    type: 'POST',
								    url: document.location.origin + '/ajax/redirect',
								    success: function(response) {
									    if(response) dialog.open(document.location.origin + response);
								    },
								    error: function(XMLHttpRequest, textStatus, errorThrown) {
									    alert.create('danger', 'Algo deu errado');
								    }
							    });
							}
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						var errors = JSON.parse(XMLHttpRequest.responseText).errors;
						var firstMessage = errors[Object.keys(errors)[0]];
						
						$(login.elements.errorContainer).text(firstMessage).fadeIn('fast');
					});
				}
			});
		});
	}
	
};

var register = {
	
	elements: {
		errorContainer: '#login-register-error-register',
		form: '#form-register',
		formName: '#form-register-name',
		formEmail: '#form-register-email',
		formPassword: '#form-register-password',
		formTerms: '#form-register-terms',
		formFax: '#form-register-fax input'
	},
	
	start: function() {
		$(document).on('dialogCreated', register.events);
	},
	
	events: function() {
		$(register.elements.form).on('submit', register.sendRequest);
	},
	
	sendRequest: function(event) {
		event.preventDefault();
	
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(register.elements.form).data('ajax-url'),
				data: {
					name: $(register.elements.formName).val(),
					email: $(register.elements.formEmail).val(),
					password: $(register.elements.formPassword).val(),
					terms: $(register.elements.formTerms).val(),
					fax: $(register.elements.formFax).val()
				},
				success: function(response) {
					loading.hide('fast', function() {
						if(response.error) {
							$(register.elements.errorContainer).text(response.error).fadeIn('fast');
						} else {
							dialog.close(function() {
								alert.create('info', response.message, false);
							});
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						var errors = JSON.parse(XMLHttpRequest.responseText).errors;
						var firstMessage = errors[Object.keys(errors)[0]];
						
						$(register.elements.errorContainer).text(firstMessage).fadeIn('fast');
					});
				}
			});
		});
	}
	
};

var tabs = {
	
	elements: {
		container: '#login-register-tab',
		buttons: '#login-register-tabs-buttons li',
		contents: '#login-register-tabs-contents li',
		activeClass: 'active'
	},
	
	start: function() {
		tabs.events();
	},
	
	events: function() {
		$(document).on('click', tabs.elements.buttons, function(ev) {
			ev.preventDefault();
			
			tabs.hide();
			tabs.show(ev.target);
		});
	},
	
	hide: function() {
		$(tabs.elements.buttons).removeClass(tabs.elements.activeClass);
		$(tabs.elements.contents).hide();
	},
	
	show: function(button) {
		$(button).addClass(tabs.elements.activeClass);
		$(tabs.elements.contents).eq($(button).index()).show();
	}
	
};