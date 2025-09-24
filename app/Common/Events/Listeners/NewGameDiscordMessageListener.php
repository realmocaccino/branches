<?php
namespace App\Common\Events\Listeners;

use App\Common\Clients\CurlClient;
use App\Common\DTOs\DiscordMessageDto;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewGameDiscordMessageListener implements ShouldQueue
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

        if(!$this->isCandidateGame($event->game)) return null;
        
        $this->client->post(
            $url = config('discord.webhooks.new_game'),
            $data = $this->getData($event),
            $headers = [
                'Content-type: application/json'
            ]
        );
    }

    private function isCandidateGame($game)
    {
        return $game->isNewRelease() or $game->isComing() or $game->isUndated();
    }

    private function getData($event)
    {
        $this->data->setTitle($event->game->name);
        $this->data->setUrl(route('game.index', [
            'gameSlug' => $event->game->slug
        ]));
        $this->data->setDescription($event->game->description);
        $this->data->setThumbnail($event->game->getCover('150x185'));
        $this->data->setFields([
            [
                'name' => 'Lançamento',
                'value' => $event->game->release ? $event->game->release->format('d/m/Y') : 'TBA',
                'inline' => true
            ],
            [
                'name' => 'Gênero',
                'value' => $event->game->genres()->count() ? $event->game->genres()->first()->name_pt : '-',
                'inline' => true
            ]
        ]);
        $this->data->setFooter([
            'text' => optional($event->user)->name,
            'icon_url' => $event->user ? $event->user->getPicture('34x34') : null
        ]);

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}