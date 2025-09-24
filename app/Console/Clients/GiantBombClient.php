<?php
namespace App\Console\Clients;

use App\Console\Exceptions\{ApiErrorResponseException, ApiNoResponseException};

class GiantBombClient
{
	private const FORMAT = 'json';

	private $apiKey;
	private $apiUrl;
	
	protected $limit = 10;

	public function __construct()
	{
		$this->apiKey = config('services.giantbomb.key');
		$this->apiUrl = config('services.giantbomb.url');
	}

    public function setLimit($limit)
    {
        $this->limit = $limit;

        return $this;
    }
	
	public function request($endpoint, $queryString = null)
	{
		$response = $this->apiRequest($endpoint, $queryString);

        if($response) {
		    if($response->error == 'OK') {
			    return $response->results;
		    } else {
			    throw new ApiErrorResponseException($response->error);
		    }
		} else {
			throw new ApiNoResponseException('No response from Giant Bomb' . PHP_EOL);
		}
	}

	private function apiRequest($endpoint, $queryString)
	{
		$curl = curl_init($this->apiUrl . '/' . $endpoint . '/?api_key=' . $this->apiKey . '&format=' . self::FORMAT . '&limit=' . $this->limit . '&' . $queryString);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_USERAGENT, 'API Test UA');
		$response = curl_exec($curl);
		curl_close($curl);

		return json_decode($response);
	}
}
