<?php
namespace App\Common\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewRatingEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $rating;

    public function __construct($rating)
    {
        $this->rating = $rating;
    }

    public function getUser()
    {
        return $this->rating->user;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}