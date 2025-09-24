<?php
namespace App\Site\Presenters;

trait UserBadgesPresenter
{
    private $badges = [];

    public function retrieveBadges()
    {
        $this->getServiceYearsBadge();
        $this->getRatingBadge();
        $this->getReviewBadge();
        $this->getContributionBadge();
        $this->sortBadgesByRelevance();

        return $this->badges;
    }

    private function getServiceYearsBadge()
    {
        if ($serviceYears = $this->created_at->diffInYears() and $this->hasVisitedInTheLastYear()) {
            $this->badges[0] = [
                'asset' => sprintf('img/badges/years/%d.png', $serviceYears),
                'description' => $serviceYears . trans('presenters/user_badges.0')
            ];
        }
    }

    private function getRatingBadge()
    {
        $totalRatings = $this->total_ratings;

        if ($totalRatings >= 700) {
            $this->badges['1a'] = [
                'asset' => 'img/badges/tier2/gold.png',
                'description' => trans('presenters/user_badges.1a')
            ];
        } elseif ($totalRatings >= 500) {
            $this->badges['2a'] = [
                'asset' => 'img/badges/tier2/silver.png',
                'description' => trans('presenters/user_badges.2a')
            ];
        } elseif ($totalRatings >= 200) {
            $this->badges['3a'] = [
                'asset' => 'img/badges/tier2/bronze.png',
                'description' => trans('presenters/user_badges.3a')
            ];
        } elseif ($totalRatings >= 100) {
            $this->badges['4a'] = [
                'asset' => 'img/badges/tier1/gold.png',
                'description' => trans('presenters/user_badges.4a')
            ];
        } elseif ($totalRatings >= 50) {
            $this->badges['5a'] = [
                'asset' => 'img/badges/tier1/silver.png',
                'description' => trans('presenters/user_badges.5a')
            ];
        } elseif ($totalRatings >= 20) {
            $this->badges['6a'] = [
                'asset' => 'img/badges/tier1/bronze.png',
                'description' => trans('presenters/user_badges.6a')
            ];
        }
    }

    private function getReviewBadge()
    {
        $totalReviews = $this->total_reviews;
        $relevantReviews = $this->relevantReviewsAverage();

        if ($totalReviews >= 10) {
            if ($relevantReviews >= 0.9) {
                $this->badges['1b'] = [
                    'asset' => 'img/badges/tier2/gold.png',
                    'description' => trans('presenters/user_badges.1b')
                ];
            } elseif ($relevantReviews >= 0.7) {
                $this->badges['2b'] = [
                    'asset' => 'img/badges/tier2/silver.png',
                    'description' => trans('presenters/user_badges.2b')
                ];
            } elseif ($relevantReviews >= 0.5) {
                $this->badges['3b'] = [
                    'asset' => 'img/badges/tier2/bronze.png',
                    'description' => trans('presenters/user_badges.3b')
                ];
            } elseif ($relevantReviews >= 0.4) {
                $this->badges['4b'] = [
                    'asset' => 'img/badges/tier1/gold.png',
                    'description' => trans('presenters/user_badges.4b')
                ];
            } elseif ($relevantReviews >= 0.3) {
                $this->badges['5b'] = [
                    'asset' => 'img/badges/tier1/silver.png',
                    'description' => trans('presenters/user_badges.5b')
                ];
            } elseif ($relevantReviews >= 0.2) {
                $this->badges['6b'] = [
                    'asset' => 'img/badges/tier1/bronze.png',
                    'description' => trans('presenters/user_badges.6b')
                ];
            }
        }
    }

    private function getContributionBadge()
    {
        $totalContributions = $this->total_contributions;

        if ($totalContributions >= 200) {
            $this->badges['1c'] = [
                'asset' => 'img/badges/tier2/gold.png',
                'description' => trans('presenters/user_badges.1c')
            ];
        } elseif ($totalContributions >= 100) {
            $this->badges['2c'] = [
                'asset' => 'img/badges/tier2/silver.png',
                'description' => trans('presenters/user_badges.2c')
            ];
        } elseif ($totalContributions >= 50) {
            $this->badges['3c'] = [
                'asset' => 'img/badges/tier2/bronze.png',
                'description' => trans('presenters/user_badges.3c')
            ];
        } elseif ($totalContributions >= 25) {
            $this->badges['4c'] = [
                'asset' => 'img/badges/tier1/gold.png',
                'description' => trans('presenters/user_badges.4c')
            ];
        } elseif ($totalContributions >= 10) {
            $this->badges['5c'] = [
                'asset' => 'img/badges/tier1/silver.png',
                'description' => trans('presenters/user_badges.5c')
            ];
        } elseif ($totalContributions >= 5) {
            $this->badges['6c'] = [
                'asset' => 'img/badges/tier1/bronze.png',
                'description' => trans('presenters/user_badges.6c')
            ];
        }
    }

    private function sortBadgesByRelevance()
    {
        ksort($this->badges);
    }
}