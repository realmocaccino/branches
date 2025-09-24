var item_game = {
	
	auxiliaries: {
		highlightClassName: 'highlight',
		isHover: false
	},
	
	elements: {
		item: '.item-game, .item-game-horizontal',
		itemLink: '.item-game-link',
		itemScore: '.item-game-score',
		itemAddScoreButton: '.add-score'
	},
	
	start: function() {
		item_game.events();
	},
	
	events: function() {
		if(!isMobile.phone) {
			$('ul').on({
				click: function() {
					if(!$(event.target).hasClass(item_game.elements.itemAddScoreButton.replace('.', '')) && !$(event.target).hasClass('oi')) {
						$(this).find(item_game.elements.itemLink).addClass(item_game.auxiliaries.highlightClassName);
						$(this).find(item_game.elements.itemScore).addClass(item_game.auxiliaries.highlightClassName);
					}
				},
				mouseenter: function() {
					item_game.auxiliaries.isHover = true;
					
					setTimeout(function() {
						if(item_game.auxiliaries.isHover) {
							$(this).find(item_game.elements.itemLink).addClass(item_game.auxiliaries.highlightClassName);
							$(this).find(item_game.elements.itemScore).addClass(item_game.auxiliaries.highlightClassName);
						}
					}.bind(this), 50);
				},
				mouseleave: function() {
					item_game.auxiliaries.isHover = false;
					
					setTimeout(function() {
						$(this).find(item_game.elements.itemLink).removeClass(item_game.auxiliaries.highlightClassName);
						$(this).find(item_game.elements.itemScore).removeClass(item_game.auxiliaries.highlightClassName);
					}.bind(this), 50);
				}
			}, item_game.elements.item);
			
			$('ul').on({
				mouseenter: function() {
					item_game.auxiliaries.isHover = false;
					
					$(this).parents(item_game.elements.itemScore).siblings(item_game.elements.itemLink).removeClass(item_game.auxiliaries.highlightClassName);
				},
				mouseleave: function() {
					$(this).parents(item_game.elements.itemScore).siblings(item_game.elements.itemLink).addClass(item_game.auxiliaries.highlightClassName);
				}
			}, item_game.elements.itemAddScoreButton);
		} else {
			$(item_game.elements.item).click(function(event) {
				if(!$(event.target).hasClass(item_game.elements.itemAddScoreButton.replace('.', '')) && !$(event.target).hasClass('oi')) {
					$(this).find(item_game.elements.itemLink).addClass(item_game.auxiliaries.highlightClassName);
					$(this).find(item_game.elements.itemScore).addClass(item_game.auxiliaries.highlightClassName);
				}
			});
		}
	}
	
};