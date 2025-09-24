<?php
namespace App\Console\Jobs;

use App\Site\Helpers\ListHelper;
use App\Site\Repositories\UserRepository;
use App\Console\Mails\WeMissYouMail;

use Illuminate\Support\Facades\{Cache, Mail};

class WeMissYouJob extends BaseJob
{
    private const CACHE_NAME = 'WeMissYouJobFeaturedGames';
    private const CACHE_DURATION = 3600;
    private const LIST_SLUG = 'featured-games';
    private const TOTAL_GAMES = 5;

	public function handle(ListHelper $listHelper, UserRepository $userRepository)
	{
        foreach($userRepository->getSubscribedsWhoNotVisitedIn30Days() as $user) {
            $this->sendMail($user, $listHelper);
            sleep(1);
        }
	}

    private function sendMail($user, $listHelper)
    {
        Mail::to($user)->send(new WeMissYouMail($user, $this->getFeaturedGames(
            $listHelper,
            optional($user->platform)->slug
        )));
    }

    private function getFeaturedGames($listHelper, $platformSlug)
    {
        $cacheName = self::CACHE_NAME . $platformSlug;

        return Cache::remember($cacheName, self::CACHE_DURATION, function() use($listHelper, $platformSlug) {
            $listHelper->setSlug(self::LIST_SLUG);

            if($platformSlug) {
                $listHelper->setPlatform($platformSlug);
            } else {
                $listHelper->resetPlatform();
            }

            return $listHelper->perPage(self::TOTAL_GAMES)->get();
        });
    }
}