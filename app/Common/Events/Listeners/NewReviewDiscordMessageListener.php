<?php
namespace App\Common\Events\Listeners;

use App\Common\Clients\CurlClient;
use App\Common\DTOs\DiscordMessageDto;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewReviewDiscordMessageListener implements ShouldQueue
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

        if(!$this->isCandidateReview($event->review)) return null;

        $this->client->post(
            $url = config('discord.webhooks.new_review'),
            $data = $this->getData($event),
            $headers = [
                'Content-type: application/json'
            ]
        );
    }

    private function isCandidateReview($review)
    {
        return $review->game->isNewRelease() and !$review->hasSpoilers(); 
    }

    private function getData($event)
    {
        $this->data->setTitle($event->review->game->name);
        $this->data->setUrl(route('game.review', [
            'gameSlug' => $event->review->game->slug,
            'userSlug' => $event->review->user->slug
        ]));
        $this->data->setDescription($event->review->text);
        $this->data->setThumbnail($event->review->game->getCover('150x185'));
        $this->data->setFields([
            [
                'name' => 'Nota',
                'value' => str_replace('.', ',', $event->review->rating->score),
                'inline' => true
            ],
            [
                'name' => 'Plataforma',
                'value' => $event->review->platform->name,
                'inline' => true
            ]
        ]);
        $this->data->setFooter([
            'text' => $event->review->user->name,
            'icon_url' => $event->review->user->getPicture('34x34')
        ]);

        return json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}