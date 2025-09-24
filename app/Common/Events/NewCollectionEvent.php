<?php
namespace App\Common\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewCollectionEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}