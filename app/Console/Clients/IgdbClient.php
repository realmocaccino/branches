<?php
namespace App\Console\Clients;

use App\Console\Exceptions\ApiNoResponseException;
use App\Console\Services\IgdbClientAuthenticator;

class IgdbClient
{
    private $authenticator;

	private $clientId;
	private $url;

	public function __construct(IgdbClientAuthenticator $authenticator)
	{
        $this->authenticator = $authenticator;

        $this->clientId = config('services.igdb.client_id');
		$this->url = config('services.igdb.url');
    }
	
	public function request($endpoint, $fields, $limit = 10, $where = null, $search = null)
    {
        $response = $this->apiRequest($endpoint, $this->preparePostFields($fields, $limit, $where, $search));

        if ($response) {
            return $response;
        }
        
        throw new ApiNoResponseException('No response from IGDB' . PHP_EOL);
    }

    private function preparePostFields($fields, $limit, $where, $search)
    {
        $postFields =  "fields " . implode(',', $fields) . ";limit " . $limit . ";";
        if($where) $postFields .= "where $where;";
        if($search) $postFields .= "search $search;";

        return $postFields;
    }

    private function apiRequest($endpoint, $postFields)
    {
        $this->authenticator->authenticate();

        $curl = curl_init($this->url . '/' . $endpoint);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Client-ID: ' . $this->clientId,
            'Authorization: Bearer ' . $this->authenticator->getAccessToken()
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}