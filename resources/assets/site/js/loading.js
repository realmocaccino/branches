var loading = {

	auxiliaries: {
		execute: true,
		queue: []
	},
	
	elements: {
		container: '#loading',
		src: '/img/loading.svg'
	},
	
	start: function() {
		loading.preLoading();
	},
	
	preLoading: function() {
		$('<img />').attr('src', loading.elements.src);
	},
	
	append: function() {
		$('body').append('<div id="loading"><img src="' + loading.elements.src + '"></div>');
	},
	
	appendInContainer: function(container) {
		$(container).append('<div id="loading"><img src="' + loading.elements.src + '"></div>').css('position', 'relative');
		$(loading.elements.container).css('position', 'absolute');
	},
	
	destroy: function(container) {
		$(loading.handleSelector(container)).remove();
	},
	
	handleSelector: function(container) {
		return (typeof container !== 'undefined' && container) ? [container, loading.elements.container].join(' ') : loading.elements.container;
	},
	
	show: function(speed, callback, container) {
		if(loading.auxiliaries.execute) {
			loading.auxiliaries.execute = false;
			if(typeof container !== 'undefined' && container) {
				loading.appendInContainer(container);
			} else {
				loading.append();
			}
			speed = typeof speed !== 'undefined' ? speed : 'fast';
			$(loading.handleSelector(container)).fadeIn(speed, function() {
				if(typeof callback !== 'undefined' && callback) {
					callback();
				}
			});
		} else {
			loading.auxiliaries.queue.push([speed, callback, container]);
		}
	},
	
	hide: function(speed, callback, container) {
		speed = typeof speed !== 'undefined' ? speed : 'fast';
		$(loading.handleSelector(container)).fadeOut(speed, function() {
			if(typeof callback !== 'undefined') {
				callback();
			}
			loading.destroy(container);
			loading.auxiliaries.execute = true;
			
			if(loading.auxiliaries.queue.length) {
				var params = loading.auxiliaries.queue.shift();
				
				loading.show(params[0], params[1], params[2]);
			}
		});
	}

};
