<?php
namespace App\Common\Events\Listeners;

use App\Site\Mails\GameAddedMail;

use Illuminate\Support\Facades\Mail;

class NewGameMailListener
{
    public function __construct() {}

    public function handle($event)
    {
        Mail::to($event->settings->email)->send(new GameAddedMail($event->game, $event->user));
    }
}