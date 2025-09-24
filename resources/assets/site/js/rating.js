var rating = {

	elements: {
		inputs: 'input[type=range]',
		container: '#rating, #rating-delete',
		form: '#rating-form',
		fieldset: '#rating-form fieldset',
		criteria: '.rating-criteria',
		criteriaScore: '.rating-criteria-score .item-score',
		averageScores: '#rating-header-score .item-score, #rating-bottom-score .item-score',
		chart: '#rating-chart-canvas',
		rangesliderClassName: '.rangeslider',
		rangesliderBarClassName: '.rangeslider__fill',
		platformSelect: '#rating-platform',
		formDelete: '#rating-delete-form'
	},

	start: function() {
		rating.events();
		
		$(document).on('dialogCreated', rating.events);
	},
	
	events: function() {
		$(rating.elements.platformSelect).prettyDropdown();

		if($(rating.elements.inputs).length) {
			$(rating.elements.inputs).rangeslider({
				polyfill: false
			});
			
			$(rating.elements.inputs).each(rating.changeRangesliderColor);
			$(document).on('scoresInstancesStored', function() {
				$(rating.elements.inputs).each(rating.updateCriteriaScore);
				rating.updateAverageScore();
				if(!isMobile.phone) rating.updateChart();
			});
			$(rating.elements.inputs).on('input', rating.changeRangesliderColor);
			$(rating.elements.inputs).on('input', rating.updateCriteriaScore);
			$(rating.elements.inputs).on('input', rating.updateAverageScore);
			if(!isMobile.phone) $(rating.elements.inputs).on('input', rating.updateChart);
		}
		
		if($(rating.elements.container).parents(dialog.elements.container).length && !$(rating.elements.container).data('reload')) {
			$(rating.elements.form).on('submit', rating.saveRating);
			$(rating.elements.formDelete).on('submit', rating.deleteRating);
		}
	},
	
	changeRangesliderColor: function() {
		var bar = $(this).siblings(rating.elements.rangesliderClassName).find(rating.elements.rangesliderBarClassName);
		var className = score.getScoreClassName($(this).val());
		
        bar.removeClass(score.auxiliaries.classesNames).addClass(className);
	},
	
	disableForm: function() {
		$(rating.elements.fieldset).attr('disabled', 'disabled');
	},
	
	enableForm: function() {
		$(rating.elements.fieldset).removeAttr('disabled');
	},
	
	getAverageScore: function() {
	    var scoreSum = 0;
    	var weightSum = 0;
    	
    	$(rating.elements.inputs).each(function() {
    		scoreSum += +$(this).val() * $(this).data('weight');
    		weightSum += $(this).data('weight');
    	});
    	
    	return Number((scoreSum / weightSum).toFixed(1));
	},
	
	getCriteriasValues: function() {
		var criterias = {};
		
		$('input[name^=criterias]').each(function() {
			criterias[$(this).data('slug')] = $(this).val();
		});
		
		return criterias;
	},
	
	saveRating: function(event) {
		event.preventDefault();		
		rating.disableForm();
		
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(rating.elements.form).data('ajax-url'),
				data: {
					criterias: rating.getCriteriasValues(),
					platform_id: $('select[name=platform_id]').val(),
					origin_route: $('input[name=origin_route]').val()
				},
				success: function(response) {
					loading.hide('fast', function() {
						if(response.error) {
						    alert.create('warning', response.message);
						} else {
							dialog.close(function() {
								alert.create('success', response.message);
								
								item_rating.update(response.ratingId, response.ratingItem);
								if(response.rateButton) game.updateRateButton(response.rateButton);
								if(response.scores) game.updateScores(response.scores);
								game.updateIndexPage(response);
								
								$(document).trigger((response.isNew) ? 'ratingCreated' : 'ratingUpdated');
							});
						}
						
						rating.enableForm();
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						dialog.close(function() {
							alert.create('danger', errorThrown);
						});
					});
				}
			});
		});
	},
	
	deleteRating: function(event) {
		event.preventDefault();
		rating.disableForm();
		
		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(rating.elements.formDelete).data('ajax-url'),
				data: {
					origin_route: $('input[name=origin_route]').val()
				},
				success: function(response) {
					loading.hide('fast', function() {
						if(response.error) {
						} else {
							dialog.close(function() {
								alert.create('success', response.message);

								item_rating.delete(response.ratingId);
								if(response.rateButton) game.updateRateButton(response.rateButton);
								if(response.scores) game.updateScores(response.scores);
								game.updateIndexPage(response);
									
								if(response.reviewId) {
									$(review.elements.itemContainer + '-' + response.reviewId).remove();
									$(document).trigger('reviewDeleted');
								}
								
								$(document).trigger('ratingDeleted');
							});
						}
						
						rating.enableForm();
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						dialog.close(function() {
							alert.create('danger', 'Algo deu errado');
						});
					});
				}
			});
		});
	},
	
	updateChart: function() {
		chart.update(rating.elements.chart, [{
			'label': '',
			'data': $(rating.elements.inputs).map(function() { return $(this).val(); }),
			'score': rating.getAverageScore()
		}]);
	},
	
	updateCriteriaScore: function() {
		score.updateScore($(this).parents(rating.elements.criteria).find(rating.elements.criteriaScore), $(this).val());
	},
	
	updateAverageScore: function() {
	    average = rating.getAverageScore();
	
		$(rating.elements.averageScores).each(function() {
			score.updateScore(this, average, 150);
		});
	}
	
};