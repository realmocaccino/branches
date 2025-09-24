<?php
namespace App\Site\Repositories;

use App\Site\Helpers\Site;
use App\Site\Models\{Game, User};

class RankingRepository
{
    protected $games;
    protected $users;

    protected $excludeCharacteristics;
    protected $minimumRatingsToRank;

    protected $contributionMultiplier;
    protected $ratingMultiplier;
    protected $reviewMultiplier;

    public function __construct(Game $game, User $user)
    {
        $this->games = $game;
        $this->users = $user;

        $this->excludeCharacteristics = config('site.exclude_characteristics_from_ranking');
        $this->minimumRatingsToRank = config('site.minimum_ratings_to_rank');

        $this->contributionMultiplier = config('site.multiplier_contribution');
		$this->ratingMultiplier = config('site.multiplier_rating');
		$this->reviewMultiplier = config('site.multiplier_review');
    }

    public function games($year)
    {
        return $this->games
        ->select('games.*')
        ->where('games.total_ratings', '>=', $this->minimumRatingsToRank)
        ->where('games.status', '=', 1)
        ->orderBy('games.score', 'desc')
        ->orderBy('games.total_ratings', 'desc')
        ->when($year, function($query) use($year) {
            return $query->whereYear('games.release', $year);
        });
        /*->when($this->excludeCharacteristics, function($query) {
            return $query->whereNotIn('games.id', function($query) {
                return $query->select('characteristic_game.game_id')
                    ->from('characteristic_game')
                    ->join('characteristics', 'characteristics.id', '=', 'characteristic_game.characteristic_id')
                    ->whereIn('characteristics.slug', $this->excludeCharacteristics);
            });
        });*/
    }

    public function users()
    {
        return $this->users
        ->selectRaw("
            ((total_ratings * {$this->ratingMultiplier}) + (total_reviews * {$this->reviewMultiplier}) + (total_contributions * {$this->contributionMultiplier})) AS total,
            users.*
        ")
        ->where('status', '=', 1)
        ->orderBy('total', 'desc')
        ->having('total', '>', '2')
        ->get();
    }

    public function usersByDateLimit($dateLimit)
    {
        return $this->users
        ->selectRaw("
            ((COUNT(DISTINCT ratings.id) * {$this->ratingMultiplier}) + (COUNT(DISTINCT reviews.id) * {$this->reviewMultiplier}) + (COUNT(DISTINCT contributions.id) * {$this->contributionMultiplier})) AS total,
            users.*
        ")
        ->leftJoin('ratings', function ($query) use ($dateLimit) {
            return $query->on('users.id', '=', 'ratings.user_id')->where('ratings.created_at', '>', $dateLimit)->whereNull('ratings.deleted_at');
        })
        ->leftJoin('reviews', function ($query) use ($dateLimit) {
            return $query->on('ratings.id', '=', 'reviews.rating_id')->where('reviews.created_at', '>', $dateLimit)->whereNull('reviews.deleted_at');
        })
        ->leftJoin('contributions', function ($query) use ($dateLimit) {
            return $query->on('users.id', '=', 'contributions.user_id')->where('contributions.created_at', '>', $dateLimit)->whereNull('contributions.deleted_at');
        })
        ->where('users.slug', '!=', Site::OFFICIAL_USER_SLUG)
        ->where('users.status', '=', 1)
        ->orderBy('total', 'desc')
        ->having('total', '>', '0')
        ->groupBy('users.id')
        ->get();
    }
}