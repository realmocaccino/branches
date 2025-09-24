<?php
namespace App\Common\Helpers;

use App\Common\Events\NewRatingEvent;
use App\Common\Helpers\{ReviewHelper, ScoreHelper};
use App\Common\Models\{Rating, Score};

use Exception;

class RatingHelper
{
	protected $isNew;
	protected $game;
	protected $user;
	protected $rating;
	protected $platform;
	protected $originalPlatform;

	public function __construct($game, $user, $rating = null)
	{
		$this->game = $game;
		$this->user = $user;
		$this->rating = $rating ?? self::find($this->game, $this->user) ?? new Rating;
	}

	public static function find($game, $user)
	{
		return $user ? $game->ratings()->whereHas('user')->whereUserId($user->id)->first() : null;
	}
	
	public function save($request)
	{
		$this->isNew = !$this->rating->exists;
		$this->setPlatform($request->platform_id);
		if($this->rating->exists and $this->rating->platform_id != $request->platform_id) {
			$this->setOriginalPlatform();
		}

		$this->disableTimestamps();
		$this->saveRating($request);
		$this->saveScores($request);
		$this->incrementTotalizers();
		$this->updateGameScore();
		$this->updateGamePlatformScore($this->platform);
		if($this->originalPlatform) {
			$this->updateGamePlatformScore($this->originalPlatform);
		}
		$this->updateGameCriteriasScores();
		$this->triggerEvent();
		
		return $this->rating;
	}
	
	public function delete()
	{
		if(!$this->rating->exists) throw new Exception('Avaliação não encontrada.');
		
		$this->setPlatform($this->rating->platform_id);

		if($this->rating->review) {
			$reviewHelper = new ReviewHelper($this->rating);
			$reviewHelper->delete();
		}

		$this->disableTimestamps();
		$this->deleteScores();
		$this->deleteRating();
		$this->decrementTotalizers();
		$this->updateGameScore();
		$this->updateGamePlatformScore($this->platform);
		$this->updateGameCriteriasScores();
	}
	
	public function isInadequateRating($request)
	{
        if(!$this->user->isNewcomer()) return false;

    	$scores = array_unique(array_values($request->criterias));
        $average = $this->calculateRatingScore($request);

    	return ($average == ScoreHelper::DEFAULT_SCORE and count($scores) == 1) or $average == ScoreHelper::MINIMUM_SCORE;
	}

	public function isNew()
	{
		return $this->isNew;
	}
	
	protected function calculateRatingScore($request)
	{
		$scoreSum = 0;
    	$weightSum = 0;
    	
		foreach($this->game->criterias as $criteria) {
			$scoreSum += $request->criterias[$criteria->slug] * $criteria->weight;
    		$weightSum += $criteria->weight;
		}
		
		return ScoreHelper::calculateAverage($scoreSum, $weightSum);
	}
	
	protected function decrementTotalizers()
	{
		$this->game->decrement('total_ratings');
		$this->user->decrement('total_ratings');
		$this->platform->pivot->decrement('total');
	}
	
	protected function deleteRating()
	{
		$this->rating->delete();
	}
	
	protected function deleteScores()
	{
		$this->rating->scores(false)->delete();
	}
	
	protected function disableTimestamps()
	{
		$this->game->timestamps = false;
		$this->user->timestamps = false;
	}
	
	protected function incrementTotalizers()
	{
		if($this->isNew) {
			$this->game->increment('total_ratings');
			$this->user->increment('total_ratings');
		} elseif($this->originalPlatform) {
			$this->originalPlatform->pivot->decrement('total');
		}

		$this->platform->pivot->increment('total');
	}
	
	protected function saveRating($request)
	{
		$this->rating->platform_id = $this->platform->id;
		$this->rating->game_id = $this->game->id;
		$this->rating->user_id = $this->user->id;
		$this->rating->score = $this->calculateRatingScore($request);
		$this->rating->save();
	}
	
	protected function saveScores($request)
	{
		foreach($this->game->criterias as $criteria) {
			$score = $this->rating->scores()->whereCriteriaId($criteria->id)->first() ?? new Score;
			$score->rating()->associate($this->rating);
			$score->criteria()->associate($criteria);
			$score->value = $request->criterias[$criteria->slug];
			$score->save();
		}
	}
	
	protected function setOriginalPlatform()
	{
		$this->originalPlatform = $this->game->platforms()->where('platforms.id', $this->rating->platform_id)->first();
	}
	
	protected function setPlatform($platformId)
	{
		$this->platform = $this->game->platforms()->where('platforms.id', $platformId)->first();
	}

	protected function triggerEvent()
	{
		if($this->isNew) event(new NewRatingEvent($this->rating));
	}
	
	protected function updateGameCriteriasScores()
	{
		foreach($this->game->criterias as $criteria) {
			$criteriaScores = $this->game->scores()->whereCriteriaId($criteria->id);

			$criteria->pivot->score = ScoreHelper::calculateAverage($criteriaScores->sum('value'), $criteriaScores->count());
			$criteria->pivot->save();
		}
	}
	
	protected function updateGamePlatformScore($platform)
	{
		$platformRatings = $this->game->ratings()->wherePlatformId($platform->id);

		$platform->pivot->score = ScoreHelper::calculateAverage($platformRatings->sum('score'), $platformRatings->count());
		$platform->pivot->save();
	}
	
	protected function updateGameScore()
	{
		$this->game->score = ScoreHelper::calculateAverage($this->game->ratings()->sum('score'), $this->game->ratings()->count());
		$this->game->save();
	}
}
