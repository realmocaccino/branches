<?php
namespace App\Console\Helpers;

use App\Console\Clients\YoutubeClient;

class YoutubeHelper
{
    private $client;

	public function __construct(YoutubeClient $client)
	{
        $this->client = $client;
	}
	
	public function searchVideos(array $terms)
    {
        $response = $this->client->search(
            'id, snippet',
            implode(' ', $terms),
            'video'
        );

        return $response['items'];
    }
}