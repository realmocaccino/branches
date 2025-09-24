var horizontalDraggable = {
	
	elements: {
		item: '.horizontalDraggable'
	},

	start: function() {
		$(horizontalDraggable.elements.item).each(horizontalDraggable.create);
		
		horizontalDraggable.events();
	},
	
	events: function() {},
	
	create: function() {
	    var slider = this;
        var startX;
        var scrollLeft;

        slider.addEventListener('mousedown', function(event) {
            slider.classList.add('active');
            startX = event.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mousemove', function(event) {
            event.preventDefault();
            const x = event.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.5;
            slider.scrollLeft = scrollLeft - walk;
        });
        slider.addEventListener('touchstart', function(event) {
            var touch = event.changedTouches[0];
            slider.classList.add('active');
            startX = touch.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('touchmove', function(event) {
            var touch = event.changedTouches[0];
            event.preventDefault();
            const x = touch.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.8;
            slider.scrollLeft = scrollLeft - walk;
        });
	}
	
};