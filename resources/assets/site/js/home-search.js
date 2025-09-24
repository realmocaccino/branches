var home_search = {

	auxiliaries: {
		debounce: 450,
		resultsOpened: false,
		formFocusedClassName: 'form-focused'
	},

	elements: {
		form: '#home-search-form',
		field: '#home-search-input',
		submit: '#home-search-submit',
		loading: '#home-search-loading',
		reset: '#home-search-reset',
		results: '#home-search-results'
	},

	start: function() {
		home_search.events();
	},

	events: function() {
		$(home_search.elements.field).on('keyup', home_search.typing);
		$(home_search.elements.field).on('focus', home_search.focusing);
		$(document).on('click', ':not(' + home_search.elements.form + ', ' + home_search.elements.form + ' *)', home_search.defocusing);
		$(home_search.elements.form).on('submit', home_search.submiting);
		$(home_search.elements.reset).on('click', home_search.reseting);
	},
	
	typing: function() {
		if($(home_search.elements.field).val()) {
			debounce.calcular(home_search.sendRequest, home_search.auxiliaries.debounce);
		} else {
			if(isMobile.phone) {
				home_search.hideReset();
			}
			home_search.hideResults(true);
		}
	},
	
	sendRequest: function() {
		if($(home_search.elements.field).val()) {
			home_search.hideReset();
			home_search.showLoading();
			
			$.ajax({
				type: 'POST',
				url: $(home_search.elements.form).data('ajax-url'),
				data: {
					term: $(home_search.elements.field).val()
				},
				success: function(response) {
					home_search.replaceResultsContent(response);
					home_search.hideLoading();
					home_search.showReset();
					home_search.showResults();
					
					$(home_search.elements.results).trigger('searchCompleted');
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					home_search.replaceResultsContent('<li class="home-search-results-error"><p>Algo deu errado</p></li>');
				}
			});
		}
	},
	
	replaceResultsContent: function(content) {
		$(home_search.elements.results).html(content);
	},
	
	hasResults: function() {
	    return $(home_search.elements.results).html() != '';
	},
	
	showResults: function() {
		home_search.focusForm();
		$(home_search.elements.results).slideDown('fast', function(){
			home_search.auxiliaries.resultsOpened = true;
		}).scrollTop(0);
	},
	
	hideResults: function(cleanResults) {
		$(home_search.elements.results).slideUp('fast', function(){
			if(cleanResults) home_search.cleanResults();
			home_search.auxiliaries.resultsOpened = false;
			home_search.defocusForm();
		});
	},
	
	cleanResults: function() {
		$(home_search.elements.results).html('');
	},
	
	showLoading: function() {
		$(home_search.elements.loading).show();
	},
	
	hideLoading: function() {
		$(home_search.elements.loading).hide();
	},
	
	showReset: function() {
		$(home_search.elements.reset).show();
	},
	
	hideReset: function() {
		$(home_search.elements.reset).hide();
	},
	
	focusing: function(event) {
		if(home_search.hasResults()) {
			home_search.showResults();
		}
	},
	
	defocusing: function(event) {
		event.stopPropagation(); 
		
		if(home_search.auxiliaries.resultsOpened && !$(home_search.elements.form).is(event.target) && $(home_search.elements.form).has(event.target).length === 0) {
			home_search.hideResults(false);
		}
	},
	
	focusForm: function() {
		$(home_search.elements.form).addClass(home_search.auxiliaries.formFocusedClassName);
	},
	
	defocusForm: function() {
		$(home_search.elements.form).removeClass(home_search.auxiliaries.formFocusedClassName);
	},
	
	submiting: function(event) {
		if(!$(home_search.elements.field).val()) {
			event.preventDefault();
		}
	},
	
	reseting: function(event) {
	    if(isMobile.phone) {
	        if(home_search.hasResults()) {
	            $(home_search.elements.field).focus();
	        }
		}
		
		home_search.hideResults(true);
	}

};
