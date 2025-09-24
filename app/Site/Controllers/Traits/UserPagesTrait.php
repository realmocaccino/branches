<?php
namespace App\Site\Controllers\Traits;

use App\Site\Models\Game;

trait UserPagesTrait
{
	public function index()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/index.title_account') : trans('user/index.title_user') . $this->user->name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();

		$bestRecentRatingsLimit = $this->agent->isMobile() ? config('site.user_index_total_best_recent_ratings_mobile') : config('site.user_index_total_best_recent_ratings');
		$collectionsLimit = $this->agent->isMobile() ? config('site.user_index_total_collections_mobile') : config('site.user_index_total_collections');
		$contributionsLimit = $this->agent->isMobile() ? config('site.user_index_total_contributions_mobile') : config('site.user_index_total_contributions');
		$favoriteGamesLimit = $this->agent->isMobile() ? config('site.user_index_total_favorite_games_mobile') : config('site.user_index_total_favorite_games');
		$followingsLimit = $this->agent->isMobile() ? config('site.user_index_total_followings_mobile') : config('site.user_index_total_followings');
		$followersLimit = $this->agent->isMobile() ? config('site.user_index_total_followers_mobile') : config('site.user_index_total_followers');
		$mostLikedReviewsLimit = $this->agent->isMobile() ? config('site.user_index_total_most_liked_reviews_mobile') : config('site.user_index_total_most_liked_reviews');
		$playingGamesLimit = $this->agent->isMobile() ? config('site.user_index_playing_games_mobile') : config('site.user_index_total_playing_games');
		$ratingsLimit = $this->agent->isMobile() ? config('site.user_index_total_ratings_mobile') : config('site.user_index_total_ratings');
		$reviewsLimit = $this->agent->isMobile() ? config('site.user_index_total_reviews_mobile') : config('site.user_index_total_reviews');
		$wishlistGamesLimit = $this->agent->isMobile() ? config('site.user_index_total_wishlist_games_mobile') : config('site.user_index_total_wishlist_games');

		$ratings = $this->user->ratings()->take($ratingsLimit)->get();
		
		return $this->view('user.index', [
			'bestRecentRatings' => $this->user->bestRecentRatings()->when($ratings->count(), function($query) use($ratings) {
				return $query->whereNotIn('ratings.id', $ratings->pluck('id'));
			})->take($bestRecentRatingsLimit)->get(),
			'collections' => $this->user->collections()->onlyCustom()->withGames()->when(!$this->isLoggedInUser, function($query) {
		        return $query->notPrivate();
		    })->take($collectionsLimit)->get(),
			'collectionsLimit' => $collectionsLimit,
			'contributions' => $this->user->contributions()->take($contributionsLimit)->get(),
			'favoriteGames' => $this->user->favoriteGames()->take($favoriteGamesLimit)->get(),
			'followings' => $this->user->followings()->paginate($followingsLimit),
			'followers' => $this->user->followers()->paginate($followersLimit),
			'mostLikedReviews' => $this->user->mostLikedReviews()->take($mostLikedReviewsLimit)->get(),
			'playingGames' => $this->user->playingGames()->take($playingGamesLimit)->get(),
			'ratings' => $this->user->ratings()->take($ratingsLimit)->get(),
			'ratingsLimit' => $ratingsLimit,
			'reviews' => $this->user->reviews()->take($reviewsLimit)->get(),
			'reviewsLimit' => $reviewsLimit,
			'wishlistGames' => $this->user->wishlistGames()->take($wishlistGamesLimit)->get()
		]);
	}
	
	public function ratings()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/ratings.title_account') : trans('user/ratings.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/ratings.title_account') : trans('user/ratings.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = $this->agent->isMobile() ? config('site.user_total_ratings_mobile') : config('site.user_total_ratings');
		$ratings = $this->user->ratings()->select('ratings.*')->join('games', 'ratings.game_id', '=', 'games.id')->where('games.status', 1);
		$filter = $this->filter->setQuery($ratings)->perPage($perPage)->areRatings()->prepare();
		
		return $this->view('user.ratings', [
			//'filter' => $this->filter->getBars(),
			'ratings' => $filter->get(),
			'total' => $filter->count()
		]);
	}

	public function commonRatings()
	{
		if ($this->isLoggedInUser) {
			return redirect()->route('account.ratings');
		}

		$this->head->setTitle(trans('user/commonRatings.title') . $this->user->name);
		$this->head->setInternalTitle(trans('user/commonRatings.title') . $this->user->name);
		$this->head->disableSearchIndexing();
		
		$perPage = $this->agent->isMobile() ? config('site.user_total_ratings_mobile') : config('site.user_total_ratings');
		$ratings = $this->user->commonRatings($this->loggedInUser)->paginate($perPage);
		
		return $this->view('user.ratings', [
			'ratings' => $ratings,
			'total' => $ratings->total()
		]);
	}
	
	public function reviews()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/reviews.title_account') : trans('user/reviews.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/reviews.title_account') : trans('user/reviews.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_reviews');
		$reviews = $this->user->reviews()->select('reviews.*')->join('games', 'ratings.game_id', '=', 'games.id')->where('games.status', 1);
		$filter = $this->filter->setQuery($reviews)->perPage($perPage)->areRatings()->prepare();
		
		return $this->view('user.reviews', [
			//'filter' => $this->filter->getBars(),
			'reviews' => $filter->get(),
			'total' => $filter->count()
		]);
	}
	
	public function collections()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/collections.title_account') : trans('user/collections.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/collections.title_account') : trans('user/collections.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_collections');
		if($this->isLoggedInUser) {
		    $collections = $this->user->collections()->paginate($perPage);
		} else {
		    $collections = $this->user->collections()->notPrivate()->withGames()->paginate($perPage);
		}
		
		return $this->view('user.collections', [
		    'collections' => $collections,
			'total' => $collections->count()
		]);
	}
	
	public function followers()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/followers.title_account') : trans('user/followers.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/followers.title_account') : trans('user/followers.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_followers');
		$followers = $this->user->followers()->paginate($perPage);
		
		return $this->view('user.followers', [
		    'followers' => $followers,
			'total' => $followers->total()
		]);
	}
	
	public function following()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/followings.title_account') : trans('user/followings.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/followings.title_account') : trans('user/followings.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_following');
		$followings = $this->user->followings()->paginate($perPage);
		
		return $this->view('user.following', [
		    'followings' => $followings,
			'total' => $followings->total()
		]);
	}
	
	public function contributions()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/contributions.title_account') : trans('user/contributions.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/contributions.title_account') : trans('user/contributions.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = $this->agent->isMobile() ? config('site.user_total_contributions_mobile') : config('site.user_total_contributions');
		$contributions = $this->user->contributions()->orderBy('contributions.created_at', 'desc')->select('*', 'contributions.created_at');
		
		return $this->view('user.contributions', [
			'total' => $contributions->count(),
			'contributions' => $contributions->paginate($perPage)
		]);
	}
	
	public function likedReviews()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/likedReviews.title_account') : trans('user/likedReviews.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/likedReviews.title_account') : trans('user/likedReviews.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_liked_reviews');
		$feedbacks = $this->user->positiveReviewsFeedbacksGiven()->paginate($perPage);
		
		return $this->view('user.likedReviews', [
			'feedbacks' => $feedbacks,
			'total' => $feedbacks->total()
		]);
	}

	public function favorites()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/favorites.title_account') : trans('user/favorites.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/favorites.title_account') : trans('user/favorites.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_favorites');
		$games = $this->user->favoriteGames()->paginate($perPage);
		
		return $this->view('user.favorites', [
			'games' => $games,
			'total' => $games->total()
		]);
	}

	public function wishlist()
	{
		$this->head->setTitle($this->isLoggedInUser ? trans('user/wishlist.title_account') : trans('user/wishlist.title_user') . $this->user->name);
		$this->head->setInternalTitle($this->isLoggedInUser ? trans('user/wishlist.title_account') : trans('user/wishlist.title_user') . $this->user->first_name);
		if($this->isLoggedInUser) $this->head->disableSearchIndexing();
		
		$perPage = config('site.user_total_wishlist');
		$games = $this->user->wishlistGames()->paginate($perPage);
		
		return $this->view('user.wishlist', [
			'games' => $games,
			'total' => $games->total()
		]);
	}
}