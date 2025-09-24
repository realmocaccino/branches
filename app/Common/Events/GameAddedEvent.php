<?php
namespace App\Common\Events;

use App\Common\Models\Settings;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameAddedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $game, $settings, $user;

    public function __construct($game, $user = null)
    {
        $this->game = $game;
        $this->user = $user;
        $this->settings = (new Settings)->get();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}