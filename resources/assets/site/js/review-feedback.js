var review_feedback = {

	elements: {
		container: '.item-review-feedback',
		group: '.item-review-feedback-group',
		button: '.item-review-feedback-button',
		counter: '.item-review-feedback-counter',
		containersToFetch: '.item-review-feedback[data-url]'
	},

	start: function() {
		$(review_feedback.elements.containersToFetch).each(review_feedback.fetch);
		
		review_feedback.events();
	},
	
	events: function() {
		$('body').on('click', review_feedback.elements.button, review_feedback.vote);
	},
	
	disableBtn: function(button) {},
	
	enableBtn: function(button) {},
	
	increaseCounter: function(button) {
		var counter = $(button).parents(review_feedback.elements.group).find(review_feedback.elements.counter);
		
		counter.text(+counter.text() + 1);
		
		$(button).find('.fa.fa-check').removeClass('d-none');
		$(button).find('.fa.fa-thumbs-up, .fa.fa-thumbs-down').addClass('d-none');
	},
	
	decreaseCounter: function(button) {
		var counter = $(button).parents(review_feedback.elements.group).find(review_feedback.elements.counter);
		
		counter.text(+counter.text() - 1);
		
		$(button).find('.fa.fa-check').addClass('d-none');
		$(button).find('.fa.fa-thumbs-up, .fa.fa-thumbs-down').removeClass('d-none');
	},
	
	fetch: function() {
		var container = this;
	
		$.ajax({
			type: 'POST',
			url: $(this).data('url'),
			data: {},
			success: function(response) {
				$(container).html(response);
			}
		});
	},
	
	vote: function(event) {
		event.preventDefault();

        button = this;
		review_feedback.disableBtn(button);

        ajax.send($(button).data('ajax-url'), {}, function(response) {
            if(response.success) {
				if(response.deleted) {
					review_feedback.decreaseCounter(button);
				} else {
					review_feedback.increaseCounter(button);
				
					if(!response.wasRecentlyCreated) {
						$($(button).parents(review_feedback.elements.container).find(review_feedback.elements.button)).each(function() {
							if(!$(this).is(button)) review_feedback.decreaseCounter(this);
						});
					}
				}
			} else if(response.error) {
				switch(response.error) {
					case 'same_author':
						alert.create('warning', response.message);
					break;
				}
			}
			
			review_feedback.enableBtn(button);
        });
	}
	
};