var header_search = {

	auxiliaries: {
		debounce: 450,
		resultsOpened: false,
		formFocusedClassName: 'form-focused'
	},

	elements: {
		form: '#header-search-form',
		field: '#header-search-input',
		submit: '#header-search-submit',
		loading: '#header-search-loading',
		reset: '#header-search-reset',
		results: '#header-search-results'
	},

	start: function() {
		header_search.events();
	},

	events: function() {
		$(header_search.elements.field).on('keyup', header_search.typing);
		$(header_search.elements.field).on('focus', header_search.focusing);
		$(document).on('click', ':not(' + header_search.elements.form + ', ' + header_search.elements.form + ' *)', header_search.defocusing);
		$(header_search.elements.form).on('submit', header_search.submiting);
		$(header_search.elements.reset).on('click', header_search.reseting);
		$(window).on('resize', header_search.changeContainerWidthAndPositon);
	},
	
	typing: function() {
		if($(header_search.elements.field).val()) {
			debounce.calcular(header_search.sendRequest, header_search.auxiliaries.debounce);
		} else {
			if(isMobile.phone) {
				header_search.hideReset();
				header_search.showSubmit();
			}
			header_search.hideResults(true);
		}
	},
	
	sendRequest: function() {
		if($(header_search.elements.field).val()) {
			header_search.hideReset();
			header_search.hideSubmit();
			header_search.showLoading();
			
			$.ajax({
				type: 'POST',
				url: $(header_search.elements.form).data('ajax-url'),
				data: {
					term: $(header_search.elements.field).val()
				},
				success: function(response) {
					header_search.replaceResultsContent(response);
					header_search.hideLoading();
					header_search.showReset();
					header_search.showSubmit();
					header_search.showResults();
					
					$(header_search.elements.results).trigger('searchCompleted');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					header_search.replaceResultsContent('<li class="header-search-results-error"><p>Algo deu errado</p></li>');
				}
			});
		}
	},
	
	replaceResultsContent: function(content) {
		$(header_search.elements.results).html(content);
	},
	
	hasResults: function() {
	    return $(header_search.elements.results).html() != '';
	},

	hasText: function() {
		return $(header_search.elements.field).val() != '';
	},
	
	showResults: function() {
		header_search.changeContainerWidthAndPositon();
		if(!isMobile.phone) {
			overlay.showHeaderOverlay();
		}
		header_search.focusForm();
		overlay.showWrapperOverlay(function(){
			$(header_search.elements.results).slideDown('fast', function(){
				header_search.setResultsHeight();
				header_search.auxiliaries.resultsOpened = true;
			}).scrollTop(0);
		});
	},
	
	hideResults: function(cleanResults) {
		$(header_search.elements.results).slideUp('fast', function(){
			if(cleanResults) header_search.cleanResults();
			header_search.auxiliaries.resultsOpened = false;
			if(!isMobile.phone) overlay.hideHeaderOverlay();
			overlay.hideWrapperOverlay(function() {
				header_search.defocusForm();
			});
		});
	},
	
	cleanResults: function() {
		$(header_search.elements.results).html('');
	},
	
	showLoading: function() {
		$(header_search.elements.loading).show();
	},
	
	hideLoading: function() {
		$(header_search.elements.loading).hide();
	},
	
	showReset: function() {
		$(header_search.elements.reset).show();
	},
	
	hideReset: function() {
		$(header_search.elements.reset).hide();
	},
	
	showSubmit: function() {
		$(header_search.elements.submit).show();
	},
	
	hideSubmit: function() {
		$(header_search.elements.submit).hide();
	},
	
	focusing: function(event) {
		if(header_search.hasResults()) {
			header_search.showResults();
		}
	},
	
	defocusing: function(event) {
		event.stopPropagation(); 
		
		if(header_search.auxiliaries.resultsOpened && !$(header_search.elements.form).is(event.target) && $(header_search.elements.form).has(event.target).length === 0) {
			header_search.hideResults(false);
		}
	},
	
	focusForm: function() {
		$(header_search.elements.form).addClass(header_search.auxiliaries.formFocusedClassName);
	},
	
	defocusForm: function() {
		$(header_search.elements.form).removeClass(header_search.auxiliaries.formFocusedClassName);
	},
	
	submiting: function(event) {
		if(!$(header_search.elements.field).val()) {
			event.preventDefault();
		}
	},
	
	reseting: function(event) {
	    if(isMobile.phone) {
	        if(header_search.hasText()) {
	            $(header_search.elements.field).focus();
	        } else {
	            header.toggleMobileSearchView();
	        }
		}
		
		header_search.hideResults(true);
	},
	
	changeContainerWidthAndPositon: function() {
		if(window.innerWidth <= 1199) {
			$(header_search.elements.results).width($('#content > .container').width()).css({
				top: $(header.elements.container).outerHeight() - $(header.elements.container).css('border-top-width').replace('px', ''),
				left: 0
			});
		} else {
			$(header_search.elements.results).width($(header_search.elements.form).outerWidth()).css({
				top: ($(header_search.elements.form).offset().top - $(header.elements.container).offset().top) + $(header_search.elements.form).outerHeight() - $(header.elements.container).css('border-top-width').replace('px', ''),
				left: $(header_search.elements.form).offset().left
			});
		}
	},
	
	setResultsHeight: function() {
		if(window.innerHeight <= 767) $(header_search.elements.results).height(window.innerHeight - $(header.elements.container).height());
	}

};
