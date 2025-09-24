var alert = {

	auxiliaries: {
		delay: 4
	},

	elements: {
		container: '.alert',
		closeButton: '.alert .alert-close',
		siteContainer: '#header'
	},
	
	start: function() {
		alert.events();
	},
	
	events: function() {
		$(alert.elements.container).each(function() {
			if($(this).data('alert-autoclose')) alert.autoClose();
		});
		
		$(document).on('click', alert.elements.closeButton, alert.close);
	},

	autoClose: function() {
		$(alert.elements.container).delay(alert.auxiliaries.delay * 1000).slideUp('fast', function() {
			alert.destroyElement(this);
		});
	},
	
	close: function(event) {
		event.preventDefault();
		
		$(this).closest(alert.elements.container).clearQueue().slideUp('fast', function() {
			alert.destroyElement(this);
		});
	},
	
	create: function(className, text, isAutoClose) {
		$.ajax({
			type: 'POST',
			url: '/ajax/alert',
			data: {
				className: className,
				text: text
			},
			success: function(response) {
				alert.createElement(response, typeof isAutoClose !== 'undefined' ? isAutoClose : true)
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {}
		});
	},

	createElement: function(element, isAutoClose)
	{
		$(alert.elements.siteContainer).addClass(header.auxiliaries.withoutBorderClassName).prepend(element).slideDown('fast', function() {
			if(isAutoClose) alert.autoClose();
		});
	},

	destroyElement: function(element)
	{
		$(element).remove();
		$(alert.elements.siteContainer).removeClass(header.auxiliaries.withoutBorderClassName);
	}
	
};
