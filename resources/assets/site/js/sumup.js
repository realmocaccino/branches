var sumup = {
	
	auxiliaries: {
	    expandButtonClassName: 'sumup-expand'
	},
	
	elements: {
		container: '[data-sumup]'
	},
	
	start: function() {
		$(sumup.elements.container).each(function() {
			new sumup.instance(this).start();
		});
	},
	
	events: function() {},
	
	instance: function(container) {
		this.container = $(container);
		this.containerHeight = this.container.height();
		this.lineHeight = this.container.css('line-height').replace('px', '');

		this.lines = this.container.data('sumup');
		this.desiredHeight = this.lines * this.lineHeight;
		this.toleranceLines = this.container.data('sumup-tolerance') !== undefined ? this.container.data('sumup-tolerance') : 0;
		this.toleranceHeight = this.toleranceLines * this.lineHeight;

		this.start = function() {
			if(this.lines) this.sumup();
		}
		
		this.events = function() {
			this.button.on('click', function(ev) {
				this.expand();
				
				ev.preventDefault();
			}.bind(this));
		}
		
		this.sumup = function() {
			if(this.containerHeight > (this.desiredHeight + this.toleranceHeight)) {
				this.container.height(this.desiredHeight).css('overflow', 'hidden').css('position', 'relative').css('display', 'inline-block');
				this.container.append('<a class="' + sumup.auxiliaries.expandButtonClassName + '">leia mais</a>');
				this.button = this.container.children('a.' + sumup.auxiliaries.expandButtonClassName);
				
				this.events();
			}
		}
		
		this.expand = function() {
			this.button.hide();
			
			this.container.height(this.containerHeight);
		}

	}
	
};