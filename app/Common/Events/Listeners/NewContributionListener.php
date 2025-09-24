<?php
namespace App\Common\Events\Listeners;

use App\Common\Models\Contribution;

class NewContributionListener
{
    public function __construct() {}

    public function handle($event)
    {
        if ($event->user) {
            $contribution = new Contribution();
            $contribution->user_id = $event->user->id;
            $contribution->game_id = $event->game->id;
            $contribution->status = 1;
            $contribution->type = 'game_creation';
            $contribution->save();

            $event->user->increment('total_contributions');
        }
    }
}