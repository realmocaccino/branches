<?php
// Loose Pages
Route::get('/', 'HomeController@index')->name('home');
Route::get('{tag}/{slug}', 'TagController@index')->name('tag')->where('tag', 'characteristic|criteria|developer|franchise|genre|mode|platform|publisher|theme|year');
Route::get('list/{slug}/{platformSlug?}', 'ListController@index')->name('list');
Route::get('categories', 'CategoriesController@index')->name('categories');
Route::get('discover', 'DiscoverController@index')->name('discover');
//Route::get('community', 'CommunityController@index')->name('community');
Route::get('ratings', 'RatingsController@index')->name('ratings');
Route::get('reviews', 'ReviewsController@index')->name('reviews');
Route::get('contributions', 'ContributionsController@index')->name('contributions');
//Route::get('ranking/games/{year?}', 'RankingController@games')->name('ranking.games');
//Route::get('ranking/users/{period?}', 'RankingController@users')->name('ranking.users');
Route::get('awards/{year}', 'AwardsController@index')->name('awards');
Route::get('{contactPage}', 'ContactController@index')->name('contact.index')->where('contactPage', 'feedback|support');
Route::post('{contactPage}', 'ContactController@send')->name('contact.send')->where('contactPage', 'feedback|support');
Route::get('{institutionalPage}', 'InstitutionalController@index')->name('institutional')->where('institutionalPage', 'mission|terms|partnerships|privacy');
Route::get('notifications', 'NotificationsController@index')->name('notifications')->middleware('auth:site');

// Premium
Route::group(['prefix' => 'premium', 'as' => 'premium.'], function() {
    Route::get('/', 'PremiumController@index')->name('index');
    Route::get('checkout/{plan}', 'PremiumController@checkout')->name('checkout');
    Route::group(['middleware' => ['isNotPremium', 'ajax'], 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
        Route::get('/', 'PremiumController@index')->name('index');
        Route::get('checkout/{plan}', 'PremiumController@checkout')->name('checkout');
        Route::post('paymentIntent', 'PremiumController@paymentIntent')->name('paymentIntent');
        Route::post('subscribe', 'PremiumController@subscribe')->name('subscribe');
    });
});

// Loose Ajax Calls
Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
	Route::post('alert', 'AlertController@index')->name('alert');
	Route::post('redirect', 'RedirectController@index')->name('redirect');
});

// Mail Actions
Route::group(['prefix' => 'mail', 'as' => 'mail.'], function() {
    Route::get('unsubscribe/{email}', 'MailController@unsubscribe')->name('unsubscribe');
});

// Feed
Route::group(['prefix' => 'feed', 'as' => 'feed.'], function() {
    Route::get('following/{filterBy?}', 'FeedController@following')->name('following')->middleware('auth:site')->where('filterBy', 'ratings|reviews|collections|contributions|reviewFeedbacks|follows');
    Route::get('me/{filterBy?}', 'FeedController@me')->name('me')->middleware('auth:site')->where('filterBy', 'ratings|reviews|collections|contributions|reviewFeedbacks|follows');
    Route::get('/{filterBy?}', 'FeedController@index')->name('index')->where('filterBy', 'ratings|reviews|collections|contributions|reviewFeedbacks|follows');
});

// Search
Route::group(['prefix' => 'search', 'as' => 'search.'], function() {
    Route::get('/', 'SearchController@games')->name('games');
    Route::get('users', 'SearchController@users')->name('users');
    Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
	    Route::post('/', 'SearchController@games')->name('games');
	});
});

// Logout
Route::group(['middleware' => 'auth:site'], function() {
	Route::get('logout', 'LoginController@logout')->name('logout');
});

// Login
Route::group(['middleware' => 'guest:site', 'as' => 'login.'], function() {
	Route::get('login', 'LoginController@index')->name('index');
	Route::post('login', 'LoginController@authenticate')->name('authenticate');
	
	Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
		Route::get('login', 'LoginController@index')->name('index');
		Route::post('login', 'LoginController@authenticate')->name('authenticate');
	});
});

// Social Login
Route::group(['middleware' => 'guest:site', 'prefix' => 'social', 'as' => 'social.'], function() {
	Route::get('{provider}', 'SocialController@redirectToProvider')->name('redirect');
	Route::get('{provider}/callback', 'SocialController@handleProviderCallback')->name('callback');
});

// Register
Route::group(['middleware' => ['guest:site', 'blockIp'], 'as' => 'register.'], function() {
	Route::get('register', 'RegisterController@index')->name('index');
	Route::post('register', 'RegisterController@store')->name('store');
	Route::get('confirm-account/{token}', 'RegisterController@confirm')->name('confirm');

	Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
		Route::get('register', 'RegisterController@index')->name('index');
		Route::post('register', 'RegisterController@store')->name('store');
	});
});

// Password
Route::group(['middleware' => 'guest:site', 'as' => 'password.'], function() {
	Route::get('forgot-password', 'PasswordController@forgotPasswordPage')->name('forgotPassword');
	Route::post('send-token', 'PasswordController@sendToken')->name('sendToken');
	Route::get('redefine-password/{token}', 'PasswordController@redefinePasswordPage')->name('redefinePasswordPage');
	Route::post('redefine-password', 'PasswordController@redefinePassword')->name('redefinePassword');
});

// User
Route::group(['prefix' => 'user', 'as' => 'user.'], function() {
	Route::get('{userSlug}', 'UserController@index')->name('index');
	Route::get('{userSlug}/ratings', 'UserController@ratings')->name('ratings');
	Route::get('{userSlug}/ratings/common', 'UserController@commonRatings')->name('commonRatings')->middleware('auth:site');
	Route::get('{userSlug}/reviews', 'UserController@reviews')->name('reviews');
	Route::get('{userSlug}/contributions', 'UserController@contributions')->name('contributions');
	Route::get('{userSlug}/liked-reviews', 'UserController@likedReviews')->name('likedReviews');
	Route::get('{userSlug}/collections', 'UserController@collections')->name('collections');
	Route::get('{userSlug}/followers', 'UserController@followers')->name('followers');
	Route::get('{userSlug}/following', 'UserController@following')->name('following');
	Route::get('{userSlug}/follow', 'UserController@follow')->name('follow')->middleware('auth:site');
	Route::get('{userSlug}/unfollow', 'UserController@unfollow')->name('unfollow')->middleware('auth:site');
	Route::get('{userSlug}/favorites', 'UserController@favorites')->name('favorites');
	Route::get('{userSlug}/wishlist', 'UserController@wishlist')->name('wishlist');
});

// Account
Route::group(['middleware' => 'auth:site', 'prefix' => 'account', 'as' => 'account.'], function() {
	Route::get('/', 'AccountController@index')->name('index');
	Route::get('ratings', 'AccountController@ratings')->name('ratings');
	Route::get('reviews', 'AccountController@reviews')->name('reviews');
	Route::get('contributions', 'AccountController@contributions')->name('contributions');
	Route::get('liked-reviews', 'AccountController@likedReviews')->name('likedReviews');
	Route::get('collections', 'AccountController@collections')->name('collections');
	Route::get('followers', 'AccountController@followers')->name('followers');
	Route::get('following', 'AccountController@following')->name('following');
	Route::get('favorites', 'AccountController@favorites')->name('favorites');
	Route::get('wishlist', 'AccountController@wishlist')->name('wishlist');
	
	Route::group(['prefix' => 'edit', 'as' => 'edit.'], function() {
		Route::get('/', 'AccountController@editPage')->name('index');
		Route::post('/', 'AccountController@edit')->name('save');
		Route::get('email', 'AccountController@editEmailPage')->name('email');
		Route::post('email', 'AccountController@editEmail')->name('save.email');
	});
	
	Route::group(['prefix' => 'delete', 'as' => 'delete.'], function() {
		Route::get('/', 'AccountController@deletePage')->name('index');
		Route::post('/', 'AccountController@delete')->name('confirm');
	});
	
	Route::group(['prefix' => 'picture', 'as' => 'picture.'], function() {
		Route::get('/', 'AccountController@picture')->name('index');
		Route::post('upload', 'AccountController@uploadPicture')->name('upload');
		Route::get('delete', 'AccountController@deletePicture')->name('delete');
	});
	
	Route::group(['middleware' => 'premium', 'prefix' => 'background', 'as' => 'background.'], function() {
		Route::get('/', 'AccountController@background')->name('index');
		Route::post('upload', 'AccountController@uploadBackground')->name('upload');
		Route::get('delete', 'AccountController@deleteBackground')->name('delete');
	});
});

// Collections
Route::group(['prefix' => 'collections', 'as' => 'collections.'], function() {
    Route::get('/', 'CollectionsController@index')->name('index');
    Route::get('search', 'CollectionsController@search')->name('search');
});

// Collection
Route::group(['as' => 'collection.'], function() {
	Route::get('user/{userSlug}/collection/{collectionSlug}', 'CollectionController@index')->name('index');
	Route::group(['prefix' => 'collection'], function() {
		Route::group(['middleware' => 'auth:site'], function() {
			Route::get('{collectionSlug}/edit', 'CollectionController@editPage')->name('editPage')->middleware('isNotDefaultCollection');
			Route::get('{collectionSlug}/delete', 'CollectionController@deletePage')->name('deletePage');
			Route::get('{collectionSlug}/order', 'CollectionController@orderPage')->name('orderPage');
			Route::post('{collectionSlug}/edit', 'CollectionController@edit')->name('edit')->middleware('isNotDefaultCollection');
			Route::post('{collectionSlug}/delete', 'CollectionController@delete')->name('delete');
			Route::post('ajax/{collectionSlug}/order', 'CollectionController@order')->name('ajax.order')->middleware('ajax');
			Route::group(['prefix' => '{gameSlug}'], function() {
				Route::get('create', 'CollectionController@create')->name('create');
				Route::get('{collectionSlug}/add', 'CollectionController@add')->name('add');
				Route::get('{collectionSlug}/remove', 'CollectionController@remove')->name('remove');
			});
			Route::group(['middleware' => 'ajax', 'prefix' => 'ajax/{gameSlug}', 'as' => 'ajax.'], function() {
				Route::post('create', 'CollectionController@create')->name('create');
				Route::post('{collectionSlug}/add', 'CollectionController@add')->name('add');
				Route::post('{collectionSlug}/remove', 'CollectionController@remove')->name('remove');
			});
		});
	});
});

// Rating
Route::group(['middleware' => ['auth:site', 'checkGameAvailability:{gameSlug}'], 'prefix' => '{gameSlug}/rating', 'as' => 'rating.'], function() {
	Route::get('/', 'RatingController@index')->name('index');
	Route::post('/', 'RatingController@save')->name('save');
	Route::get('delete', 'RatingController@deletePage')->name('deletePage');
	Route::post('delete', 'RatingController@delete')->name('delete');
	
	Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
		Route::get('/', 'RatingController@index')->name('index');
		Route::post('/', 'RatingController@save')->name('save');
		Route::get('delete', 'RatingController@deletePage')->name('deletePage');
		Route::post('delete', 'RatingController@delete')->name('delete');
	});
});

// Review
Route::group(['middleware' => ['auth:site', 'checkGameAvailability:{gameSlug}'], 'prefix' => '{gameSlug}/review', 'as' => 'review.'], function() {
	Route::post('/', 'ReviewController@save')->name('save');
	Route::get('delete', 'ReviewController@delete')->name('delete');
	
	Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
		Route::post('/', 'ReviewController@save')->name('save');
		Route::post('delete', 'ReviewController@delete')->name('delete');
	});
});

// Review Feedback
Route::group(['middleware' => 'auth:site'], function() {
    Route::get('feedback/vote/{gameSlug}/{userSlug}/{feedback}', 'ReviewFeedbackController@vote')->name('feedback.vote');
});
Route::group(['middleware' => 'ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function() {
	Route::post('feedback/fetch/{reviewId}', 'ReviewFeedbackController@fetch')->name('feedback.fetch');
	Route::group(['middleware' => 'auth:site'], function() {
	    Route::post('feedback/vote/{gameSlug}/{userSlug}/{feedback}', 'ReviewFeedbackController@vote')->name('feedback.vote');
	});
});

// Add Game
Route::group(['middleware' => 'auth:site'], function() {
	Route::group(['prefix' => 'add/game', 'as' => 'add.game.'], function() {
		Route::get('/', 'AddGameController@index')->name('index');
		Route::get('search', 'AddGameController@search')->name('search');
        Route::get('choose', 'AddGameController@choose')->name('choose');
		Route::get('queue/{vendor}/{id}', 'AddGameController@queue')->name('queue');
	});
	Route::group(['prefix' => 'add/game', 'as' => 'request.game.'], function() {
		Route::post('/', 'AddGameController@save')->name('index');
	});
});

// Edit Game
Route::group(['middleware' => 'auth:site', 'prefix' => '{gameSlug}/edition', 'as' => 'game.edition.'], function() {
	Route::get('/', 'EditGameController@edition')->name('index');
	Route::post('request', 'EditGameController@editionRequest')->name('request');
});

// Forum
Route::group(['prefix' => 'forum', 'as' => 'forum.'], function() {
	Route::get('/', 'ForumController@forum')->name('index');
	Route::group(['middleware' => 'auth:site'], function() {
		Route::get('create', 'ForumController@createDiscussionPage')->name('create');
		Route::post('create-discussion', 'ForumController@createDiscussion')->name('createDiscussion');
		Route::post('answer-discussion/{discussionId}', 'ForumController@answerDiscussion')->name('answerDiscussion');
		Route::get('delete-discussion/{discussionId}', 'ForumController@deleteDiscussion')->name('deleteDiscussion');
		Route::get('delete-answer/{answerId}', 'ForumController@deleteAnswer')->name('deleteAnswer');
	});
	Route::get('{discussionId}', 'ForumController@discussion')->name('discussion');
});

// Game
Route::group(['prefix' => '{gameSlug}', 'as' => 'game.'], function() {
	Route::get('/', 'GameController@index')->name('index');
	Route::get('about', 'GameController@about')->name('about');
	Route::get('collections', 'GameController@collections')->name('collections');
	Route::get('contributions', 'GameController@contributions')->name('contributions');
	//Route::get('related', 'GameController@relateds')->name('relateds');
	Route::get('screenshots', 'GameController@screenshots')->name('screenshots');
	Route::get('trailer', 'GameController@trailer')->name('trailer');
	
	Route::group(['middleware' => ['checkGameAvailability:{gameSlug}']], function() {
		Route::get('ratings/{platformSlug?}', 'GameController@ratings')->name('ratings');
		Route::get('reviews/{platformSlug?}', 'GameController@reviews')->name('reviews');
		Route::get('review/{userSlug}', 'GameController@review')->name('review');
	});
	
	Route::get('search-for-release-date', 'GameController@searchForReleaseDate')->name('searchForReleaseDate');
	Route::group(['middleware' => 'auth:site'], function() {
		Route::get('remind-me', 'GameController@warnMe')->name('warnMe')->middleware('premium');
		Route::get('cancel-reminder', 'GameController@cancelWarnMe')->name('cancelWarnMe');
	});
	Route::group(['middleware' => 'isOfficialUser'], function() {
		Route::get('touch-up', 'GameController@touchUp')->name('touchUp');
	});
	
	Route::group(['prefix' => 'forum', 'as' => 'forum.'], function() {
		Route::get('/', 'GameController@forum')->name('index');
		Route::group(['middleware' => 'auth:site'], function() {
			Route::get('create', 'GameController@createDiscussionPage')->name('create');
			Route::post('create-discussion', 'GameController@createDiscussion')->name('createDiscussion');
			Route::post('answer-discussion/{discussionId}', 'GameController@answerDiscussion')->name('answerDiscussion');
			Route::get('delete-discussion/{discussionId}', 'GameController@deleteDiscussion')->name('deleteDiscussion');
			Route::get('delete-answer/{answerId}', 'GameController@deleteAnswer')->name('deleteAnswer');
		});
		Route::get('{discussionId}', 'GameController@discussion')->name('discussion');
	});
	
	Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'middleware' => 'ajax', 'namespace' => 'Ajax'], function() {
		Route::post('getCriteriasScoresByPlatform', 'GameController@getCriteriasScoresByPlatform')->name('getCriteriasScoresByPlatform');
	});
});
