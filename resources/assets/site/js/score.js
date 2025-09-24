var score = {

	auxiliaries: {
	    ranges: {
		    low: {
			    name: 'low',
			    startScore: 0.0,
			    endScore: 5.9
		    },
		    medium: {
			    name: 'medium',
			    startScore: 6.0,
			    endScore: 7.9
		    },
		    high: {
			    name: 'high',
			    startScore: 8.0,
			    endScore: 10.0
		    }
	    },
		preClassName: 'score-',
		classesNames: 'score-low score-medium score-high'
	},

	elements: {
		instances: [],
		scores: '.item-score',
		classicScores: '.item-score-classic'
	},

	start: function() {
		$(score.elements.scores).each(score.create);
		$(score.elements.classicScores).each(score.treatClassicScore);
		
		score.events();
	},
	
	events: function() {
		$(document).trigger('scoresInstancesStored');
		
		$(header_search.elements.results).on('searchCompleted', function() {
			$(header_search.elements.results + ' ' + score.elements.scores).each(score.create);
		});
		
		$(document).on('dialogCreated', function() {
			$(dialog.elements.container + ' ' + score.elements.scores).each(score.create);
		});
		
		$(game.elements.headerContainer).on('gameScoresUpdated', function() {
			$(game.elements.scoresContainer + ' ' + score.elements.scores).each(score.create);
		});
		
		$(game.elements.indexContainer).on('gameIndexScoresUpdated', function() {
			$(game.elements.indexContainer + ' ' + score.elements.scores).each(score.create);
		});
		
		$(game.elements.indexContainer).on('gameCriteriasScoresUpdated', game.elements.indexCriteriasScoresContainer, function() {
			$(game.elements.indexCriteriasScoresContainer + ' ' + score.elements.scores).each(score.create);
		});
		
		$(document).on('ratingCreated ratingUpdated reviewDeleted', function() {
		    $(game.elements.buttonsContainer + ' ' + score.elements.classicScores).each(score.treatClassicScore);
			$(review.elements.writeContainer + ' ' + score.elements.classicScores).each(score.treatClassicScore);
		});
	},
	
	create: function() {
		var selector = $(this)[0];
		var size = $(this).data('size');
		var ratingScore = $(this).data('score');
		
		var instance = Circles.create(selector, {
			radius:              score.getRadius(size),
			value:               score.treatValue(ratingScore),
			maxValue:            100,
			width:               '',
			text:                score.treatText(ratingScore),
			colors:              [],
			duration:            150,
			wrpClass:            'circles-wrp',
			textClass:           'circles-text',
			valueStrokeClass:    score.getScoreClassName(ratingScore),
			maxValueStrokeClass: score.getScoreClassName(ratingScore) + '-fill',
			styleWrapper:        true,
			styleText:           true
		});
		
		score.storeInstance(instance, selector);
	},
	
	getInstance: function(selector) {
		return score.elements.instances[$(selector).data('scoreId')];
	},

	getRadius: function(size) {
		var radius;
		
		switch(size) {
			case 'default-score-size':
				radius = 25;
			break;
			case 'small-score-size':
				radius = 21;
			break;
			case 'game-score-size':
				radius = (!isMobile.phone) ? 36 : 34;
			break;
			case 'game-user-score-size':
				radius = (!isMobile.phone) ? 40 : 34;
			break;
			case 'game-spotlight-score-size':
				radius = (!isMobile.phone) ? 60 : 26;
			break;
			case 'rating-criteria-score-size':
				radius = (!isMobile.phone) ? 32 : 27;
			break;
		}
		
		return radius;
	},
	
	getScoreClassName: function(value) {
		return score.auxiliaries.preClassName + score.getScoreRangeName(value);
	},
	
	getScoreRangeName: function(value) {
		for(i in score.auxiliaries.ranges) {
			if(value >= score.auxiliaries.ranges[i].startScore && value <= score.auxiliaries.ranges[i].endScore) {
				return score.auxiliaries.ranges[i].name;
			}
		}
	},
	
	storeInstance: function(instance, selector) {
		$(selector).data('scoreId', score.elements.instances.length);
		
		score.elements.instances.push(instance);
	},
	
	treatClassicScore: function() {
		var ratingScore = $(this).text();
		
		$(this).addClass(score.getScoreClassName(ratingScore)).text(score.treatText(ratingScore));
	},
	
	treatText: function(ratingScore) {
		ratingScore = ratingScore.toString();
	
		if(ratingScore.length == 1) {
			ratingScore += ',0';
		} else if(ratingScore == 10.0) {
			ratingScore = 10;
		}
		
		return ratingScore.toString().replace('.', ',');
	},
	
	treatValue: function(ratingScore) {
		ratingScore = ratingScore.toString();
		
		if(ratingScore.length == 1) {
			ratingScore += '.0';
		} else if(ratingScore == 10) {
			ratingScore = 100;
		}

		return ratingScore.toString().replace('.', '');
	},
	
	updateClassicScore: function(selector, value) {
		selector.removeClass(score.auxiliaries.classesNames).addClass(score.getScoreClassName(value)).text(score.treatText(value));
	},
	
	updateScore: function(selector, value, duration) {
		duration = (typeof duration !== 'undefined') ? duration : 0;
		
		score.getInstance(selector).update(score.treatValue(value), duration).updateText(score.treatText(value)).updateValueStrokeClass(score.getScoreClassName(value)).updateMaxValueStrokeClass(score.getScoreClassName(value) + '-fill');
	}
	
};