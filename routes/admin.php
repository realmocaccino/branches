<?php
Route::group(['middleware' => 'guest:admin'], function()
{
	Route::get('login', 'LoginController@index')->name('login.index');
	Route::post('autenticar', 'LoginController@authenticate')->name('login.authenticate');
});

Route::group(['middleware' => 'auth:admin'], function()
{
	Route::get('logout', 'LoginController@logout')->name('logout');

	Route::get('/', 'HomeController@index')->name('home');

	Route::group(['prefix' => 'account'], function()
	{
		Route::get('edit', 'AccountController@edit')->name('account.edit');
		Route::put('update', 'AccountController@update')->name('account.update');
		Route::get('password', 'AccountController@password')->name('account.edit_password');
		Route::put('update_password', 'AccountController@updatePassword')->name('account.update_password');
	});

	Route::group(['middleware' => 'permission:administrator'], function()
	{
        Route::get('routine/clean-cache', 'RoutineController@cleanCache')->name('routine.clean_cache');
		Route::group(['prefix' => 'settings'], function()
		{
			Route::get('/', 'SettingsController@edit')->name('settings.edit');
			Route::put('update', 'SettingsController@update')->name('settings.update');
		});
		
		Route::get('ratings/{relationship}/{column}/{value}', 'RatingController@index');
		Route::get('reviews/{relationship}/{column}/{value}', 'ReviewController@index');
		Route::get('links/{relationship}/{column}/{value}', 'LinkController@index');
		Route::get('advertisements/{relationship}/{column}/{value}', 'AdvertisementController@index');
		
		Route::group(['middleware' => 'ajax', 'namespace' => 'Ajax', 'prefix' => 'ajax', 'as' => 'ajax.'], function()
		{
			Route::get('ratings/edit/platforms/{game_id}', 'RatingController@getPlatformsByGame')->name('ratings.edit.platforms');
		});
		
		Route::resources([
			'administrators' => 'AdministratorController',
			'roles' => 'RoleController',
			'users' => 'UserController',
			'ratings' => 'RatingController',
			'reviews' => 'ReviewController',
			'criterias' => 'CriteriaController',
			'banners' => 'BannerController',
			'links' => 'LinkController',
			'menus' => 'MenuController',
			'news' => 'NewsController',
			'institutionals' => 'InstitutionalController',
			'rules' => 'RuleController',
			'contacts' => 'ContactController',
            'plans' => 'PlanController',
            'subscriptions' => 'SubscriptionController',
			'advertisements' => 'AdvertisementController',
			'advertisers' => 'AdvertiserController'
		]);
	});
	
	Route::get('contributions', 'ContributionController@index')->name('contributions.index');
	Route::delete('contributions/{id}', 'ContributionController@destroy')->name('contributions.destroy');
	
	Route::get('editionRequests', 'EditionRequestController@index')->name('editionRequests.index');
	Route::get('editionRequests/view/{id}', 'EditionRequestController@viewRequest')->name('editionRequests.view');
	Route::get('editionRequests/approve/{id}', 'EditionRequestController@approve')->name('editionRequests.approve');
	Route::get('editionRequests/discard/{id}', 'EditionRequestController@discard')->name('editionRequests.discard');
	
	Route::resources([
		'characteristics' => 'CharacteristicController',
		'classifications' => 'ClassificationController',
		'developers' => 'DeveloperController',
		'manufacturers' => 'ManufacturerController',
		'franchises' => 'FranchiseController',
		'genres' => 'GenreController',
		'generations' => 'GenerationController',
		'games' => 'GameController',
		'modes' => 'ModeController',
		'platforms' => 'PlatformController',
		'publishers' => 'PublisherController',
		'themes' => 'ThemeController',
		'discussions' => 'DiscussionController',
		'answers' => 'AnswerController'
	]);
	
	Route::get('games/{relationship}/{column}/{value}', 'GameController@index');
	Route::get('platforms/{relationship}/{column}/{value}', 'PlatformController@index');
	Route::get('answers/{relationship}/{column}/{value}', 'AnswerController@index');
});