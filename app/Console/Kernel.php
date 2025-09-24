<?php
namespace App\Console;

use App\Console\Jobs\{
	BackupDatabaseJob,
    CacheCategoriesJob,
    CacheDefaultSearchGamesJob,
	CacheFeaturedGamesListJob,
    CacheSteamCatalogJob,
    CustomRoutinesJob,
	ReleasesOfTheWeekJob,
	WarnMeJob,
	WeMissYouJob
};
use App\Site\Helpers\LanguageHelper;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    const DEFAULT_LANGUAGE = 'pt';

    public function bootstrap()
    {
		parent::bootstrap();

		//$this->load(__DIR__. '/Commands');

		(new LanguageHelper)->setLanguage(self::DEFAULT_LANGUAGE);
    }

    protected function schedule(Schedule $schedule)
    {
    	$schedule->job(new BackupDatabaseJob)->dailyAt('4:00');
        $schedule->command('ratings:checkForMissingCriteria')->dailyAt('4:05');
        $schedule->command('games:checkForRepair')->dailyAt('4:10');
        $schedule->command('users:checkForRepair')->dailyAt('4:15');
        $schedule->job(new CacheSteamCatalogJob)->dailyAt('4:20');
        $schedule->command('games:crawlUpcomingGames --dont-ask')->dailyAt('4:25');
        $schedule->job(new CacheCategoriesJob)->daily('4:35');
        $schedule->job(new CustomRoutinesJob)->dailyAt('4:40');
    	$schedule->command('games:fetchCriticScoreToGameReleases')->twiceDaily(6, 18);
    	$schedule->job(new WarnMeJob)->dailyAt('8:00');
    	$schedule->job(new ReleasesOfTheWeekJob)->weekly()->mondays()->at('8:00');
    	$schedule->job(new WeMissYouJob)->monthly()->fridays()->at('8:00');
        $schedule->job(new CacheDefaultSearchGamesJob)->daily();
        $schedule->job(new CacheFeaturedGamesListJob)->daily();
    	$schedule->command('games:searchForReleaseDateOfUpcomingGames --force')->twiceDaily(5, 17);
        $schedule->command('games:touchupUpcomingGames')->weekly()->wednesdays()->at('3:00');
        $schedule->command('cache:prune-stale-tags')->hourly();
    }

    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
