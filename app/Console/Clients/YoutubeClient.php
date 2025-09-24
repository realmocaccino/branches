<?php
namespace App\Console\Clients;

use Google_Client, Google_Service_YouTube;

class YoutubeClient
{
	protected $limit = 5;

	public function __construct(Google_Client $google)
	{
        $google->setDeveloperKey(config('services.google.key'));
        $this->youtube = new Google_Service_YouTube($google);
	}

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }

	public function search($scopes, $terms, $type)
	{
		return $this->youtube->search->listSearch($scopes, [
            'q' => $terms,
			'type' => $type,
            'maxResults' => $this->limit
        ]);
	}
}
