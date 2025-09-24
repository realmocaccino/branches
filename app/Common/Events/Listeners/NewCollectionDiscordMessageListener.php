<?php
namespace App\Common\Events\Listeners;

use App\Common\Clients\CurlClient;
use App\Common\DTOs\DiscordMessageDto;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCollectionDiscordMessageListener implements ShouldQueue
{
    private $client;
    private $data;

    public function __construct(CurlClient $client, DiscordMessageDto $data)
    {
        $this->client = $client;
        $this->data = $data;
    }

    public function handle($event)
    {
        if(app()->isLocal()) return null;
        
        $this->client->post(
            $url = config('discord.webhooks.new_collection'),
            $data = $this->getData($event),
            $headers = [
                'Content-type: application/json'
            ]
        );
    }

    private function getData($event)
    {
        $this->data->setTitle($event->collection->name);
        $this->data->setUrl(route('collection.index', [
            'userSlug' => $event->collection->user->slug,
            'collectionSlug' => $event->collection->slug
        ]));
        $this->data->setThumbnail(optional($event->collection->games->first())->getCover('150x185'));
        $this->data->setFooter([
            'text' => $event->collection->user->name,
            'icon_url' => $event->collection->user->getPicture('34x34')
        ]);

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}