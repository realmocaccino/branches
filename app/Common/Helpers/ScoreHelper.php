<?php
namespace App\Common\Helpers;

class ScoreHelper
{
	public const DEFAULT_SCORE = '8.0';
	public const MAXIMUM_SCORE = '10.0';
	public const MINIMUM_SCORE = '5.0';
	public const SCORE_INTERVAL = '0.1';

    public static $ranges = [
		'low' => [
			'className' => 'low',
			'startScore' => 0.0,
			'endScore' => 5.9
		],
		'medium' => [
			'className' => 'medium',
			'startScore' => 6.0,
			'endScore' => 7.9
		],
		'high' => [
			'className' => 'high',
			'startScore' => 8.0,
			'endScore' => 10.0
		]
	];
	
	public static function calculateAverage($dividend, $divider, $precision = 1)
	{
		$result = $divider ? round($dividend / $divider, $precision) : null;
		
		return self::checkScore($result);
	}

	private static function checkScore($result)
	{
		if($result) {
			if($result > self::MAXIMUM_SCORE) {
				$result = self::MAXIMUM_SCORE;
			} elseif($result < self::MINIMUM_SCORE) {
				$result = self::MINIMUM_SCORE;
			}
		}

		return $result;
	}

	public static function getGameCriteriaScoreByPlatform($game, $criteriaId, $platformId = null)
	{
		$query = $game->scores()->when($platformId, function($query) use($platformId) {
			return $query->wherePlatformId($platformId);
		})->whereCriteriaId($criteriaId);
		
		return self::calculateAverage($query->sum('value'), $query->count()) ?: self::MINIMUM_SCORE;
	}
}