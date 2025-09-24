<?php
namespace App\Site\Helpers;

use App\Common\Helpers\ScoreHelper;

class Chart
{
    public static function prepareDatasets($game, $userRating = null, $platformId = null)
    {
        if($platformId) {
            foreach($game->criterias as $criteria) {
                $gameCriteriaScores[] = ScoreHelper::getGameCriteriaScoreByPlatform($game, $criteria->id, $platformId);
            }
        } else {
            $gameCriteriaScores = $game->criterias()->withPivot('score')->pluck('score');
        }

        if($userRating) {
            $datasets[] = [
                'label' => trans('helpers/chart.my_rating'),
                'data' => $userRating->scores->pluck('value')
            ];
        }
        $datasets[] = [
            'label' => trans('helpers/chart.community_rating'),
            'data' => $gameCriteriaScores,
            'score' => $game->score
        ];

        return $datasets;
    }
}