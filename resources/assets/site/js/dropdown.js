var dropdown = {
	
	elements: {
		item: '[data-dropdown]'
	},

	start: function() {
		$(dropdown.elements.item).each(dropdown.create);

		dropdown.events();
	},
	
	events: function() {
	    $(document).on('openDropdown', function(event, element) {
            dropdown.position(element).css('display', 'block');
	    });
        $(document).on('positionDropdown', function(event, element) {
            dropdown.position(element);
        });
	},
	
	create: function() {
	    const button = '#' + $(this).attr('id');
        const tooltip = '#' + $(this).data('dropdown');
        var isAlreadyOpened = false;

        $(tooltip).hide().css('left', $(button).position().left);

        $(button).click(function(event) {
            $(button).toggleClass('active');
            $(tooltip).css('display', isAlreadyOpened ? 'none' : 'block');  
            
            if(isAlreadyOpened) $(this).blur();
            
            isAlreadyOpened = ($(tooltip).css('display') == 'block') ? true : false;
            
            event.preventDefault();
        });

        $(document).on('click', ':not(' + button  + ', ' + button + ' .fa, ' + button + ' span, ' + tooltip + ', ' + tooltip + ' *)', function(event) {
            if(isAlreadyOpened) {
                $(tooltip).css('display', 'none');
                $(button).removeClass('active');
                isAlreadyOpened = false;
            }
        });
	},

    position: function(element) {
        const tooltip = '#' + $(element).data('dropdown');

        $(tooltip).css('left', $(element).position().left);

        return $(tooltip);
    }

};