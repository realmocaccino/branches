<?php
namespace App\Console\Jobs;

use App\Site\Models\{Game, User};
use App\Console\Mails\ReleasesOfTheWeekMail;

use Illuminate\Support\Facades\Mail;

class ReleasesOfTheWeekJob extends BaseJob
{
	public function handle()
	{
	    $games = Game::whereRaw("YEARWEEK(`release`, 1) = YEARWEEK(CURDATE(), 1)")->get();
	    $users = User::subscribed()->get();

	    if($games->count()) {
	        foreach($users as $user) {
	            Mail::to($user)->send(new ReleasesOfTheWeekMail($games, $user));

	            sleep(1);
	        }
	    }
	}
}