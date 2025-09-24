var sortable = {
	
	elements: {
		item: '.sortable'
	},

	start: function() {
		$(sortable.elements.item).each(sortable.create);
		
		sortable.events();
	},
	
	events: function() {},
	
	create: function() {
	    var instance = Sortable.create(this, {
	        onUpdate: function(event) {
	            instance.option('disabled', true);
	            $.ajax({
				    type: 'POST',
				    url: this.dataset.ajaxUrl,
				    data: {
					    items: Array.from(this.children).map(function(item, index) {
                            return [item.dataset.id, index];
                        })
				    },
				    success: function(response) {
				        instance.option('disabled', false);
				    },
				    error: function(XMLHttpRequest, textStatus, errorThrown) {
				        alert.create('danger', 'Algo deu errado');
				    }
			    });
	        }.bind(this)
	    });
	}
	
};