<?php
namespace App\Site\Helpers;

use App\Common\Helpers\RatingHelper;
use App\Common\Models\Review;
use App\Site\Jobs\{SearchForReleaseDateJob, TouchUpJob};
use App\Site\Helpers\{Chart, Site};
use App\Site\Models\{Game, Platform, User, WarnMe};

use Detection\MobileDetect;
use Illuminate\Support\Facades\{Cache, Route, View};

class GameHelper
{
    private const ONE_DAY_CACHED = 60 * 60 * 24;
    private const ONE_HOUR_CACHED = 60 * 60;
    private const REVIEW_DESCRIPTION_LIMIT = 120;
    private const REVIEW_DESCRIPTION_DELIMITER = '...';
    
    private $agent;
    private $game;
    private $user;

    public function __construct(MobileDetect $agent)
    {
        $this->agent = $agent;

        $this->setConfigProperties();
    }

    public function setGame(Game $game)
    {
        $this->game = $game;

        return $this;
    }

    public function setUser(?User $user)
    {
        $this->user = $user;

        return $this;
    }

    public function createWarnMe()
    {
        $warn = new WarnMe;
        $warn->game_id = $this->game->id;
        $warn->user_id = $this->user->id;
        $warn->save();

        return $warn;
    }
    
    public function getAboutTitle()
    {
        return $this->aboutTitle . $this->game->name;
    }

    public function getCollections()
    {
        return $this->game->collections->paginate($this->totalCollections);
    }

    public function getCollectionsTitle()
    {
        return $this->collectionsTitle . $this->game->name;
    }

    public function getContributionsTitle()
    {
        return $this->contributionsTitle . $this->game->name;
    }

    public function getDefaultDescription()
    {
        return $this->defaultDescription . $this->game->name;
    }

    public function getIndexTitle()
    {
        return $this->indexTitle . $this->game->name;
    }

    public function getOtherReviews(Review $excludedReview)
    {
		return $this->game->reviews()->where('reviews.id', '!=', $excludedReview->id)->take($this->totalOtherReviews)->inRandomOrder()->get();
    }

    public function getPlatform(?string $slug)
    {
        return $slug ? Platform::findBySlugOrFail($slug) : null;
    }

    public function getPlatformsToFilter()
    {
        return Platform::whereIn('id', $this->game->ratings()->pluck('platform_id'))->get();
    }

    public function getRatings(?Platform $platform)
    {
		return $this->game->ratings()->whereHas('user')->when($platform, function($query) use($platform) {
			return $query->wherePlatformId($platform->id);
		})->latest()->paginate($this->totalRatings);
    }

    public function getRatingsTitle(?Platform $platform)
    {
        return $this->ratingsTitle . $this->game->name . ($platform ? $this->ratingsTitleOn . $platform->name : null);
    }

    public function getRelateds()
    {
        return $this->game->relateds($this->totalRelateds);
    }

    public function getRelatedsTitle()
    {
        return $this->relatedsTitle . $this->game->name;
    }

    public function getReview(string $userSlug)
    {
		return $this->game->reviews()->whereHas('user', function($query) use($userSlug) {
		    return $query->where('slug', $userSlug);
		})->firstOrFail();
    }

    public function getReviewDescription(Review $review)
    {
        return trim(substr($review->text, 0, self::REVIEW_DESCRIPTION_LIMIT)) . self::REVIEW_DESCRIPTION_DELIMITER;
    }

    public function getReviewTitle(Review $review)
    {
        return $this->reviewTitle . $review->rating->user->name . $this->reviewTitleTo . $this->game->name;
    }

    public function getReviews(?Platform $platform)
    {
		return $this->game->reviews()->when($platform, function($query) use($platform) {
			return $query->whereHas('rating', function($query) use($platform) {
				return $query->wherePlatformId($platform->id);
			});
		})->orderByCredibility()->prioritizeUser($this->user)->paginate($this->totalReviews);
    }

    public function getReviewsTitle(?Platform $platform)
    {
        return $this->reviewsTitle . $this->game->name . ($platform ? $this->reviewsTitleOn . $platform->name : null);
    }

    public function getScreenshotsTitle()
    {
        return $this->screenshotsTitle . $this->game->name;
    }

    public function getTrailerTitle()
    {
        return $this->trailerTitle . $this->game->name;
    }

    public function getUserRating()
    {
        return $this->user ? RatingHelper::find($this->game, $this->user) : null;
    }

    public function getWarnMe()
    {
        return WarnMe::whereGameId($this->game->id)->whereUserId($this->user->id)->first();
    }

    public function searchForReleaseDate()
    {
        return SearchForReleaseDateJob::dispatch($this->game, $this->user);
    }

    public function shareDatasetsToView()
    {
        if($this->game->ratings->count()) {
            View::share('datasets', Chart::prepareDatasets($this->game, $this->getUserRating()));
        }
    }

    public function shareGameToView()
    {
        View::share('game', $this->game);
    }

    public function shareCommonVariablesToView()
    {
        View::share('defaultDescription', $this->getDefaultDescription());

        View::share('backgroundSize', $this->agent->isMobile() ? '576x324' : '1920x1080');
        View::share('gradientHeight', $this->agent->isMobile() ? '250px' : '280px');

        if($this->game->isAvailable()) {
            View::share('userRating', $this->getUserRating());

            if(Route::currentRouteName() == 'game.index') {
                $latestReviews = $this->game->reviews()->orderByCredibility()->prioritizeUser($this->user)->take($latestReviewsLimit = $this->getLatestReviewsLimit())->get();
                View::share('latestReviews', $latestReviews);
                View::share('latestReviewsLimit', $latestReviewsLimit);
            }
        } elseif($this->user) {
            View::share('askedToWarn', $this->user->warns()->whereGameId($this->game->id)->whereNull('sent')->first());
        }

        $latestDiscussions = $this->game->discussions()->take($this->latestDiscussionsLimit)->get();
        View::share('latestDiscussionsLimit', $this->latestDiscussionsLimit);
        View::share('latestDiscussions', $latestDiscussions);

        $latestCollections = $this->game->collections()->onlyCustom()->notPrivate()->withAtLeastThreeGames()->take($this->latestCollectionsLimit)->get();
        View::share('latestCollectionsLimit', $this->latestCollectionsLimit);
        View::share('latestCollections', $latestCollections);

        // $rankingGames = Cache::remember('rankingGames' . $this->game->slug, self::ONE_HOUR_CACHED, function() {
        //     return $this->game->getRankingGames();
        // });
        $rankingGames = [];
        View::share('rankingGames', $this->canShowRanking($rankingGames) ? $rankingGames : []);

        View::share('screenshots', $this->game->screenshots()->inRandomOrder()->take($this->totalScreenshots)->get());

        View::share('buttonsTooltip', $this->game->getCollectionButtons($this->user));

        View::share('relatedGames', Cache::remember('relatedGames' . $this->game->slug, self::ONE_DAY_CACHED, function() {
            return $this->game->relateds($this->totalRelatedGames);
        }));

        View::share('isOfficialUser', $this->user ? Site::isOfficialUser($this->user) : false);
    }

    public function shareRatersToView()
    {
        $ratersWithPicture = $this->game->ratings()->whereHas('user', function($query) {
            return $query->where('picture', '!=', '');
        })->take($this->totalRaters)->get()->pluck('user');

        $moreRaters = null;
        if($this->game->ratings()->count() > $ratersWithPicture->count()) {
            $moreRaters = $this->game->ratings()->count() - $ratersWithPicture->count();
        }

        View::share('raters', $ratersWithPicture);
        View::share('moreRaters', $moreRaters);
    }

    public function touchUp()
    {
        return TouchUpJob::dispatch($this->game);
    }

    public function wishlist()
    {
        $this->user->wishlistGames()->syncWithoutDetaching($this->game->id);
    }

    private function canShowRanking($ranking)
    {
        return count($ranking) >= $this->minimumToShowRanking;
    }
    
    private function getLatestReviewsLimit()
    {
        if($this->agent->isMobile()) {
            return $this->totalLatestReviewsMobile;
        } elseif($userRating = $this->getUserRating() and !$userRating->review()->exists()) {
            return $this->totalLatestReviews - 1;
        }

        return $this->totalLatestReviews;
    }

    private $totalRelatedGames;
    private $latestCollectionsLimit;
    private $latestDiscussionsLimit;
    private $minimumToShowRanking;
    private $totalCollections;
    private $totalLatestReviews;
    private $totalLatestReviewsMobile;
    private $totalOtherReviews;
    private $totalRaters;
    private $totalRatings;
    private $totalRelateds;
    private $totalReviews;
    private $totalScreenshots;

    private $aboutTitle;
    private $collectionsTitle;
    private $contributionsTitle;
    private $defaultDescription;
    private $indexTitle;
    private $ratingsTitle;
    private $ratingsTitleOn;
    private $relatedsTitle;
    private $reviewTitle;
    private $reviewTitleTo;
    private $reviewsTitle;
    private $reviewsTitleOn;
    private $screenshotsTitle;
    private $trailerTitle;

    private function setConfigProperties()
    {
        $this->totalRelatedGames = config('site.game_index_total_relateds');
        $this->latestCollectionsLimit = $this->agent->isMobile() ? config('site.game_index_total_collections_mobile') : config('site.game_index_total_collections');
        $this->latestDiscussionsLimit = config('site.game_index_total_discussions');
        $this->minimumToShowRanking = config('site.game_minimum_to_show_ranking');
        $this->totalLatestReviews = config('site.game_index_total_reviews');
        $this->totalLatestReviewsMobile = config('site.game_index_total_reviews_mobile');
        $this->totalCollections = config('site.game_collections_per_page');
        $this->totalOtherReviews = config('site.game_review_other_reviews');
        $this->totalRaters = config('site.game_index_total_raters');
        $this->totalRatings = config('site.game_ratings_per_page');
        $this->totalRelateds = config('site.game_relateds_per_page');
        $this->totalReviews = $this->agent->isMobile() ? config('site.game_reviews_per_page_mobile') : config('site.game_reviews_per_page');
        $this->totalScreenshots = config('site.game_index_total_screenshots');

        $this->aboutTitle = trans('game/about.title');
        $this->collectionsTitle = trans('game/collections.title');
        $this->contributionsTitle = trans('game/contributions.title');
        $this->defaultDescription = trans('game/index.description');
        $this->indexTitle = trans('game/index.title');
        $this->ratingsTitle = trans('game/ratings.title');
        $this->ratingsTitleOn = trans('game/ratings.title_on');
        $this->relatedsTitle = trans('game/relateds.title');
        $this->reviewTitle = trans('game/review.title');
        $this->reviewTitleTo = trans('game/review.title_to');
        $this->reviewsTitle = trans('game/reviews.title');
        $this->reviewsTitleOn = trans('game/reviews.title_on');
        $this->screenshotsTitle = trans('game/screenshots.title') . trans('game/screenshots.title_of');
        $this->trailerTitle = trans('game/screenshots.title') . trans('game/screenshots.title_of');
    }
}