<?php
namespace App\Common\Services\Providers;

use App\Common\Events\{
    GameAddedEvent,
    NewCollectionEvent,
    NewRatingEvent,
    NewReviewEvent
};
use App\Common\Events\Listeners\{
    NewCollectionDiscordMessageListener,
    NewContributionListener,
    NewGameDiscordMessageListener,
    NewGameMailListener,
    NewReviewDiscordMessageListener,
    UpdateUserLevelListener
};

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        GameAddedEvent::class => [
            NewContributionListener::class,
            UpdateUserLevelListener::class,
            NewGameDiscordMessageListener::class
        ],
        NewCollectionEvent::class => [
            NewCollectionDiscordMessageListener::class
        ],
        NewRatingEvent::class => [
            UpdateUserLevelListener::class
        ],
        NewReviewEvent::class => [
            UpdateUserLevelListener::class,
            NewReviewDiscordMessageListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}
