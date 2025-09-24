var totalizers = {
	
	auxiliaries: {},
	
	elements: {
		totalUserRatings: '.total-user-ratings',
		totalUserReviews: '.total-user-reviews',
		totalGameRatings: '.total-game-ratings',
		totalGameReviews: '.total-game-reviews'
	},
	
	start: function() {
		totalizers.events();
	},
	
	events: function() {
		$(document).on('ratingCreated', function() {
			totalizers.increment(totalizers.elements.totalUserRatings);
			totalizers.increment(totalizers.elements.totalGameRatings);
		});
		$(document).on('ratingDeleted', function() {
			totalizers.decrement(totalizers.elements.totalUserRatings);
			totalizers.decrement(totalizers.elements.totalGameRatings);
		});
		$(document).on('reviewCreated', function() {
			totalizers.increment(totalizers.elements.totalUserReviews);
			totalizers.increment(totalizers.elements.totalGameReviews);
		});
		$(document).on('reviewDeleted', function() {
			totalizers.decrement(totalizers.elements.totalUserReviews);
			totalizers.decrement(totalizers.elements.totalGameReviews);
		});
	},
	
	increment: function(container) {
		$(container).each(function() {
			var counter = parseInt($(this).text());
			
			$(this).text(++counter);
		});
	},
	
	decrement: function(container) {
		$(container).each(function() {
			var counter = parseInt($(this).text());
			
			$(this).text(--counter);
		});
	}
	
};
