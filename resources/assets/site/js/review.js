var review = {

	elements: {
		header: '#reviews-header',
		items: '#reviews-items',
		itemContainer: '.item-review',
		itemContainerBody: '.item-review-body',
		text: '.item-review-text',
		editButton: '.item-review-edit',
		deleteButton: '.item-review-delete',
		form: '.review-write-form',
		fieldset: '.review-write-form-fieldset',
		textarea: '.review-write-form-textarea',
		hasSpoilersCheckbox: '.review-write-form-hasSpoilers',
		cancelButton: '.review-write-form-cancel',
		writeContainer: '#review-write'
	},

	start: function() {
		review.events();
	},
	
	events: function() {
		$('body').on('click', review.elements.itemContainer + ' ' + review.elements.editButton, review.showEdition);
		$('body').on('click', review.elements.itemContainer + ' ' + review.elements.cancelButton, review.hideEdition);
		$('body').on('click', review.elements.itemContainer + ' ' + review.elements.deleteButton, review.confirmDelete);
		$('body').on('submit', review.elements.itemContainer + ' ' + review.elements.form, review.updateReview);
		$('body').on('submit', review.elements.writeContainer + ' ' + review.elements.form, review.createReview);
	},
	
	showEdition: function(event) {
		event.preventDefault();
		
		$(review.getContainer(event.target)).find(review.elements.itemContainerBody).fadeOut('fast', function() {
			$(review.getContainer(event.target)).find(review.elements.form).fadeIn('fast', function() {
				$(this).find(review.elements.textarea).focus();
			});
		});
	},
	
	hideEdition: function(event) {
		event.preventDefault();
		
		$(review.getContainer(event.target)).find(review.elements.form).fadeOut('fast', function() {
			$(review.getContainer(event.target)).find(review.elements.itemContainerBody).fadeIn('fast');
		});
	},
	
	confirmDelete: function(event) {
		event.preventDefault();
		
		if(confirm($(event.target).data('message'))) review.deleteReview(review.getContainer(event.target));
	},
	
	createReview: function(event) {
		event.preventDefault();
		review.disableForm(event.target);
		
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(event.target).data('ajax-url'),
				data: {
					text: $(review.elements.writeContainer).find(review.elements.textarea).val(),
					has_spoilers: $(review.elements.writeContainer).find(review.elements.hasSpoilersCheckbox).prop('checked')
				},
				success: function(response) {
					loading.hide('fast', function() {
						review.enableForm(event.target);
						
						if(!response.error) {
							review.hideWriteContainer(response.reviewItem);
							
							alert.create('success', 'Análise criada com sucesso');
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						review.enableForm(event.target);
						
						var errors = JSON.parse(XMLHttpRequest.responseText).errors;
						var firstMessage = errors[Object.keys(errors)[0]][0];
						alert.create('warning', firstMessage);
					});
				}
			});
		});
	},
	
	updateReview: function(event) {
		event.preventDefault();
		review.disableForm(event.target);

		var container = $(event.target).parents(review.elements.itemContainer);
		var text = $(event.target).find(review.elements.textarea).val();
		var hasSpoilers = $(event.target).find(review.elements.hasSpoilersCheckbox).prop('checked')
		
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(event.target).data('ajax-url'),
				data: {
					text: text,
					has_spoilers: hasSpoilers
				},
				success: function(response) {
					loading.hide('fast', function() {
						review.enableForm(event.target);
						
						if(!response.error) {
							review.updateText(container, text);
							review.hideEdition(event);
							
							alert.create('success', 'Análise atualizada com sucesso');
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						review.enableForm(event.target);
						
						var errors = JSON.parse(XMLHttpRequest.responseText).errors;
						var firstMessage = errors[Object.keys(errors)[0]][0];
						alert.create('warning', firstMessage);
					});
				}
			});
		});
	},
	
	deleteReview: function(container) {
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(container).find(review.elements.deleteButton).data('ajax-url'),
				success: function(response) {
					loading.hide('fast', function() {
						if(!response.error) {
							review.destroy(container, response.writeContainer);
							
							alert.create('success', 'Análise excluída com sucesso');
						}
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						alert.create('danger', 'Algo deu errado');
					});
				}
			});
		});
	},
	
	destroy: function(container, writeContainer) {
		$(container).fadeOut('fast', function() {
			$(this).remove();
			
			review.placeWriteContainer(writeContainer);
			
			$(document).trigger('reviewDeleted');
		});
	},
	
	disableForm: function(form) {
		$(form).children(review.elements.fieldset).attr('disabled', 'disabled');
	},
	
	enableForm: function(form) {
		$(form).children(review.elements.fieldset).removeAttr('disabled');
	},
	
	getContainer: function(element) {
		return $(element).parents(review.elements.itemContainer);
	},
	
	hideWriteContainer: function(reviewItem) {
		reviewItem = (typeof reviewItem !== 'undefined') ? reviewItem : null;
		
		if($(review.elements.writeContainer).length) {
			$(review.elements.writeContainer).fadeOut('fast', function(){
				$(review.elements.writeContainer).find(review.elements.textarea).html('');
				
				if(reviewItem) $(review.elements.writeContainer).after(reviewItem);
				
				$(review.elements.itemContainer + ' ' + score.elements.scores).each(score.create);
				$(review.elements.form + ' ' + score.elements.classicScores).each(score.treatClassicScore);
				
				$(document).trigger('reviewCreated');
			});
		}
	},
	
	placeWriteContainer: function(writeContainer) {
		if($(review.elements.header).length) $(review.elements.header).html(writeContainer);
	},
	
	showWriteContainer: function() {
		if($(review.elements.writeContainer).length) {
			$(review.elements.writeContainer).find(review.elements.textarea).html('');
		}
	},
	
	updateText: function(container, text) {
		$(container).find(review.elements.text).text(text);
	},
	
	updateItem: function(id, item) {
		var element = review.elements.itemContainer + '-' + id;
		
		if($(element).length) {
			$(element).replaceWith(item);
			$(element + ' ' + score.elements.scores).each(score.create);
		}
	},
	
	deleteItem: function(id) {
		var element = review.elements.itemContainer + '-' + id;
		
		if($(element).length) {
			$(element).parent().fadeOut('fast', function() {
				$(this).remove();
				
				$(document).trigger('reviewDeleted');
			});
		}
	}
	
};