$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
	}
});

var globals = {
    resendPostLogin: [],
    isLoginPage: function(content) {
        return typeof content == 'string' && content.indexOf('<div id="login-register">') != -1;
    }
};

var apps = {
	start: function() {
		mode.start();
		header.start();
		slider.start();
		score.start();
		sumup.start();
		add.start();
		ajax.start();
		alert.start();
		awards.start();
		chart.start();
		dialog.start();
		discover.start();
		dropdown.start();
		filter.start();
		gallery.start();
		game.start();
		game_edit.start();
		header_language.start();
		header_search.start();
		home_search.start();
		horizontalDraggable.start();
		item_game.start();
		item_rating.start();
		loading.start();	
		collections.start();
		login_register.start();
		multiple_select.start();
		overlay.start();
		premium.start();
		rating.start();
		review.start();
		review_feedback.start();
		scrolling.start();
		sides.start();
		sortable.start();
		tab.start();
		tooltip.start();
		totalizers.start();
	}
};

apps.start();