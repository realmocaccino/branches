<?php
namespace App\Console\Jobs;

use App\Console\Notifications\WarnMeNotification;
use App\Site\Models\{Game, User};

class WarnMeJob
{
	public function handle()
	{
		$games = Game::whereRelease(date('Y-m-d'))->get();
		
		foreach($games as $game) {
			foreach($game->warnsToSend()->get() as $warn) {
				$user = User::find($warn->user->id);
				
				if($user) {
					$user->notify(new WarnMeNotification($game));
					$warn->sent = 1;
					$warn->save();
				
					sleep(1);
				}
			}
		}
	}
}
