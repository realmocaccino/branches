var game = {

	elements: {
		container: '#game',
		headerContainer: "#game-header",
		scoresContainer: '#game-scores',
		communityScore: '#game-scores-communityScore',
		criticScore: '#game-scores-criticScore',
		aggreggateScore: '#game-scores-aggregateScore',
		userScore: '#game-scores-userScore',
		addScore: '#game-scores-addScore',
		buttonsContainer: '#game-buttons',
		rateButton: '#game-rate-button',
		indexContainer: '#game-index',
		indexCriteriasContainer: '#game-index-criterias',
		indexCriteriasFilterByPlatformSelect: '#game-index-criterias-filterByPlatformList',
		indexCriteriasChart: '#game-index-criterias-chart',
		indexCriteriasScoresContainer: '#game-index-criteriasScores',
		indexPlatformsScoresContainer: '#game-index-platformsScores',
		indexPlatformsScoresTable: '#game-index-platformsScores-table',
		showHiddenPlatformsRow: '#game-index-platformsScores-showHiddenPlatformsRow',
		showHiddenPlatformsButton: '#game-index-platformsScores-showHiddenPlatformsButton'
	},

	start: function() {
		$(game.elements.indexCriteriasFilterByPlatformSelect).prettyDropdown();

		game.events();
	},
	
	events: function() {
		game.checkCallForRating();
		game.showHiddenPlatformsRowIfThereAreHiddenPlatforms();
		game.touchUpScoreColumnsOnMobile();
		$(game.elements.indexPlatformsScoresTable).on('click', game.elements.showHiddenPlatformsButton, game.showPlatformsWithoutScore);
		$(game.elements.indexContainer).on('change', game.elements.indexCriteriasFilterByPlatformSelect, game.updateCriteriasChartAndScoresByPlatform);
	},
	
	checkCallForRating: function() {
		if(window.location.hash == '#avaliar') dialog.open($(game.elements.rateButton).data('ajax-url'));
	},
	
	resetCriteriasSelectPlatform: function() {
		$(game.elements.indexCriteriasFilterByPlatformSelect).val('');
	},
	
	showHiddenPlatformsRowIfThereAreHiddenPlatforms: function() {
		if($(game.elements.indexPlatformsScoresTable + ' tr.d-none').length) {
			$(game.elements.showHiddenPlatformsRow).fadeIn('120');
		}
	},
	
	showPlatformsWithoutScore: function() {
		$(game.elements.showHiddenPlatformsRow).fadeOut(120, function() {
			$(game.elements.indexPlatformsScoresTable + ' tr.d-none').removeClass('d-none');
		});
	},
	
	updateRateButton: function(button) {
		if($(game.elements.rateButton).length) {
			$(game.elements.rateButton).replaceWith(button);
		}
	},
	
	updateCriteriasChartAndScoresByPlatform: function(event) {
		var platformSlug = $(this).val();

		loading.show('fast', function() {
			$.ajax({
				type: 'POST',
				url: $(game.elements.indexCriteriasFilterByPlatformSelect).data('ajax-url'),
				data: {
					platform_slug: platformSlug
				},
				success: function(response) {
					loading.hide('fast', function() {
						chart.update(game.elements.indexCriteriasChart, response.datasets);
						game.updateIndexScores(response.criteriasScores, null, false);
						
						$(game.elements.indexCriteriasScoresContainer).trigger('gameCriteriasScoresUpdated');
					});
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					loading.hide('fast', function() {
						alert.create('danger', 'Algo deu errado');
					}, game.elements.indexCriteriasContainer);
				}
			});
		}, game.elements.indexCriteriasContainer);
	},
	
	updateIndexPage: function(response) {
		if($(game.elements.indexContainer).length) {
			game.resetCriteriasSelectPlatform();
			chart.update(game.elements.indexCriteriasChart, response.criteriasChartDatasets);
			game.updateIndexScores(response.criteriasScores, response.platformsScores);
			game.touchUpScoreColumnsOnMobile();
		}
		
		if(response.reviewWrite) {
			review.placeWriteContainer(response.reviewWrite);
		} else if(response.reviewId && response.reviewItem) {
			review.updateItem(response.reviewId, response.reviewItem);
		} else if(response.reviewDisabled) {
			review.placeWriteContainer(response.reviewDisabled);
		}
	},
	
	updateIndexScores: function(criteriasScores, platformsScores, triggerEvent) {
		if(typeof criteriasScores !== 'undefined' && criteriasScores) $(game.elements.indexCriteriasScoresContainer).replaceWith(criteriasScores);
		if(typeof platformsScores !== 'undefined' && platformsScores) $(game.elements.indexPlatformsScoresContainer).replaceWith(platformsScores);
		
		if(typeof triggerEvent === 'undefined' || triggerEvent === true) $(game.elements.indexContainer).trigger('gameIndexScoresUpdated');
	},
	
	updateScores: function(scores) {
		if($(game.elements.scoresContainer).length) {
			$(game.elements.scoresContainer).replaceWith(scores);
		
			$(game.elements.headerContainer).trigger('gameScoresUpdated');
		}
	},

	touchUpScoreColumnsOnMobile: function() {
		if(!isMobile.phone) return;
		
		visibleElements = $(game.elements.scoresContainer).children(':visible')

		if (visibleElements.length == 3) {
			$(game.elements.criticScore).css('border', 'none');
		} else if (visibleElements.length == 2) {
			if($(game.elements.criticScore).length) {
				$(game.elements.criticScore).css('border', 'none');
			} else {
				$(game.elements.communityScore).css('border', 'none');
			}
		} else if (visibleElements.length == 1) {
			visibleElements.css('border', 'none');
		}

		if ($(game.elements.userScore).length) {
			$(game.elements.userScore).css('padding-left', '15px');
		} else if ($(game.elements.communityScore).length) {
			$(game.elements.communityScore).css('padding-left', '5px');
		} else if ($(game.elements.criticScore).length) {
			$(game.elements.criticScore).css('padding-left', '10px');
		}
	}
	
};