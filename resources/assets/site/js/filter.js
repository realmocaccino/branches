var filter = {

	auxiliaries: {
		focusedClassName: 'focused'
	},

	elements: {
		container: '.filter',
		actives: '.filter-actives a',
		form: '.filter-form',
		bars: '.filter-form select',
		orderBar: '.filter-form-order-bar',
		filterToggleButton: '.filter-form-toggleButton',
		filterToggleTarget: '.filter-form-toggleTarget',
		alphabet: '.filter-alphabet'
	},

	start: function() {
		filter.events();
	},

	events: function() {
		$(filter.elements.actives).on('click', filter.removeFilter);
		$(filter.elements.bars).not(multiple_select.elements.reloadSelects).on('change', filter.addFilter);
		$(filter.elements.bars).on('select2:unselect', filter.addFilter);
		$(filter.elements.filterToggleButton).on('click', filter.toggleFilterContainer);
		if($(filter.elements.orderBar).length) filter.showOrderBar();
	},
	
	removeFilter: function(ev) {
		ev.preventDefault();
		
		loading.show('fast', function() {
			scrolling.disable();
			window.location.href = ev.currentTarget.href;
		});
	},
	
	addFilter: function(ev) {
		if(ev.target.value) {
			loading.show('fast', function() {
				filter.organizeSelect2(ev.target);
				$(filter.elements.form).submit();
				filter.disableFilters();
			});
		}
	},

	disableFilters: function() {
		$(filter.elements.bars).each(function() {
			$(this).attr('disabled', 'disabled');
		});
	},

	enableFilters: function() {
		$(filter.elements.bars).each(function() {
			$(this).removeAttr('disabled');
		});
	},
	
	toggleFilterContainer: function(ev) {
		ev.preventDefault();

		if($(filter.elements.filterToggleTarget).css('display') == 'none') {
			$(filter.elements.filterToggleTarget).fadeIn('fast');
			$(filter.elements.filterToggleButton).addClass(filter.auxiliaries.focusedClassName);
		} else {
			$(filter.elements.filterToggleTarget).fadeOut('fast');
			$(filter.elements.filterToggleButton).removeClass(filter.auxiliaries.focusedClassName);
		}
	},
	
	showOrderBar: function() {
		$(filter.elements.orderBar).show();
    },

	organizeSelect2: function(element) {
		$(element).siblings('.select2-container').find('.select2-search--inline').hide();
	}

};